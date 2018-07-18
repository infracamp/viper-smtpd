# Lessons learned

## syslog-ng 

The container comes with `syslog-ng` for logging. Syslog-NG must be
reconfigured to work correctly in containers:

```
sudo sed -i 's/#SYSLOGNG_OPTS=\"--no-caps\"/SYSLOGNG_OPTS=\"--no-caps\"/' /etc/default/syslog-ng
```
