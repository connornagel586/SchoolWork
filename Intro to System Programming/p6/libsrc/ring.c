#include <string.h>
#include <stdio.h>
#include <time.h>
#include <ring.h>
#include <signal.h>
#include <unistd.h>

static struct {
    int curr;
    char log[MAX_LOG_ENTRY][MAX_STRING_LENGTH];
} buff;

int j = 0;
static void onalarm(int signo);
void dump_buffer();
FILE *fs;
void init_buffer()
{
    printf("Initialize the ring buffer\n");
    int i;
    for(i = 0; i < MAX_LOG_ENTRY; i++) {
        buff.log[i][0]='\0';
    }
	buff.curr = 0; 
	signal(SIGALRM, onalarm);
	alarm(alarm_interval - 1);
    	fs = fopen(log_name, "w");
}

//get the current timestamp (localtime) from the system
static char *getTimeString() 
{
    time_t myTime;
    myTime = time(NULL); //this is a system call
	char *timeString = ctime(&myTime);
	timeString[strlen(timeString)-1] = '\0'; //erase the newline at the end
	return timeString;
}


void log_msg(char *entry)
{
	if (entry == NULL) {
		printf("Skipping null log entry!\n");
		return;
	}

	char *timeString = getTimeString();
    printf("Adding log entry into buffer\n");
    int idx = buff.curr % MAX_LOG_ENTRY;
    strncpy(buff.log[idx], timeString, MAX_STRING_LENGTH - 1);
    strncat(buff.log[idx], " -- ", 4);
    strncat(buff.log[idx], entry, MAX_STRING_LENGTH - strlen(timeString) - 4);

    /*
     * From the documentation of strncpy/strncat:
     * No null-character is implicitly appended at the end of destination
     * if source is longer than num. Thus, in this case, destination shall
     * not be considered a null terminated C string
     * (reading it as such would overflow).
     *
     * Thus we need to make sure that we null terminate the string;
     */
    buff.log[idx][MAX_STRING_LENGTH - 1]='\0';
    buff.curr++;
}

static void onalarm(int signo){

dump_buffer();
alarm(alarm_interval - 1);
}

/*
 * Right now this is just printing to the console. We want to change this to
 * write to a file (log_name) and we want to use signals to trigger the logging
 * event. This also needs to be fixed so that it prints the log messages in the
 * right order (from the oldest to the newest).
 *
 * This method should write all the current entries to disk in the right order 
 * (from the oldest to the newest). We will use the constant log_name as the 
 * name of the file.
 */
void dump_buffer()
{
    int i;
    for(i = 0; i < MAX_LOG_ENTRY; i++) {
       fprintf(fs, "log %d: %s\n", j , buff.log[(buff.curr + i) % MAX_LOG_ENTRY]);
 	j++;   
}
}

fclose(fs);




