package controller

import (
	// 文字列と基本データ型の変換パッケージ
	//strconv "strconv"

	// Gin
	"github.com/gin-gonic/gin"

	// エンティティ(データベースのテーブルの行に対応)
	//entity "../../models/entity"

	// DBアクセス用モジュール
	db "../../models/db"
)

// 全てのTodoリスト情報を取得する
func FetchAllBbs(c *gin.Context) {
	resultBbs := db.FindAllBbs()

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, resultBbs)
}
