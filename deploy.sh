#!/bin/bash

##
# WP-Term Deployment Script
##

deploy_dir=""
while getopts ":d:" opt
do
  case $opt in
    d)
      deploy_dir=$OPTARG
      ;;
    \?)
      echo "Invalid argument -$OPTARG"
      ;;
  esac
done

if [ -z "$deploy_dir" ]; then
  echo -n "Enter deployment directory: "
  read deploy_dir
fi

# Relative to absolute path
deploy_dir=`readlink -m $deploy_dir`

echo "Deployment directory set to: $deploy_dir"

if [ ! -d "$deploy_dir/wp-content/themes" ]; then
  echo "Invalid deployment directory. Theme directory"\
    "'$deploy_dir/wp-content/themes' does not exist."
  exit 1
fi

exit 0
