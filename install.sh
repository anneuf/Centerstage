#!/bin/sh
#
# Install script for Centerstage on Raspi2.
# Clock module DS3231 used.
#

echo
echo "####  Global Settings  ####"
echo

conf/global.sh

echo 
echo "<--Done-->"
echo

echo
echo "####  Update System  ####"
echo

apt-get -y update
apt-get -y upgrade

echo 
echo "<--Done-->"
echo

echo
echo "####  Install Applications  ####"
echo

apt-get -y install midori matchbox-window-manager xterm apache2 php5 sqlite3 php5-sqlite x11-xserver-utils unclutter i2c-tools python-dev python-pip
pip install evdev

echo 
echo "<--Done-->"
echo

echo
echo "####  Enable RTC  ####"
echo

cat conf/modules >> /etc/modules

echo ds3231 0x68 | tee /sys/class/i2c-adapter/i2c-1/new_device

echo 
echo "<--Done-->"
echo

echo
echo "####  Disable NTP and fake-hwclock  ####"
echo

update-rc.d ntp disable
update-rc.d fake-hwclock disable

echo 
echo "<--Done-->"
echo

echo
echo "####  Configure Boot  ####"
echo

cat conf/rc.local > /etc/rc.local


echo 
echo "<--Done-->"
echo

echo
echo "####  Configure WiFi  ####"
echo

conf/install_wpa.sh

echo 
echo "<--Done-->"
echo

echo
echo "####  Copy Scripts  ####"
echo

cp sbin/* /usr/local/sbin/
cp conf/resolvconf.conf /etc/

echo 
echo "<--Done-->"
echo

echo
echo "####  Copy Content  ####"
echo

cp -r www/* /var/www/html

chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html

echo 
echo "<--Done-->"
echo

echo
echo "####  Compile&Install Keyboard-Daemon  ####"
echo

copy conf/read_key.py /usr/local/sbin/
chmod 777 /usr/local/sbin/read_key.py
copy conf/readkey.service /lib/systemd/system/
chmod 644 /lib/systemd/system/readkey.service
systemctl enable readkey

echo 
echo "<--Done-->"
echo

echo "Installation complete"

shutdown -r now
