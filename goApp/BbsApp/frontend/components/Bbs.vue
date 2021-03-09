<template>
  <div>

    <div class="container">
      <h1>BBS</h1>
    </div>

    <!--  入力フォーム  -->
    <div class="container">
      <!--  @hoge を設定すると、type="hoge"でイベント発火するようになる  -->
      <form @reset="onReset"
            v-if="show">

        <div class="form-group">
          <label for="selectTheme">テーマ</label>
          <!--  テーマ選択プルダウン。未選択不可 -->
          <select id="selectTheme"
                  class="form-control col-3"
                  v-model="form.selectedTheme"
                  required>
            <option v-for="theme in themes"
                    v-bind:value="theme.id"
                    v-bind:key="theme.id"
            >
              {{ theme.name }}
            </option>
          </select>
        </div>
        <!-- テーマ -->

        <!-- 名前 -->
        <div class="form-group">
          <label for="inputName">名前</label>
          <input id="inputName"
                 class="form-control col-4"
                 v-model="form.handleName"
                 placeholder=""
                 maxlength="30"
                 required
          >
        </div>
        <!-- 名前 -->

        <!-- タイトル -->
        <div class="form-group">
          <label for="inputTitle">タイトル</label>
          <input id="inputTitle"
                 class="form-control col-6"
                 v-model="form.title"
                 placeholder=""
                 maxlength="100"
                 required
          >
        </div>
        <!-- タイトル -->

        <!-- 内容 -->
        <div class="form-group">
          <label for="inputDetail">内容</label>
          <textarea id="inputDetail"
                    class="form-control col-11"
                    v-model="form.detail"
                    placeholder=""
                    rows="6"
                    maxlength="2000"
                    required
          ></textarea>
        </div>
        <!-- 内容 -->

        <!-- ファイルアップロード -->
        <div class="form-group">
          <label for="inputFile">ファイル</label><br>
          <input id="inputFile"
                 type="file"
          >
        </div>
        <!-- ファイルアップロード -->

        <!-- チェックボックス -->
        <div class="form-group">
          <input id="agreeToUse"
                 type="checkbox"
                 v-model="form.accepted"
          >
          <label for="agreeToUse">利用規約に同意します</label>
        </div>
        <!-- チェックボックス -->

        <button type="submit"
                class="btn btn-primary"
                v-on:click="doAddRecord">
          投稿
        </button>
        <button type="reset"
                class="btn btn-danger">
          内容とファイルをクリア
        </button>
      </form>
    </div>
    <!--  入力フォーム  -->

    <!-- レコード表示 -->
    <div class="container" v-for="record in records" v-bind:key="record.PostId">
      <!--      <p v-for="record in records" v-bind:key="record.PostId">-->
      <div class="row">
        <!--    投稿IDと投稿日時を表示する    -->
        ({{ record.PostId }}) {{ record.CreatedAt }}
      </div>

      <div class="row">
        テーマ: {{ record.Theme }}
      </div>

      <div class="row">
        タイトル: {{ record.Title }}
      </div>

      <div class="row">
        名前: {{ record.HandleName }}
      </div>

      <div class="row">
        内容:
      </div>
      <div class="row content">
        <p>{{ record.Detail }}
        <p>
      </div>

      <br>
    </div>
  </div>
  <!--    デバッグ用。送信内容を表示する-->

  <!--      <b-card class="mt-3" header="デバッグ用">-->
  <!--        <pre class="m-0">{{ form }}</pre>-->
  <!--      </b-card>-->
  <!--    デバッグ用。送信内容を表示する end-->
  <!--    </b-container>-->

  <!--  </div>-->
</template>

<script>
import axios from 'axios'

export default {
  data: function () {
    return {
      // 投稿した情報
      records: [],

      // テーマ選択初期値

      form: {
        selectedTheme: '',
        title: '',
        handleName: '',
        detail: '',
        uploadFileName: '',
        accepted: false,
      },

      fileurl: '',

      // プルダウンで選択可能なテーマ一覧
      themes: [
        {name: '雑談', id: '1'},
        {name: '技術', id: '2'},
        {name: '犬', id: '3'},
        {name: 'その他', id: '4'},
      ],
      show: true,
    }
  },

  computed: {
    // 表示対象の情報を返却する
    computedRecords() {
      console.log('--------------------')
      console.log(this.records)
      console.log('--------------------')
      return this.records //.filter(function (el) {
      // return this.current < 0 || this.current === el.state;
      // }, this);
    },
  },

  mounted: function () {
    this.doFetchAllRecords()
  },

  methods: {
    // フォーム情報を送信する
    onSubmit(event) {
      event.preventDefault()
      if (!this.checkValidation()) {
        return
      }
      // debug用。投稿内容をwindowに表示する
      // alert(JSON.stringify(this.form))
    },

    // フォームの「内容」「画像」「利用規約」を削除する
    onReset(event) {
      event.preventDefault()
      this.form.detail = ''
      this.form.uploadFileName = null
      // Trick to reset/clear native browser form validation state
      this.show = false
      this.$nextTick(() => {
        this.show = true
      })
    },

    checkValidation(event) {
      // 利用規約への同意
      if (!this.form.accepted) {
        window.alert('利用規約への同意がありません')
        return false
      } else {
        return true
      }
      // TODO その他のバリデーションチェック
    },

    // 全てのTodoリスト情報を取得する
      doFetchAllRecords() {
      axios.get('/bbs/fetchAllRecords').then((response) => {
        if ((response.status = 200)) {
          let responseData = response.data

          // 表示のため、投稿データを降順にソートする
          responseData.sort(
            function (a, b) {
              return (a < b ? 1 : -1);
            }
          );

          // CreatedAt(投稿日時)をYYYY/MM/DD hh:mmに整形する
          // 整形前サンプル： "2021-03-08T22:17:32.132636Z"
          for (let i = 0; i < responseData.length; i++){
            responseData[i].CreatedAt = responseData[i].CreatedAt.replace(/^(.{10})T(.{5}).+$/, "$1 $2");
          }

          // レコードに格納する
          this.records = responseData;
        } else {
          throw new Error('レスポンスエラー')
        }
      })
    },

    // 投稿を登録する
    doAddRecord() {
      // サーバへ送信するパラメータ
      const params = new URLSearchParams(
        {
          "Theme": this.form.selectedTheme,
          "Title": this.form.title,
          "HandleName": this.form.handleName,
          "Detail": this.form.detail,
        });

      axios.post("/bbs/addRecord", params).then((response) => {
        if (response.status = 200) {
          this.doFetchAllRecords();
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },


  },
}
</script>

<style>
p {
  white-space: pre-wrap;
}
</style>
