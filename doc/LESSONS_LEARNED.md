# Lessons learned

## syslog-ng 

The container comes with `syslog-ng` for logging. Syslog-NG must be
reconfigured to work correctly in containers:

```
sudo sed -i 's/#SYSLOGNG_OPTS=\"--no-caps\"/SYSLOGNG_OPTS=\"--no-caps\"/' /etc/default/syslog-ng
```

## Deactivate chroot

See `master.cf` (n in chroot column). Otherwise smtpd will not be
able to access `/etc/sasldb2` - the db-file where sasl-user/passwords
are stored.


## Turn on verbose logging

Append a `-v` to the `smtpd` command in [postfix/master.cf](../etc/postfix/master.cf)

