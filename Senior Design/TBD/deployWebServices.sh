#!/bin/bash


#============================================
# This is part 2 of updating the web services on the grad trackers server. 
# User part 1 called moveToOnyx.sh from a local directory on your machine
# This script will pull the tared up web services from your onyx account and deploy them in #/var/www/html
#
# PARAMS
#
# 1: username on onyx
# 
#============================================


THIS=$0
ONYXUSERNAME=$1

if [ "$EUID" -ne 0 ]; then
    echo "Please run this script with root privileges (sudo)"
    exit 1
fi

function usage() {
        echo "${THIS} <onyx user name>" 
}

if (( $# < 1 )); then
        usage
        exit 0
fi

#removing directories currently in the html directory.
rm -rf /var/www/html/*

echo "files deleted."
echo "Now updating files, by pulling from your onyx."

#pulling files from onyx. 
scp -r "${ONYXUSERNAME}"@onyx.boisestate.edu:~/Desktop/webServices.tar.gz /var/www/html/

tar -xvzf /var/www/html/webServices.tar.gz -C /var/www/html/

echo done
