var start;
var timerId;

document.getElementById("start_stop").addEventListener("click", function () {
  if (this.innerHTML === "START") {
    // STARTボタンをクリックしたときの処理
    start = new Date();
    timerId = setInterval(goTimer, 10);

    // STOPボタンにする
    this.innerHTML = "STOP";
    this.classList.remove("btn-primary");
    this.classList.add("btn-danger");
  } else {
    // STOPボタンをクリックしたときの処理
    clearInterval(timerId);
    // STARTボタンに戻す
    this.innerHTML = "START";
    this.classList.remove("btn-danger");
    this.classList.add("btn-primary");
  }
});

var addZero = function (value) {
  if (value < 10) {
    value = "0" + value;
  }
  return value;
};

var goTimer = function () {
  var now = new Date();

  var milli = now.getTime() - start.getTime();
  var seconds = Math.floor(milli / 1000);
  var minutes = Math.floor(seconds / 60);
  var hours = Math.floor(minutes / 60);

  seconds = seconds - minutes * 60;
  minutes = minutes - hours * 60;

  document.getElementById("timer").innerHTML =
    addZero(hours) + ":" + addZero(minutes) + ":" + addZero(seconds);
};
