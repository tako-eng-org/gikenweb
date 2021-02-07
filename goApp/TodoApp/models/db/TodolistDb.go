package db

import (
	// フォーマットI/O
	"fmt"

	// Go言語のORM
	"github.com/jinzhu/gorm"

	// エンティティ(データベースのテーブルの行に対応)
	entity "../entity"

	// postgres用ライブラリ。importしないと下記エラーを出力する。
	// sql: unknown driver "postgres" (forgotten import?)
	_ "github.com/lib/pq"
)

// DB接続する
func open() *gorm.DB {
	//ローカル開発用
	db, err := gorm.Open("postgres", "host=postgres port=5432 user=root password=password dbname=todo sslmode=disable")
	// RDS用
	//db, err := gorm.Open("postgres", "host=gikenweb-db1.c5t2snwrws8q.us-east-2.rds.amazonaws.com port=5432 user=postgres password=password dbname=todo sslmode=disable")
	// EC2用
	//db, err := gorm.Open("postgres", "host=localhost port=5432 user=postgres dbname=todo sslmode=disable")

	if err != nil {
		panic(err.Error())
	}

	// DBエンジンを「InnoDB」に設定
	db.Set("gorm:table_options", "ENGINE=InnoDB")

	// 詳細なログを表示
	db.LogMode(true)

	// 登録するテーブル名を単数形にする（デフォルトは複数形）
	db.SingularTable(true)

	// マイグレーション（テーブルが無い時は自動生成）
	db.AutoMigrate(&entity.Todo{})

	fmt.Println("db connected: ", &db)
	return db
}

// FindAllTodos は Todoリストテーブルのレコードを全件取得する
func FindAllTodos() []entity.Todo {
	todos := []entity.Todo{}

	db := open()
	// select
	db.Order("ID asc").Find(&todos)

	// defer 関数がreturnする時に実行される
	defer db.Close()

	return todos
}

// FindTodo は Todoリストテーブルのレコードを１件取得する
func FindTodo(todoId int) []entity.Todo {
	todo := []entity.Todo{}

	db := open()
	// select
	db.First(&todo, todoId)
	defer db.Close()

	return todo
}

// InsertTodo は Todoリストテーブルにレコードを追加する
func InsertTodo(registerTodo *entity.Todo) {
	db := open()
	// insert
	db.Create(&registerTodo)
	defer db.Close()
}

// UpdateStateTodo は Todoリストテーブルの指定したレコードの状態を変更する
func UpdateStateTodo(todoId int, todoState int) {
	todo := []entity.Todo{}

	db := open()
	// update
	db.Model(&todo).Where("ID = ?", todoId).Update("state", todoState)
	defer db.Close()
}

// DeleteTodo は Todoリストテーブルの指定したレコードを削除する
func DeleteTodo(todoId int) {
	todo := []entity.Todo{}

	db := open()
	// delete
	db.Delete(&todo, todoId)
	defer db.Close()
}
