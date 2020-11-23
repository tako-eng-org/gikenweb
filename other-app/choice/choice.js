"use strict";
(function () {
  let submitbtn = document.getElementById("submitbtn");
  let do1 = document.getElementById("do1");
  let do2 = document.getElementById("do2");
  let result = document.getElementById("result");
  let reset = document.getElementById("reset");

  //ボタン"決めてもらう"をクリックしたときの処理
  submitbtn.addEventListener("click", function () {
    const choiceArray = [do1, do2];

    //TODO ここうまく入らない。要修正2020/11/23
    for (let i = 0; i < choiceArray.length; i++) {
      if (!choiceArray[i].value) {
        result.textContent = `入力してから決めてもらってください`;
        return;
      }
    }

    let n = Math.floor(Math.random() * choiceArray.length);
    result.textContent = `「${choiceArray[n].value}」にしましょう。`;
  });

  reset.addEventListener("click", function () {
    result.textContent = "結果はここに表示します";
    do1.value = "";
    do2.value = "";
    do1.focus();
  });

  do1.focus();
})();
