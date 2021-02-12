package db

import (
	// フォーマットI/O
	"fmt"

	// osI/O
	"os"

	// Go言語のORM
	"github.com/jinzhu/gorm"

	// エンティティ(データベースのテーブルの行に対応)
	entity "../entity"

	// postgres用ライブラリ。importしないと下記エラーを出力する。
	// sql: unknown driver "postgres" (forgotten import?)
	_ "github.com/lib/pq"

	// envファイルを取り扱う
	"github.com/joho/godotenv"
)

// DB接続する
func open() *gorm.DB {
	// .envファイルから環境変数を読み出す
	fileEnv := godotenv.Load(fmt.Sprintf("./%s.env", os.Getenv("GO_ENV")))

	// .envの読み込みに失敗した場合
	if fileEnv != nil {
		panic(fileEnv)
	}

	// DB接続
	db, err := gorm.Open(os.Getenv("RDBMS_NAME"),
		"host= "+os.Getenv("DB_HOST")+
			" port="+os.Getenv("DB_PORT")+
			" user="+os.Getenv("DB_USER")+
			" password="+os.Getenv("DB_PASS")+
			" dbname="+os.Getenv("DB_NAME")+
			" sslmode="+os.Getenv("DB_SSLMODE"))

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

// Todoリストテーブルのレコードを全件取得する
func FindAllTodos() []entity.Todo {
	todos := []entity.Todo{}

	db := open()
	// select
	db.Order("Id asc").Find(&todos)

	// defer 関数がreturnする時に実行される
	defer db.Close()

	return todos
}

// Todoリストテーブルのレコードを１件取得する
func FindTodo(todoId int) []entity.Todo {
	todo := []entity.Todo{}

	db := open()
	// select
	db.First(&todo, todoId)
	defer db.Close()

	return todo
}

// Todoリストテーブルにレコードを登録する
func InsertTodo(registerTodo *entity.Todo) {
	db := open()
	// insert
	db.Create(&registerTodo)
	defer db.Close()
}

// Todoリストテーブルの指定したレコードの状態を変更する
func UpdateStateTodo(todoId int, todoState int) {
	todo := []entity.Todo{}

	db := open()
	// update
	db.Model(&todo).Where("Id = ?", todoId).Update("state", todoState)
	defer db.Close()
}

// Todoリストテーブルの指定したレコードを削除する
func DeleteTodo(todoId int) {
	todo := []entity.Todo{}

	db := open()
	// delete
	db.Delete(&todo, todoId)
	defer db.Close()
}
