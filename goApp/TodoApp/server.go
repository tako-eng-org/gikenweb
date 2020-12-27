package main

import (
	// ロギングを行うパッケージ
	"log"

	// HTTPを扱うパッケージ
	"net/http"

	// Gin
	"github.com/gin-gonic/gin"

	//// MySQL用ドライバ
	//_ "github.com/jinzhu/gorm/dialects/mysql"

	// コントローラー
	controller "./controllers/controller"
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
	router.Static("/views", "./views")

	// ルーターの設定
	// URLへのアクセスに対して静的ページを返す
	router.StaticFS("/todoapp", http.Dir("./views/static"))

	// 全てのTodoリスト情報のJSONを返す
	router.GET("/fetchAllTodos", controller.FetchAllTodos)

	// １つのTodoリスト情報の状態のJSONを返す
	router.GET("/fetchTodo", controller.FindTodo)

	// Todoリスト情報をDBへ登録する
	router.POST("/addTodo", controller.AddTodo)

	// Todoリスト情報の状態を変更する
	router.POST("/changeStateTodo", controller.ChangeStateTodo)

	// Todoリスト情報を削除する
	router.POST("/deleteTodo", controller.DeleteTodo)

	if err := router.Run(":8080"); err != nil {
		log.Fatal("Server Run Failed.: ", err)
	}
}
