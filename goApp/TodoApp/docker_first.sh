#!/bin/sh

# realize(ホットリロード)を取得する
GO111MODULE=off go get github.com/oxequa/realize

# go.modをgo build時に実行するための環境変数設定
export GO111MODULE=on

realize start