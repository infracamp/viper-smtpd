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
- [Dockerhub project page](https://hub.docker.com/r/infracamp/viper-smtpd/)


## Running the container

Create a `smtp-config.json` and adjust ist to your needs. ([See demo.json](doc/demo-smtp-conf.json))

```
{
    "myhostname": "smtp.demo.host",
    "mynetworks": "127.0.0.1",
    "sasl_users": [
        "user1@domain.de:passwd:sender@domain1.de,@domain2.de"
        "user2@domain.de:passwd:@domain2.de"
    ]
}
```

To start the container in production mode just call:

```
docker run --net host -e "CONF_JSON=$(tr -d \'\\n\' < doc/smtp-config.json)" infracamp/viper-smtpd
```

or use

```
tr -d '\n' < doc/smtp-config.json
```

to create a string representation to put into env-File


## Why is it highly recommend to run the container run in `--net host`-mode

- Only in `--net host` the container sees the real remote ip
- Only in `--net host` the container can see its read hostname

## Creating Passwords

Passwords are stored in plain text so support digest-* authentication.

## Contributing

Help us developing this container. To start the container just run `./kickstart.sh`.

## References

- [Postfix SASL](http://www.postfix.org/SASL_README.html)
