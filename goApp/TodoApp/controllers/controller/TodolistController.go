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
	Waiting   = 0 // 未実施
	Completed = 1 // 実施済
)

// FetchAllTodos は 全てのTodoリスト情報を取得する
func FetchAllTodos(c *gin.Context) {
	resultTodos := db.FindAllTodos()

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, resultTodos)
}

// FindTodo は 指定したIDのTodoリスト情報を取得する
func FindTodo(c *gin.Context) {
	todoIDStr := c.Query("todoId")

	todoID, _ := strconv.Atoi(todoIDStr)

	resultTodo := db.FindTodo(todoID)

	// URLへのアクセスに対してJSONを返す
	c.JSON(200, resultTodo)
}

// AddTodo は TodoリストをDBへ登録する
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

// ChangeStateTodo は Todoリスト情報の状態を変更する
func ChangeStateTodo(c *gin.Context) {
	reqTodoID := c.PostForm("todoId")
	reqTodoState := c.PostForm("todoState")

	todoID, _ := strconv.Atoi(reqTodoID)
	todoState, _ := strconv.Atoi(reqTodoState)
	changeState := Waiting
	// Todoリスト状態が未実施の場合、実施済へ変更する
	if todoState == Waiting {
		changeState = Completed
	}

	db.UpdateStateTodo(todoID, changeState)
}

// DeleteTodo は Todoリスト情報をDBから削除する
func DeleteTodo(c *gin.Context) {
	todoIDStr := c.PostForm("todoId")

	todoID, _ := strconv.Atoi(todoIDStr)

	db.DeleteTodo(todoID)
}
