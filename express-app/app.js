const http = require('http');
const path = require('path');
const morgan = require('morgan');
const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
//const mysql = require("mysql");
const log4js = require("log4js");
const Sequelize = require('sequelize');
//
//app.jsはあくまでサーバの立ち上げにつかう。
//routerとかは、
//
//

const app = express();// expressアプリを生成する

app.use(morgan("combined"));

app.use("/static", express.static(path.join(__dirname, "static")));// フォルダの中身を公開する

app.use(bodyParser.urlencoded({ extended: false }));

app.set('views', path.join(__dirname, 'templates')); // viewはtemplatesフォルダで公開する
app.set('view engine', 'ejs');

// >>logging設定*****************************************************************************
log4js.configure({
  appenders: {
    system: { type: "file", filename: "system.log" },
  },
  // カテゴリ→ログの種類のこと。
  categories: {
    default: { appenders: ["system"], level: "debug" },
  },
});
const logging = log4js.getLogger("system");

//test出力
logging.debug("******************************");
logging.debug(logging);
// <<logging設定*****************************************************************************


// *****************************************************************************
app.get("/", function(req, res){
  return res.render("index", {title: "expressアプリのルート"});
 });

// >>フォーム*****************************************************************************
app.get("/contacts", function(req, res){
  return res.render("contacts");
});

app.post("/contactsResult", function(req, res){
  return res.render("contactsResult", {username: req.body.username, message: req.body.message});
});
// <<フォーム*****************************************************************************

// >>トリキガチャ*****************************************************************************
app.get("/toriki", function(req, res){
  return res.render("toriki");
});

// ガチャ結果
app.post("/torikiResult", function(req, res){
  // jsonファイルを読み込み
  let jsonObj = JSON.parse(fs.readFileSync(`./torikiMenu.json`, 'utf8'));

  let arr = new Array();

  // 読み込んだjsonファイルから、値を配列に格納する
  for (var i in jsonObj.menus) {
    arr.push(jsonObj.menus[i]);
  }

  // 配列から、ランダムに1つ抽出する
  let randomChoiceOne = arr[Math.floor(Math.random() * arr.length)];
  let oneName = randomChoiceOne.name;
  let oneDescription = randomChoiceOne.description;

  // リターン
  return res.render("torikiResult",
    {
      menuName: oneName,
      description: oneDescription,
    });
});
// <<トリキガチャ*****************************************************************************

// >> todolist*****************************************************************************
// ページ表示
app.get("/todolist", function(req, res){
return res.render("todolist");
});

// 結果
app.post("/todolistResult", function(req, res){

//   const Sequelize = require('sequelize');

// // Option 1: Passing parameters separately
// const sequelize = new Sequelize('database', 'username', 'password', {
//   host: 'localhost',
//   dialect: /* one of 'mysql' | 'mariadb' | 'postgres' | 'mssql' */
// });

  // const sequelize = new Sequelize('NodeTest','root','',{dialect:'mysql'});

  /*
  sequelize.query("select * from test_table").spread((results, metadata) => {
    console.log(results);
    sequelize.close();
  });
  //*/

  // let results = "ここに結果を代入";
  // let metadata = "あとで消す";
  // sequelize.query('select * from test_table',null,{raw:true}).success(function(rows) {
  // logging.debug(rows);
  // });

  //let seq = sequelize.query("select * from test_table").spread(results, metadata);
  //sequelize.close();

  //logging.debug(seq);
  //logging.debug(results);
  //logging.debug(metadata);

  return res.render("todolistResult", {msg: "test"});
});

// const connection = mysql.createConnection({
//  host: 'localhost',
// user: 'root',
//  password: '',
//  database: 'todo_api'
//})

// << todolist *****************************************************************************

const server = http.createServer(app);
server.listen(3000);
