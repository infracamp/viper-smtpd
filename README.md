# infracamp viper-smtpd :: Ready to use mail relay container

- SMTP Relay Host
- SASL Authentication
- Restrict sender addresses by sasl-auth
- Designed to
    - Relay mail from smtp clients (Applications / Websites)
    - MX
- See the configuration files
    - [postfix/main.cf](etc/postfix/main.cf)
- [Lessons learned creating this container](doc/LESSONS_LEARNED.md)

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

To start the container in production mode just call:

```
docker run --net host -e CONF_JSON=$(printf %q "`cat smtp-config.json`") infracamp/viper-smtpd
```

or use

```
awk '1' [input-file.json]
```

to create a string representation to put into env-File


## Creating Passwords


## Contributing

Help us developing this container. To start the container just run `./kickstart.sh`.

## References

- [Postfix SASL](http://www.postfix.org/SASL_README.html)
