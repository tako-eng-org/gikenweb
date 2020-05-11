const log4js = require("log4js");
// logger.level = 'debug';

// log4jsでは１個のログ出力を appender と呼んでいます。 appender ごとに出力先を変えたり出力フォーマットを変えたりすることができます。
log4js.configure({
  appenders: {
    system: { type: "file", filename: "system.log" },
  },
  // カテゴリ→ログの種類のこと。
  categories: {
    default: { appenders: ["system"], level: "debug" },
  },
});
const logger = log4js.getLogger("system");

logger.debug(logger);
