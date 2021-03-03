#!/bin/sh
echo "-----`basename $0`-----"

# realize(ホットリロード)を取得する
echo "-----realize install start-----"
GO111MODULE=off go get github.com/oxequa/realize;
echo "-----realize installed-----"

# go.modをgo build時に実行するための環境変数設定
export GO111MODULE=on

# アプリサーバをバックグラウンドで実行する
# realizeでgo run serverを監視するので不要
#go run server.go &

# realize起動。realize start --serverするとブラウザアクセスもホットリロードもできない2021/03/03
echo "-----realize start-----"
realize start