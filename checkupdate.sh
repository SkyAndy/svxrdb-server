#!/bin/bash
# DK1LO 31.12.2024
# Please create this script as a cron job for the user svxlink.
# The path indicates where the config from the dashboard is located.
#
# su svxlink
# crontab -e
# 8 * * * * nice /var/www/html/svxrdb-server/checkupdate.sh >/dev/null 2>&1

WWWDIRECTORY=/var/www/html/svxrdb-server
SVXL_VERSION=$(wget -qO- https://raw.githubusercontent.com/sm0svx/svxlink/master/src/versions | grep "SVXLINK=" | cut -d"=" -f2)
# attention !!! -i write direct to file..remove -i for testing
sed -i 's/SVXLINKVERSION.*$/SVXLINKVERSION\"\,\ \"'$SVXL_VERSION'\"\ \)\;/' $WWWDIRECTORY/config.php

# add your own source directory
SRC_DIRECTORY=/home/svxlink/svxlink/src
SVXR_VERSION=$(wget -qO- https://raw.githubusercontent.com/sm0svx/svxlink/master/src/versions | grep "SVXREFLECTOR=" | cut -d"=" -f2)
SVXR_VERSION_LOCAL=$(grep SVXREFLECTOR $SRC_DIRECTORY/versions | cut -d "=" -f2)
# attention !!! -i write direct to file..remove -i for testing
sed -i 's/SVXREFLECTORVERSION.*$/SVXREFLECTORVERSION\"\,\ \"'$SVXR_VERSION'\ -> '$SVXR_VERSION_LOCAL'\"\ \)\;/' $WWWDIRECTORY/config.php
