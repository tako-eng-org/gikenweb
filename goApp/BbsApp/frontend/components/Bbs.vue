<template>
  <div class="container">
    <div class="row">
      <h1>Hello, bbs!!</h1>
    </div>

    <!-- 検索条件ここから -->
    <div class="form-check form-check-inline">
      <!--      ラジオボタンを初期状態"すべて"(current:-1)として、状態一覧を表示する-->
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
        return this.current < 0 || this.current === el.state;
      }, this);
    },

    // 入力チェック
    validate() {
      this.isEntered = 0 < this.todoTitle.length;
      return this.isEntered;
    },

  },

  // インスタンス作成時の処理
  created: function () {
    this.doFetchAllBbs();
  },
  // メソッド定義
  methods: {

    // 全てのTodoリスト情報を取得する
    doFetchAllBbs() {
      axios.get("/bbs/fetchAllBbs").then((response) => {
        if (response.status = 200) {
          this.todos = response.data;
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
