/* keyscfg - keysid configuration program
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

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <getopt.h>
#include <linux/input.h>
#include <sys/types.h>
#include <sys/stat.h>
#include <fcntl.h>

#define D_CONF "/etc/keysid/keysid.conf"
#define D_DEV "/dev/input/event0"
#define USAGE "Usage: %s <-n keysnumber> [-f config_file] [-d device]\n"

#define FATAL(x,args...) { fprintf(stderr,x,##args); exit(1); }

extern char *optarg;
extern int optind, opterr, optopt;

FILE *conffp;
int devfd;
struct input_event kbd;

int main(int argc, char *argv[]){
	int z;
	unsigned int i, autokill = 1, keynumber, twice, *keys;
	char *config = D_CONF, *device = D_DEV;

	opterr=0;
	while((z = getopt(argc,argv,"n:f:d:")) != -1 ){
		switch(z){
			case 'n':
				keynumber = (unsigned int) atoi(optarg);
				autokill = 0;
				break;
			case 'f':
				config = (char *) malloc(strlen(optarg)+1);
				strcpy(config,optarg);
				break;
			case 'd':
				device = (char *) malloc(strlen(optarg)+1);
				strcpy(device,optarg);
				break;
			case '?':
				FATAL("Unrecognized option -%c\n" USAGE,optopt,argv[0]);
				break;
			default:
				FATAL(USAGE, argv[0]);
		}
	}

	if(autokill)
		FATAL("Missing option -n\n" USAGE, argv[0]);

	if((conffp = fopen(config,"w")) == NULL)
		FATAL("Can't open %s\n", config);

	keys = (unsigned int *) malloc( sizeof(unsigned int) * keynumber);

	/* Initial delay */
	printf("Don't press any key!! Wait for a while..\n");
	sleep(1);

	if((devfd = open(device, O_RDONLY)) == -1)
		FATAL("Can't open %s\n", device);

	printf("Press and release now the keys sequentially\n");

	/* Getting the keys */
	for(i = 0, twice = 1; i < keynumber; ) {
		if(read(devfd, &kbd, sizeof(struct input_event)) == -1)
			FATAL("Error while reading from %s\n", device);

		if(kbd.type == 4 && kbd.code == 4){
			if(twice){
				keys[i++] = kbd.value;
				printf("Key 0x%x intercepted\n", kbd.value);
			}
			twice = !twice;
		}

	}
	close(devfd);


	fprintf(conffp, "%s\n", device);
	fprintf(conffp, "0 dude mpg123 ~/wakeup.mp3\n");
	for(i = 0; i < keynumber; i++){
		fprintf(conffp,"0x%x dude command%d\n", keys[i], i+1);
	}

	fclose(conffp);

	return 0;

}
