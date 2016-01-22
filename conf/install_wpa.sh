echo "ctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev" > /etc/wpa_supplicant/wpa_supplicant.conf
echo "update_config=1" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo " " >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "network={" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        ssid=\"winwets\"" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        psk=\"IrrerIvan\"" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        proto=RSN" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        key_mgmt=WPA-PSK" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        pairwise=CCMP" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        auth_alg=OPEN" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "}" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo " " >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "network={" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        ssid=\"winwets\"" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        psk=\"IrrerIvan\"" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        proto=RSN" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        key_mgmt=WPA-PSK" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        pairwise=TKIP" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "        auth_alg=OPEN" >> /etc/wpa_supplicant/wpa_supplicant.conf
echo "}" >> /etc/wpa_supplicant/wpa_supplicant.conf

