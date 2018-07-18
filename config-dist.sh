#!/usr/bin/env bash

sudo postconf myhostname=$CONF_HOST
sudo postconf myorigin=$CONF_HOST

sudo postconf mynetworks="$CONF_MY_NETWORKS"
sudo postconf local_recipient_maps=

sudo postconf smtputf8_enable=no
sudo postconf smtputf8_autodetect_classes=bounce


cd /etc/ssl/certs
sudo openssl req -x509 -newkey rsa:4096 -keyout key.pem -out cert.pem -days 365 -nodes -subj '/CN=$CONF_HOST'
sudo postconf smtpd_tls_cert_file=/etc/ssl/certs/cert.pem
sudo postconf smtpd_tls_key_file=/etc/ssl/certs/key.pem
sudo mv cert.pem /etc/ssl/certs/cert.pem
sudo mv key.pem /etc/ssl/certs/key.pem

#sudo echo 'pass' > /etc/ssl/certs/key.pem

sudo apt-get install net-tools

echo 'Starting syslog-ng...'
sudo service syslog-ng start

sudo service postfix reload
echo 'Starting Postifx...'
sudo service postfix start