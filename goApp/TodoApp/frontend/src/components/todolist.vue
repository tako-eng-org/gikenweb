<template>
  <div class="container">
    <div class="row">
      <h1>Todoリスト</h1>
    </div>

    <!-- 検索条件ここから -->
    <div class="form-check form-check-inline">
      <!--      ラジオボタンを初期状態"すべて"(current:-1)として、状態一覧を表示する-->
      <!--      <label class="form-check-label" v-for="label in options">-->
      <label class="form-check-label" v-for="(option, key) in options" v-bind:key="key">
        <input
            class="form-check-input"
            type="radio"
            v-model="current"
            v-bind:value="option.value"
        />{{ option.label }}
      </label>
    </div>
    <!-- 検索条件ここまで -->

    <!-- 追加エリアここから -->
    <form>
      <div class="form-group row">
        <label class="col-sm-2 col-form-label">タイトル</label>
        <div class="col-sm-10">
          <input
              type="text"
              class="form-control"
              name="todoTitle"
              v-model="todoTitle"
              v-bind:class="{'alert-color': !validate }"
              value=""
              placeholder="Todoタイトルを入力してください※必須"
          />
        </div>
        <label class="col-sm-2 col-form-label">メモ</label>
        <div class="col-sm-10">
          <input
              type="text"
              class="form-control"
              name="todoMemo"
              v-model="todoMemo"
              value=""
          />
          <!--isEnteredがfalse(未入力)なら、ボタンを押下できないようにする-->
          <button
              class="btn btn-primary"
              v-on:click="doAddTodo"
              v-bind:disabled="!isEntered"
          >
            追加
          </button>
        </div>
      </div>
    </form>
    <!-- 追加エリアここまで -->

    <hr/>
    <div class="container">
      <table class="table">
        <!-- テーブルヘッダここから -->
        <thead class="thead-light" v-pre>
        <tr>
          <th class="index" style="width: 10%">No</th>
          <th class="name" style="width: 25%">タイトル</th>
          <th class="memo" style="width: 25%">メモ</th>
          <th class="state" style="width: 20%">状態</th>
          <th class="delete" style="width: 20%">削除</th>
        </tr>
        </thead>
        <!-- テーブルヘッダここまで -->
        <!-- テーブルボディここから -->
        <tbody>
        <tr v-for="(computedTodo, index) in computedTodos" v-bind:key="computedTodo.id">
          <td class="index">{{ index + 1 }}</td>
          <td class="name">{{ computedTodo.name }}</td>
          <td class="memo">{{ computedTodo.memo }}</td>
          <!-- 状態変更ボタンここから -->
          <td class="state">
            <button
                class="btn btn-outline-secondary"
                v-on:click="doChangeTodoState(computedTodo)"
            >
              {{ labels[computedTodo.state] }}
            </button>
          </td>
          <!-- 状態変更ボタンここまで -->

          <!-- レコード削除ボタンここから -->
          <td class="delete">
            <button
                class="btn btn-outline-secondary"
                v-on:click="doDeleteTodo(computedTodo)"
            >
              削除
            </button>
          </td>
          <!-- レコード削除ボタンここまで -->
        </tr>
        </tbody>
        <!-- テーブルボディここまで -->
      </table>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: function () {
    return {
      // Todoリスト情報
      todos: [],
      // Todoタイトル
      todoTitle: "",
      // Todoメモ
      todoMemo: "",
      // Todoリスト情報の状態
      current: -1,
      // Todoリスト情報の状態一覧
      options: [
        {value: -1, label: "すべて"},
        {value: 0, label: "未実施"},
        {value: 1, label: "実施済"},
      ],
      // true：入力済・false：未入力
      isEntered: false,
    };
  },

  // 算出プロパティ
  computed: {
    // Todoリストの状態一覧を表示する
    labels() {
      return this.options.reduce(function (a, b) {
        return Object.assign(a, {[b.value]: b.label});
      }, {});
    },
    // 表示対象の情報を返却する
    computedTodos() {
      return this.todos.filter(function (el) {
        return this.current < 0 ? true : this.current === el.state;
      }, this);
    },
    // 入力チェック
    validate() {
      const isEnteredTodoName = 0 < this.todoTitle.length;
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
    // 全てのTodoリスト情報を取得する
    doFetchAllTodos() {
      axios.get("/gin/fetchAllTodos").then((response) => {
        if (response.status = 200) {
          // サーバから取得したTodoリスト情報をdataに設定する
          this.todos = response.data;
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },
    // １つのTodoリスト情報を取得する
    doFetchTodo(todo) {
      axios
          .get("/gin/fetchTodo", {
            params: {
              todoID: todo.id,
            },
          })
          .then((response) => {
            if (response.status = 200) {
              // 選択されたTodoリスト情報のインデックスを取得する
              const index = this.todos.indexOf(todo);
              // spliceを使うとdataプロパティの配列の要素をリアクティブに変更できる
              this.todos.splice(index, 1, response.data[0]);
            } else {
              throw new Error("レスポンスエラー");
            }
          });
    },
    // Todoリスト情報を登録する
    doAddTodo() {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams(
          // params.append("todoTitle", this.todoTitle);
          // params.append("todoMemo", this.todoMemo);
          {
            "todoTitle": this.todoTitle,
            "todoMemo": this.todoMemo
          });

      axios.post("/gin/addTodo", params).then((response) => {
        if (response.status = 200) {
          // Todoリスト情報を取得する
          this.doFetchAllTodos();
          // 入力値を初期化する
          this.initInputValue();
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },
    // Todoリスト情報の状態を変更する
    doChangeTodoState(todo) {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams({
            "todoID": todo.id,
            "todoState": todo.state,
          }
      );

      axios.post("/gin/changeStateTodo", params).then((response) => {
        if (response.status = 200) {
          // Todoリスト情報を取得する
          this.doFetchTodo(todo);
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },
    // Todoリスト情報を削除する
    doDeleteTodo(todo) {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams(
          {
            "todoID": todo.id,
          }
      );
      axios.post("/gin/deleteTodo", params).then((response) => {
        if (response.status = 200) {
          // Todoリスト情報を取得する
          this.doFetchAllTodos();
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },
    // 入力値を初期化する
    initInputValue() {
      this.current = -1;
      this.todoTitle = "";
      this.todoMemo = "";
    },
  },
}
</script>