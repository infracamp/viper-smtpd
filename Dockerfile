FROM infracamp/kickstart-flavor-gaia:testing

ENV DEV_CONTAINER_NAME="viper-smtpd"

ADD / /opt
RUN ["bash", "-c",  "chown -R user /opt"]
RUN ["/kickstart/container/start.sh", "build"]

ENTRYPOINT ["/kickstart/container/start.sh", "standalone"]