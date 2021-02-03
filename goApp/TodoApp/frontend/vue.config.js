// goApp/TodoApp/frontend/public/index.htmlの
// htmlWebpackPlugin.options.title（ページタイトル）
// を修正するために必要な設定ファイル（手動で作成した）。
module.exports = {
    // yarnにて資材をビルドする際のモード選択により、パスを変更する
    publicPath: process.env.NODE_ENV === 'production'
        ? '/gin'
        : '/',
    pages: {
        index: {
            entry: "src/main.js",
            title: "Todoアプリ",
        }
    },
    // webpackによる転送設定
    devServer: {
        proxy: {
            "/gin/": {
                target: "http://localhost:8000",
                logLevel: 'debug'
            },
        },
    },
}