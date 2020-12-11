new Vue({
  // 「el」プロパティーで、Vueの表示を反映する場所＝HTML要素のセレクター（id）を定義
  el: "#app",

  // data オブジェクトのプロパティの値を変更すると、ビューが反応し、新しい値に一致するように更新
  data: {
    // 商品情報
    todos: [],
    // 品名
    todoName: "",
    // メモ
    todoMemo: "",
    // 商品情報の状態
    current: -1,
    // 商品情報の状態一覧
    options: [
      { value: -1, label: "すべて" },
      { value: 0, label: "未購入" },
      { value: 1, label: "購入済" },
    ],
    // true：入力済・false：未入力
    isEntered: false,
  },

  // 算出プロパティ
  computed: {
    // 商品情報の状態一覧を表示する
    labels() {
      return this.options.reduce(function (a, b) {
        return Object.assign(a, { [b.value]: b.label });
      }, {});
    },
    // 表示対象の商品情報を返却する
    computedTodos() {
      return this.todos.filter(function (el) {
        var option = this.current < 0 ? true : this.current === el.state;
        return option;
      }, this);
    },
    // 入力チェック
    validate() {
      var isEnteredTodoName = 0 < this.todoName.length;
      this.isEntered = isEnteredTodoName;
      return isEnteredTodoName;
    },
  },

  // インスタンス作成時の処理
  created: function () {
    this.doFetchAllTodos();
  },

  // メソッド定義
  methods: {
    // 全ての商品情報を取得する
    doFetchAllTodos() {
      axios.get("/fetchAllTodos").then((response) => {
        if (response.status != 200) {
          throw new Error("レスポンスエラー");
        } else {
          var resultTodos = response.data;

          // サーバから取得した商品情報をdataに設定する
          this.todos = resultTodos;
        }
      });
    },
    // １つの商品情報を取得する
    doFetchTodo(todo) {
      axios
        .get("/fetchTodo", {
          params: {
            todoID: todo.id,
          },
        })
        .then((response) => {
          if (response.status != 200) {
            throw new Error("レスポンスエラー");
          } else {
            var resultTodo = response.data;

            // 選択された商品情報のインデックスを取得する
            var index = this.todos.indexOf(todo);

            // spliceを使うとdataプロパティの配列の要素をリアクティブに変更できる
            this.todos.splice(index, 1, resultTodo[0]);
          }
        });
    },
    // 商品情報を登録する
    doAddTodo() {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams();
      params.append("todoName", this.todoName);
      params.append("todoMemo", this.todoMemo);

      axios.post("/addTodo", params).then((response) => {
        if (response.status != 200) {
          throw new Error("レスポンスエラー");
        } else {
          // 商品情報を取得する
          this.doFetchAllTodos();

          // 入力値を初期化する
          this.initInputValue();
        }
      });
    },
    // 商品情報の状態を変更する
    doChangeTodoState(todo) {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams();
      params.append("todoID", todo.id);
      params.append("todoState", todo.state);

      axios.post("/changeStateTodo", params).then((response) => {
        if (response.status != 200) {
          throw new Error("レスポンスエラー");
        } else {
          // 商品情報を取得する
          this.doFetchTodo(todo);
        }
      });
    },
    // 商品情報を削除する
    doDeleteTodo(todo) {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams();
      params.append("todoID", todo.id);

      axios.post("/deleteTodo", params).then((response) => {
        if (response.status != 200) {
          throw new Error("レスポンスエラー");
        } else {
          // 商品情報を取得する
          this.doFetchAllTodos();
        }
      });
    },
    // 入力値を初期化する
    initInputValue() {
      this.current = -1;
      this.todoName = "";
      this.todoMemo = "";
    },
  },
});
