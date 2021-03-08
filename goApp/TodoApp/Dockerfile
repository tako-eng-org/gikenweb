FROM golang:1.15-alpine as dev

RUN apk update \
  && apk add --no-cache git \
  && apk add --no-cache tzdata \
  && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
  && apk del tzdata

ARG APP_DIR=app

COPY ./ /${APP_DIR}
WORKDIR /${APP_DIR}

EXPOSE 8080

ENTRYPOINT [ "/app/docker-entrypoint.sh" ]
CMD [ "/sbin/init" ]
