#!/bin/sh
echo "-----`basename $0`-----"

echo "-----realize install start-----"
GO111MODULE=off go get github.com/oxequa/realize;
echo "-----realize installed-----"

# go.modをgo build時に実行するための環境変数設定
export GO111MODULE=on

echo "-----realize start-----"
realize start