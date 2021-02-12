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

	// .env読めなかった場合の処理
	if fileEnv != nil {
		fmt.Println(fileEnv)
	}

	// DB接続のための環境変数を設定する
	//env := os.Getenv("ENV")
	DbRdbmsName := os.Getenv("RDBMS_NAME")
	DbHost := os.Getenv("DB_HOST")
	DbPort := os.Getenv("DB_PORT")
	DbUser := os.Getenv("DB_USER")
	DbPass := os.Getenv("DB_PASS")
	DbName := os.Getenv("DB_NAME")
	DbSslmode := os.Getenv("DB_SSLMODE")

	//fmt.Println(env)

	// DB接続 ローカル開発用
	db, err := gorm.Open(DbRdbmsName,
		"host= "+DbHost+
			" port="+DbPort+
			" user="+DbUser+
			" password="+DbPass+
			" dbname="+DbName+
			" sslmode="+DbSslmode)
	//db, err := gorm.Open("postgres", "host=postgres port=5432 user=root password=password dbname=todo sslmode=disable")
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

	//fmt.Println("db connected: ", &db)
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

// InsertTodo は Todoリストテーブルにレコードを登録する
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
