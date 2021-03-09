package entity

import "time"

// Bbs はテーブルの構造体
type Bbs struct {
	PostId     int       `gorm:"primary_key;not null"				json:"post_id"`
	Theme      string    `gorm:"type:varchar(100);not null"		json:"theme"`
	Title      string    `gorm:"type:varchar(200);not null"		json:"title"`
	HandleName string    `gorm:"type:varchar(100);not null"		json:"handle_name"`
	Detail     string    `gorm:"type:varchar(4000);not null"		json:"detail"`
	CreatedAt  time.Time `gorm:"type:timestamp"					json:"created_at"`
}
