#!/bin/bash
# DO7EN 22.12.2020
# Please create this script as a cron job for the user svxlink.
# The path indicates where the config from the dashboard is located.
#
# su svxlink
# crontab -e
# 8 * * * * nice /home/svxlink/html/svxrdb/checkupdate.sh >/dev/null 2>&1

DIRECTORY=/home/svxlink/html/svxrdb
VERSION=$(wget -qO- https://raw.githubusercontent.com/sm0svx/svxlink/master/src/versions | grep "SVXLINK=" | cut -d"=" -f2)
# attention !!! -i write direct to file..remove -i for testing
sed -i 's/SVXLINKVERSION.*$/SVXLINKVERSION\"\,\ \"'$VERSION'\"\ \)\;/' $DIRECTORY/config.php

