"use strict";
(function () {
  let submitbtn = document.getElementById("submitbtn");
  let priceA = document.getElementById("priceA");
  let priceB = document.getElementById("priceB");
  let result = document.getElementById("result");
  let reset = document.getElementById("reset");

  //ボタン"決めてもらう"をクリックしたときの処理
  submitbtn.addEventListener("click", function () {
    const choiceArray = [priceA, priceB];

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
    priceA.value = "";
    priceB.value = "";
    priceA.focus();
  });

  priceA.focus();
})();
