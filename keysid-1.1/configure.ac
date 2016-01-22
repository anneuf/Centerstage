#                                               -*- Autoconf -*-
# Process this file with autoconf to produce a configure script.

AC_PREREQ(2.60)
AC_INIT(keysid, 1.1, scrows@oziosi.org)
AM_INIT_AUTOMAKE([-Wall])
AC_CONFIG_SRCDIR([keysid.c])
AC_CONFIG_HEADER([config.h])

# Checks for programs.
AC_PROG_CC
AC_PROG_INSTALL

# Checks for libraries.

# Checks for header files.
AC_HEADER_STDC
AC_HEADER_SYS_WAIT
AC_CHECK_HEADERS([fcntl.h stdlib.h string.h unistd.h])

# Checks for typedefs, structures, and compiler characteristics.
AC_C_CONST
AC_TYPE_UID_T
AC_TYPE_INT32_T
AC_TYPE_MODE_T
AC_TYPE_OFF_T
AC_TYPE_PID_T
AC_TYPE_SIZE_T
AC_TYPE_SSIZE_T
AC_CHECK_MEMBERS([struct stat.st_blksize])
AC_STRUCT_ST_BLOCKS
AC_CHECK_MEMBERS([struct stat.st_rdev])
AC_CHECK_DECLS([sys_siglist])
AC_HEADER_TIME
AC_STRUCT_TM
AC_STRUCT_TIMEZONE

# Checks for library functions.
AC_FUNC_ALLOCA
AC_FUNC_CHOWN
AC_FUNC_FORK
AC_FUNC_GETGROUPS
AC_FUNC_GETPGRP
AC_PROG_GCC_TRADITIONAL
AC_FUNC_LSTAT
AC_FUNC_LSTAT_FOLLOWS_SLASHED_SYMLINK
AC_FUNC_MALLOC
AC_FUNC_MEMCMP
AC_FUNC_MKTIME
AC_FUNC_REALLOC
AC_FUNC_SELECT_ARGTYPES
AC_FUNC_SETPGRP
AC_FUNC_SETVBUF_REVERSED
AC_TYPE_SIGNAL
AC_FUNC_STAT
AC_FUNC_STRCOLL
AC_FUNC_STRERROR_R
AC_FUNC_STRFTIME
AC_FUNC_STRTOD
AC_FUNC_VPRINTF
AC_FUNC_WAIT3
AC_CHECK_FUNCS([alarm atexit bzero clock_gettime dup2 fchdir fdatasync ftruncate getcwd gethostname getpagesize getpass gettimeofday getusershell lchown localtime_r mblen memchr memmove memset mkdir mkfifo pathconf putenv realpath rmdir rpmatch select setenv sethostname stime strcasecmp strchr strcspn strdup strerror strncasecmp strpbrk strrchr strspn strstr strtol strtoul strtoull tzset])

AC_CONFIG_FILES([Makefile])
AC_OUTPUT
