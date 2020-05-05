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

app.get("/form", function(req, res){
  return res.render("form");
});

app.post("/form", function(req, res){
  return res.render("result", {username: req.body.username, message: req.body.message});
});

// debug***************************************
app.get("/toriki", function(req, res){
  return res.render("toriki");
});

app.post("/toriki", function(req, res){
  const allMenuAllay = [
    "むね貴族焼（たれ）",
    "だし巻き",
    "つくね塩"];

  // jsonファイルを読み込み
  let jsonObj = JSON.parse(fs.readFileSync(`./torikiMenu.json`, 'utf8'));
  // let testStr = json.results[0].gender;
  // console.log(testStr);

  const result = {};
  jsonObj.list.forEach((obj) => {
    result[obj.id] = obj;
  });

    // [object Object]表示を避けるためパース
    let jsonStr = JSON.stringify(jsonObj)

  // すべてのメニューからランダムに1つ選択する
  let randomChoiceOne = allMenuAllay[Math.floor(Math.random() * allMenuAllay.length)];

  // リターン
  return res.render("torikiResult",
    {
      menuName: randomChoiceOne,
      description: "ここに説明",
      // debug用。あとで消す
      all: jsonStr
    });
});
// debug***************************************

const server = http.createServer(app);
server.listen(3000);

