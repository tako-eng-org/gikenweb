const http = require('http');
const path = require('path');
const morgan = require('morgan');
const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const Sequelize = require('sequelize');
//const mysql = require("mysql");

//
//あくまでサーバの立ち上げにつかう。
//routerとかは、
//
//

const app = express();// expressアプリを生成する

app.use(morgan("combined"));

app.use("/static", express.static(path.join(__dirname, "static")));// フォルダの中身を公開する

app.use(bodyParser.urlencoded({ extended: false }));

app.set('views', path.join(__dirname, 'templates')); // viewはtemplatesフォルダで公開する
app.set('view engine', 'ejs');

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
  const sequelize = new Sequelize('NodeTest','root','',{dialect:'mysql'});

  /*
  sequelize.query("select * from test_table").spread((results, metadata) => {
    console.log(results);
    sequelize.close();
  });
  //*/

  let results = "ここに結果を代入";
  let metadata = "あとで消す";
  let seq = sequelize.query("select * from test_table").spread(results, metadata);
  sequelize.close();

  return res.render("todolistResult", {msg: results});
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
