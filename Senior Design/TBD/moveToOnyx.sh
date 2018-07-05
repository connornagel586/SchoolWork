#!/bin/bash

#===================================
#This script is part one of a two part process to update 
#web services on the grad tracker server. It's super ugly and
#has a lot of hard code in it. So when you run this script, log into
#the grad tracker server and run the deployWebServices.sh in your directory.
#
#
# PARAMS
# 1: onyx user name exp. johnnyappleseed
#
#===================================


THIS=$0
ONYXUSERNAME=$1

function usage() {
	echo "${THIS} <onyx user name>" 
}

if (( $# < 1 )); then
	usage
	exit 0
fi

echo "tar up web services"
tar -czvf webServices.tar.gz *.css *.php *.jpg *.png *.html *.js *.sql

echo "copy web services to ~/Desktop on your onyx."
scp webServices.tar.gz "${ONYXUSERNAME}"@onyx.boisestate.edu:~/Desktop

rm webServices.tar.gz

echo "done, now log into the grad tracker server and run deployWebServices.sh on /home/<student name>/" 
