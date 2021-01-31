// goApp/TodoApp/frontend/public/index.htmlの
// htmlWebpackPlugin.options.title（ページタイトル）
// を修正するために必要な設定ファイル（手動で作成した）。
module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
        ? '/gin'
        : '/',
    pages: {
        index: {
            entry: "src/main.js",
            title: "Todoアプリ",
        }
    },
    devServer: {
        proxy: {
            "/gin/": {
                target: "http://localhost:8000",
                logLevel: 'debug'
            },
        },
    },
}