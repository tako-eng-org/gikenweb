package controller

import (
	// 文字列と基本データ型の変換パッケージ
	//strconv "strconv"

	// Gin
	"github.com/gin-gonic/gin"
	"server/models/entity"

	// エンティティ(データベースのテーブルの行に対応)
	//entity "../../models/entity"

	// DBアクセス用モジュール
	db "server/models/db"
)

// 全ての投稿情報を取得する
func FetchAllRecords(c *gin.Context) {
	result := db.FindAllRecords()

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, result)
}

// 投稿をDBへ登録する
func AddRecord(c *gin.Context) {
	Theme := c.PostForm("Theme")
	Title := c.PostForm("Title")
	HandleName := c.PostForm("HandleName")
	Detail := c.PostForm("Detail")

	// テーブルに登録するためのレコード情報
	var record = entity.Bbs{
		Theme:      Theme,
		Title:      Title,
		HandleName: HandleName,
		Detail:     Detail,
	}

	db.InsertRecord(&record)
}
