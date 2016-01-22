/* keysid - keys intercepting daemon
 * Copyright (C) 2005, 2006 Daniele Sempione <scrows at oziosi.org>
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 */

#define _GNU_SOURCE
#include <stdio.h>
#include <stdlib.h>
#include <stdarg.h>
#include <string.h>
#include <unistd.h>
#include <signal.h>
#include <linux/input.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <sys/wait.h>
#include <fcntl.h>
#include <time.h>
#include <errno.h>

void setsigh(int currsig);
void Error(const char *fmt, ...);
void child_exit();
void alarmit();
void daemon_exit();

#define NSEC 300000000 /* 0.3 seconds */
#define SU "su"
#define D_CONF "/etc/keysid/keysid.conf"
#define LOGFILE "/var/log/keysid.log"

#define FATAL(x,args...) { Error(x,##args); exit(1); }

struct keys {
	unsigned int key;
	char *command;
	pid_t pid;
	struct keys *next;
} *head, *curr, *temp;

struct cexit {
	int status;
	char *prog;
} exitstat;

struct timeout {
	unsigned int sec;
	char *command;
	pid_t pid;
} tout = {0, 0, 0};

FILE *conffp, *logfp;
int devfd, errno;
unsigned int remaining;
struct timespec odelay = {0, 0}, idelay = {0, NSEC};
struct input_event kbd;
struct sigaction child_sig;
sigset_t child_sigset;

/* set signals' handlers */
void setsigh(int currsig){
sigintr:
	if(sigaction(currsig, &child_sig, NULL) == -1) {
		if(errno == EINTR)
			goto sigintr;
		else
			FATAL("Can't handle %s. errno [%d]\n", strsignal(currsig), errno);
	}
}

/* logging function */
void Error(const char *fmt, ...){
	va_list arg;
	long int uepoch;
	struct tm *systime;

	va_start(arg, fmt);

	uepoch = time(NULL);
	systime = localtime (&uepoch);

	fprintf(logfp,"[%u/%0u/%0u %0u:%0u:%0u] ", systime->tm_year + 1900,
			systime->tm_mon, systime->tm_mday, 
			systime->tm_hour, systime->tm_min,
			systime->tm_sec);
	vfprintf(logfp, fmt, arg);
	fflush(logfp);

	va_end(arg);
}

/* signals handlers */
void child_exit(){
	int stat, cpid;

	while ((cpid = waitpid(-1, &stat, WNOHANG)) > 0) {
		temp = curr;
		curr = head;

		do {
			if(cpid == tout.pid) {
				tout.pid = 0;
				if(WIFEXITED(stat) && WEXITSTATUS(stat)){
					exitstat.status = WEXITSTATUS(stat);
					exitstat.prog = tout.command;
				}
				break;
			}
			if(cpid == curr->pid) {
				curr->pid = 0;
				if(WIFEXITED(stat) && WEXITSTATUS(stat)){
					exitstat.status = WEXITSTATUS(stat);
					exitstat.prog = curr->command;
				}
				break;
			}
			curr = curr->next;
		} while (curr != head);

		curr = temp;
	}
}

void alarmit(){
	unsigned int temprem;
	
	if(tout.pid)
		return;
	
	temprem = alarm(0);
	if(temprem < remaining) {
		remaining = temprem;
		alarm(remaining);
	}
	
	sigprocmask(SIG_BLOCK, &child_sigset, NULL);
	if((tout.pid = fork()) == -1)
		FATAL("Can't Fork. The program \"%s\" won't be executed\n",
				tout.command);
	if(!tout.pid)
		exit( WEXITSTATUS( system(tout.command) ) );

	remaining = tout.sec;
	alarm(tout.sec);
	sigprocmask(SIG_UNBLOCK, &child_sigset, NULL);
}

void daemon_exit(){
	fclose(logfp);
	close(devfd);
	exit(0);
}



int main(int argc, char *argv[]){
	unsigned int i, twice = 1;
	char *config = D_CONF, *device, *tmpuser, *tmpcommand;

	daemon(0,0);
	logfp = fopen(LOGFILE, "a");

	if(argc > 1)
		config = argv[1];

	if((conffp = fopen(config, "r")) == NULL)
		FATAL("Can't open \"%s\"\n", config);
	fscanf(conffp, "%a[^\n]", &device);

	/* reading timeout command */
	fscanf(conffp, "%u %as %a[^\n]", &tout.sec, &tmpuser, &tmpcommand);
	if(tout.sec)
		asprintf(&tout.command, "%s - \"%s\" -c \"%s\"",
				SU, tmpuser, tmpcommand);

	/* reading keys' commands */
	curr = head = (struct keys *) malloc(sizeof(struct keys));
	i = 0;
	while(fscanf(conffp, "%x %as %a[^\n]", &curr->key, &tmpuser, &tmpcommand) == 3){
		temp = curr;
		curr->pid = 0;
		/* I've no intent in reinventing the wheel */
		asprintf(&curr->command, "%s - \"%s\" -c \"%s\"",
				SU, tmpuser, tmpcommand);

		curr->next = (struct keys *) malloc(sizeof(struct keys));
		curr = curr->next;
		i++;
	}

	fclose(conffp);

	if(!i)
		FATAL("\"%s\" isn't a regular configuration file\n", config);

	free(curr);
	temp->next = head;

	curr = head;

	/* initial delay */
	do {
		if(nanosleep(&idelay, &odelay) == -1)
			idelay.tv_nsec = odelay.tv_nsec;
		else
			idelay.tv_nsec = 0;
	} while (idelay.tv_nsec);

	devfd = open(device, O_RDONLY);

	child_sig.sa_handler = child_exit;
	child_sig.sa_flags = 0;
	sigemptyset(&child_sig.sa_mask);

	setsigh(SIGCHLD);

	child_sig.sa_handler = daemon_exit;
	setsigh(SIGTERM);

	if(tout.sec) {
		child_sig.sa_handler = alarmit;
		setsigh(SIGALRM);
	}

	sigemptyset(&child_sigset);
	sigaddset(&child_sigset, SIGCHLD);

	exitstat.status = 0;

	if(tout.sec) {
		remaining = tout.sec;
		alarm(tout.sec);
	}

	while(1) {
		if(exitstat.status) {
			Error("Program \"%s\" returned non-zero exit status [%d]\n",
					exitstat.prog , exitstat.status);
			exitstat.status = 0;
		}

mainread:
		if(read(devfd, &kbd, sizeof(struct input_event)) == -1) {
			if(errno == EINTR)
				goto mainread;
			else
				FATAL("Error while reading from \"%s\"\n", device);
		}

		if(tout.sec)
			alarm(tout.sec);

		if(kbd.type == 4 && kbd.code == 4){
			if(twice){ /* I'm not interested in keys release */
				do {
					if(curr->key == kbd.value){
						if(curr->pid)	/* Am I already running? */
							goto skip;

						sigprocmask(SIG_BLOCK, &child_sigset, NULL);
						if((curr->pid = fork()) == -1)
							FATAL("Can't Fork. The program \"%s\" won't be executed\n",
									curr->command);
						if(!curr->pid)
							exit( WEXITSTATUS( system(curr->command) ) );

						sigprocmask(SIG_UNBLOCK, &child_sigset, NULL);
skip:
						curr = head;
						break;
					}
					curr = curr->next;
				} while (curr != head);
			}
			twice = !twice;
		}
	}

	
	return 0;

}
