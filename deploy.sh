#!/bin/bash

##
# WP-Term Deployment Script
##

if ! command -v patch > /dev/null 2>&1; then
  echo "patch command is required for deployment." 1>&2
  exit 1
fi

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

mkdir -p "$deploy_dir/wp-term"
cp -a config/ src/ bootstrap.php wp-term.php "$deploy_dir/wp-term"

for theme in "$integrations_dir/[^common]*"
do
  themeloc=`readlink -m $theme`
  themename=`basename $theme`
  cp $integrations_dir/common/wpterm.js $themedir/$themename/js/
  cp -a $theme/css "$themedir/$themename/"
  patch -N -r - -p1 -d "$deploy_dir" < $themeloc/patch
done

exit 0
