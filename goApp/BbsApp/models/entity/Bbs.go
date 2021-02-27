package entity

// Bbs はテーブルのモデル
type Bbs struct {
	Id     int    `gorm:"primary_key;not null"		json:"id"`
	Theme  string `gorm:"type:varchar(100);not null"	json:"theme"`
	Title  string `gorm:"type:varchar(200);not null"	json:"title"`
	Name   string `gorm:"type:varchar(100);not null"	json:"name"`
	Detail string `gorm:"type:varchar(4000);not null"	json:"detail"`
	Delkey string `gorm:"type:varchar(20);not null"	json:"delkey"`
}
