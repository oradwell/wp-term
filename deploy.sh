#!/bin/bash

##
# WP-Term Deployment Script
##

integrations_dir="`dirname $0`/theme-integrations"
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

while [ -z "$deploy_dir" ]
do
  echo -n "Enter deployment directory: "
  read deploy_dir
done

# Relative to absolute path
deploy_dir=`readlink -m $deploy_dir`

echo "Deployment directory set to: $deploy_dir"

themedir="$deploy_dir/wp-content/themes"
if [ ! -d "$themedir" ]; then
  echo "Invalid deployment directory. Theme directory"\
    "'$themedir' does not exist." >&2
  exit 1
fi

for theme in "$integrations_dir/[^common]*"
do
  themename=`basename $theme`
  cp $integrations_dir/common/wpterm.js $themedir/$themename/js/
  cp -a $theme/* "$themedir/$themename"
done

exit 0
