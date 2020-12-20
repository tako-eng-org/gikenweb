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

// Todoリストの購入状態を定義
const (
    // NotPurchased は 未実施
    NotPurchased = 0

    // Purchased は 実施済
    Purchased = 1
)

// FetchAllTodos は 全てのTodoリスト情報を取得する
func FetchAllTodos(c *gin.Context) {
    resultTodos := db.FindAllTodos()

    // URLへのアクセスに対してJSONを返す
    c.JSON(200, resultTodos)
}

// FindTodo は 指定したIDのTodoリスト情報を取得する
func FindTodo(c *gin.Context) {
    todoIDStr := c.Query("todoID")

    todoID, _ := strconv.Atoi(todoIDStr)

    resultTodo := db.FindTodo(todoID)

    // URLへのアクセスに対してJSONを返す
    c.JSON(200, resultTodo)
}

// AddTodo は TodoリストをDBへ登録する
func AddTodo(c *gin.Context) {
    todoName := c.PostForm("todoName")
    todoMemo := c.PostForm("todoMemo")

    var todo = entity.Todo{
        Name:  todoName,
        Memo:  todoMemo,
        State: NotPurchased,
    }

    db.InsertTodo(&todo)
}

// ChangeStateTodo は Todoリスト情報の状態を変更する
func ChangeStateTodo(c *gin.Context) {
    reqTodoID := c.PostForm("todoID")
    reqTodoState := c.PostForm("todoState")

    todoID, _ := strconv.Atoi(reqTodoID)
    todoState, _ := strconv.Atoi(reqTodoState)
    changeState := NotPurchased

    // Todoリスト状態が未実施の場合
    if todoState == NotPurchased {
        changeState = Purchased
    } else {
        changeState = NotPurchased
    }

    db.UpdateStateTodo(todoID, changeState)
}

// DeleteTodo は Todoリスト情報をDBから削除する
func DeleteTodo(c *gin.Context) {
    todoIDStr := c.PostForm("todoID")

    todoID, _ := strconv.Atoi(todoIDStr)

    db.DeleteTodo(todoID)
}
