FROM golang:1.15-alpine as dev

RUN apk update \
  && apk add --no-cache git

ARG APP_DIR=app

COPY ./ /${APP_DIR}
WORKDIR /${APP_DIR}

EXPOSE 8085

ENTRYPOINT [ "/app/docker-entrypoint.sh" ]
CMD [ "/sbin/init" ]
