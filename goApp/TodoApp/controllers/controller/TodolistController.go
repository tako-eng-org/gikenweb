package controller

import (
	// 文字列と基本データ型の変換パッケージ
	strconv "strconv"

	// Gin
	"github.com/gin-gonic/gin"

	// エンティティ(データベースのテーブルの行に対応)
	entity "../../models/entity"

	// DBアクセス用モジュール
	db "../../models/db"
)

// Todoリストの実施状態を定義する
const (
	Waiting   = iota // 0:未実施
	Completed = iota // 1:実施済
)

// 全てのTodoリスト情報を取得する
func FetchAllTodos(c *gin.Context) {
	resultTodos := db.FindAllTodos()

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, resultTodos)
}

// 指定したIDのTodoリスト情報を取得する
func FindTodo(c *gin.Context) {
	todoIdStr := c.Query("todoId")

	todoId, _ := strconv.Atoi(todoIdStr)

	resultTodo := db.FindTodo(todoId)

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, resultTodo)
}

// TodoリストをDBへ登録する
func AddTodo(c *gin.Context) {
	todoTitle := c.PostForm("todoTitle")
	todoMemo := c.PostForm("todoMemo")

	// テーブルに登録するためのレコード情報
	var todo = entity.Todo{
		Name:  todoTitle,
		Memo:  todoMemo,
		State: Waiting,
	}

	db.InsertTodo(&todo)
}

// Todoリスト情報の状態を変更する
func ChangeStateTodo(c *gin.Context) {
	reqTodoId := c.PostForm("todoId")
	reqTodoState := c.PostForm("todoState")

	todoId, _ := strconv.Atoi(reqTodoId)
	todoState, _ := strconv.Atoi(reqTodoState)
	changeState := Waiting
	// Todoリスト状態が未実施の場合、実施済へ変更する
	if todoState == Waiting {
		changeState = Completed
	}

	db.UpdateStateTodo(todoId, changeState)
}

// Todoリスト情報をDBから削除する
func DeleteTodo(c *gin.Context) {
	todoIdStr := c.PostForm("todoId")

	todoId, _ := strconv.Atoi(todoIdStr)

	db.DeleteTodo(todoId)
}
