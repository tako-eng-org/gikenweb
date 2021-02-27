package main

import (
	// ロギングを行うパッケージ
	"log"

	// HTTPを扱うパッケージ
	"net/http"

	// Gin
	"github.com/gin-gonic/gin"

	//// postgresql用ドライバ
	_ "github.com/jinzhu/gorm/dialects/postgres"

	// コントローラー
	controller "server/controllers/controller"
)

func main() {
	// サーバーを起動する
	serve()
}

func serve() {
	// デフォルトのミドルウェアでginのルーターを作成
	// Logger と アプリケーションクラッシュをキャッチするRecoveryミドルウェア を保有しています
	router := gin.Default()

	// 静的ファイルのパスを指定
	router.Static("/dist", "./frontend/dist")

	// ルーターの設定
	// URLへのアクセスに対して静的ページを返す
	router.StaticFS("/bbsapp", http.Dir("./frontend/dist"))

	// 全てのJSONを返す
	router.GET("/fetchAllRecords", controller.FetchAllRecords)

	router.NoRoute(func(c *gin.Context) {
		c.JSON(http.StatusNotFound, gin.H{"message": "Page not Found!!"})
	})

	if err := router.Run(":8085"); err != nil {
		log.Fatal("Server Run Failed.: ", err)
	}

}
