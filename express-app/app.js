const http = require('http');
const path = require('path');
const morgan = require('morgan');
const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');

const app = express();

app.use(morgan("combined"));

app.use("/static", express.static(path.join(__dirname, "static")));

app.use(bodyParser.urlencoded({ extended: false }));

app.set('views', path.join(__dirname, 'templates'));
app.set('view engine', 'ejs');

app.get("/", function(req, res){
  return res.render("index", {title: "hello world"});
 });

// >>フォーム*****************************************************************************
app.get("/form", function(req, res){
  return res.render("form");
});

app.post("/form", function(req, res){
  return res.render("formResult", {username: req.body.username, message: req.body.message});
});
// <<フォーム*****************************************************************************

// >>トリキガチャ*****************************************************************************
app.get("/toriki", function(req, res){
  return res.render("toriki");
});

// ガチャ結果
app.post("/toriki", function(req, res){
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

const server = http.createServer(app);
server.listen(3000);