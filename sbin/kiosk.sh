#!/bin/sh
unclutter &
matchbox-window-manager & :
xset -dpms
xset s off
while true; do
/usr/bin/midori -e Fullscreen -a http://localhost/cstage/cstage.php
done
