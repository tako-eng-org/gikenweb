/*
const Sequelize = require('sequelize');

// 接続先情報
const host     = 'localhost';
const database = 'my_db_test1';
const username = 'root';
const password = '';

// 接続開始
const sequelize = new Sequelize(database, username, password, {
  host: host,
  dialect: 'mysql',
  operatorsAliases: false,
  pool: {
    min: 0,
    max: 5,
    acuire: 30000,
    idle  : 10000
  }
});

// 接続確認用
sequelize.authenticate()
  .then(()       => { console.log('Success test connection');        })
  .catch((error) => { console.log('Failure test connection', error); });

// users テーブルに対応するモデルを作成する
const UserModel = sequelize.define('users', {                                                                // CREATE TABLE 文で指定した内容は大体以下のような感じ
  id       : { field: 'id'        , type: Sequelize.INTEGER(11) , primaryKey: true, autoIncrement: true },  // INT(11)       NOT NULL  PRIMARY KEY  AUTO_INCREMENT
  userName : { field: 'user_name' , type: Sequelize.STRING(100) , allowNull: false                      },  // VARCHAR(100)  NOT NULL
  address  : { field: 'address'   , type: Sequelize.STRING(500)                                         },  // VARCHAR(500)  DEFAULT NULL
  createdAt: { field: 'created_at', type: Sequelize.DATE                                                },  // DATETIME      NOT NULL  DEFAULT CURRENT_TIMESTAMP
  updatedAt: { field: 'updated_at', type: Sequelize.DATE                                                }   // DATETIME      NOT NULL  DEFAULT CURRENT_TIMESTAMP  ON UPDATE CURRENT_TIMESTAMP
});

// 全件取得してみる
UserModel.findAll()
  .then((result) => {
    console.log('データ取得', result.dataValues);
  });
//*/

const Sequelize = require("sequelize");
const sequelize = new Sequelize("NodeTest", "root", "", { dialect: "mysql" });
sequelize.query("select * from test_table").spread((results, metadata) => {
  console.log(results);
  sequelize.close();
});
