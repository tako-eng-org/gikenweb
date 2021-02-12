FROM golang:1.15-alpine as dev

RUN apk update \
  && apk add --no-cache git

# goのパッケージ増やす時(go get)はここに追加して再度ビルド
RUN go get github.com/gin-gonic/gin \
  && go get github.com/jinzhu/inflection \
  && go get github.com/jinzhu/gorm/dialects/postgres \
  && go get github.com/joho/godotenv

ARG APP_DIR=app

COPY ./ /${APP_DIR}
WORKDIR /${APP_DIR}

EXPOSE 8080
