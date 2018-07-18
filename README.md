# infracamp viper-smtpd :: Ready to use mail relay container

- Relay Host
- SASL Authentication
- Designed to
    - Relay mail from smtp clients (Applications / Websites)

- See the configuration files
    - [postfix/main.cf](etc/postfix/main.cf)

## Running the container

Create a `smtp-config.json` and adjust ist to your needs. ([See demo.json](doc/demo-smtp-conf.json))

```
{
    "mynetworks": "127.0.0.1",
    "sasl_users": [
        "user:crypted_passwd:sender@domain1.de,@domain2.de"
        "nextUser:crypted_passwd:allowed@domain2.de"
    ]
}
```


```
docker run --net host -e CONF_JSON=$(printf %q "`cat smtp-config.json`") infracamp/cobra-smtp
```

or use

```
awk '1' [input-file.json]
```

to create a string representation to put into env-File


## Creating Passwords


## Logging

The container comes with `syslog-ng` for logging. Syslog-NG must be
reconfigured to work correctly in containers:

```
sudo sed -i 's/#SYSLOGNG_OPTS=\"--no-caps\"/SYSLOGNG_OPTS=\"--no-caps\"/' /etc/default/syslog-ng
```


## References

- [Postfix SASL](http://www.postfix.org/SASL_README.html)
