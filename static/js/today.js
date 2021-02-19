// 日付を表示する
var today = new Date();
var dayOfWeek = today.getDay();
var dayOfWeekStr = ["日", "月", "火", "水", "木", "金", "土"][
    dayOfWeek
    ];
var todayHtml =
    today.getFullYear() +
    "-" +
    (today.getMonth() + 1) +
    "-" +
    today.getDate();
document.write(
    '<p class="date">' + todayHtml + "(" + dayOfWeekStr + ")</p>"
);
