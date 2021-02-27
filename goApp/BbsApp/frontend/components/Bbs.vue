<template>
  <div>
    <b-container class="bv-example-row">
      <h1>BBS</h1>

      <!--  @hoge を設定すると、type="hoge"でイベント発火するようになる  -->
      <b-form @submit="onSubmit" @reset="onReset" v-if="show">

        <!-- テーマ -->
        <b-form-group id="input-group-3"
                      label="テーマ:"
                      label-for="input-3"
                      content-cols-sm
                      label-cols-sm="1"
                      label-cols-lg="1"
                      content-cols-lg="3"
        >
          <b-form-select
            id="input-3"
            v-model="form.theme"
            :options="themes"
            required
          ></b-form-select>
        </b-form-group>
        <!-- テーマ -->

        <!-- タイトル -->
        <b-form-group id="input-group-2"
                      label="タイトル:"
                      label-for="input-2"
                      content-cols-sm
                      label-cols-sm="1"
                      label-cols-lg="1"
                      content-cols-lg="6"
        >
          <b-form-input
            id="input-2"
            class="mb-2 mr-sm-2 mb-sm-0"
            v-model="form.title"
            placeholder=""
            maxlength='100'
            required
          ></b-form-input>
        </b-form-group>
        <!-- タイトル -->

        <!-- 名前 -->
        <b-form-group id="input-group-2"
                      label="名前:"
                      label-for="input-2"
                      content-cols-sm
                      label-cols-sm="1"
                      label-cols-lg="1"
                      content-cols-lg="3"
        >
          <b-form-input
            id="input-2"
            class="mb-2 mr-sm-2 mb-sm-0"
            v-model="form.name"
            placeholder=""
            maxlength='30'
            required
          ></b-form-input>
        </b-form-group>
        <!-- 名前 -->

        <!-- 内容 -->
        <b-form-group
          id="input-group-2-2"
          label="内容:"
          label-for="input-2-2"
          content-cols-sm
          label-cols-sm="1"
          label-cols-lg="1"
          content-cols-lg="6"
        >
          <b-form-textarea
            id="input-2-2"
            v-model="form.detail"
            placeholder=""
            rows="6"
            maxlength='2000'
            required
          >
          </b-form-textarea>
        </b-form-group>
        <!-- 内容 -->

        <!--   ファイルアップロード start  -->
        <b-form-group
          id="input-group-2-6"
          label="画像:"
          label-for="input-2-6"
          content-cols-sm
          label-cols-sm="1"
          label-cols-lg="1"
          content-cols-lg="6"
        >
          <b-form-file
            v-model="form.file1"
            class="mt-3"
            plain
          >
          </b-form-file>
          <div class="mt-3">{{ file1 ? file1.name : '' }}</div>
        </b-form-group>
        <!--   ファイルアップロード end  -->

        <!-- 削除キー -->
        <b-form-group
          id="input-group-2-3"
          label="削除キー"
          label-for="input-2-3"
          content-cols-sm
          label-cols-sm="1"
          label-cols-lg="1"
          content-cols-lg="1"
        >
          <b-form-input
            id="input-2-3"
            v-model="form.delkey"
            placeholder="6桁"
            maxlength='6'
            required
          ></b-form-input>
        </b-form-group>
        <!-- 削除キー -->

        <!-- チェックボックス -->
        <b-form-group
          id="input-group-4"
          v-slot="{ ariaDescribedby }"
        >
          <b-form-checkbox-group
            v-model="form.checked"
            id="checkboxes-4"
            :aria-describedby="ariaDescribedby"
          >
            <b-form-checkbox id="checkbox-1"
                             v-model="status"
                             name="checkbox-1"
                             value="accepted"
            >
              利用規約に同意します
            </b-form-checkbox>

          </b-form-checkbox-group>
        </b-form-group>
        <!-- チェックボックス -->

        <b-button type="submit" variant="primary">投稿</b-button>
        <b-button type="reset" variant="danger">内容と画像をクリア</b-button>
      </b-form>

      <p>************************************************************</p>
      <!-- レコード表示 -->
      <div class="container">
        <table class="table">
          <thead class="thead-light" v-pre>
          <tr>
            <!-- TODO bootstarp-vueに書き直し -->
            <th class="postid" style="width: 10%">投稿ID</th>
            <th class="theme" style="width: 25%">テーマ</th>
            <th class="name" style="width: 25%">名前</th>
            <th class="detail" style="width: 20%">内容</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(computedRecord, index) in computedRecords" v-bind:key="computedRecord.id">
            <td class="index">{{ index + 1 }}</td>
            <td class="name">{{ computedRecord.name }}</td>
            <td class="memo">{{ computedRecord.detail }}</td>
          </tr>
          </tbody>
        </table>
      </div>
      <p>************************************************************</p>
      <!--    デバッグ用。送信内容を表示する start-->
      <b-card class="mt-3" header="デバッグ用">
        <pre class="m-0">{{ form }}</pre>
      </b-card>
      <!--    デバッグ用。送信内容を表示する end-->

    </b-container>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: function () {
    return {
      // 投稿した情報
      records: [],

      form: {
        theme: null,
        title: '',
        name: '',
        detail: '',
        file1: '',
        delkey: '',
        checked: []
      },
      themes: [
        {
          text: '選択してください',
          value: null
        },
        '雑談',
        '技術',
        '犬',
        'その他'
      ],
      show: true
    }
  },

  computed: {
    // 表示対象の情報を返却する
    computedRecords() {
      console.log(this.records);
      return this.records.filter(function (el) {
      // return this.current < 0 || this.current === el.state;
      }, this);
    },

  },

  created: function () {
    this.doFetchAllRecords();
  },

  methods: {
    // フォーム情報を送信する
    onSubmit(event) {
      event.preventDefault()
      if (this.validationCheck() === false) {
        return;
      }
      alert(JSON.stringify(this.form))
    },

    // フォームの「内容」「画像」「利用規約」を削除する
    onReset(event) {
      event.preventDefault()
      this.form.detail = ''
      this.form.checked = []
      this.form.file1 = null
      // Trick to reset/clear native browser form validation state
      this.show = false
      this.$nextTick(() => {
        this.show = true
      })
    },

    validationCheck(event) {
      // 利用規約への同意
      if (this.form.checked[0] !== 'accepted') {
        window.alert('利用規約への同意がありません');
        return false;
      } else {
        return true;
      }

      // TODO その他のバリデーションチェック

    },

    // 全てのTodoリスト情報を取得する
    doFetchAllRecords() {
      axios.get("/bbs/fetchAllRecords").then((response) => {
        if (response.status = 200) {
          this.records = response.data;
          console.log(this.records);
        } else {
          throw new Error("レスポンスエラー");
        }
      });
    },
  }
}
</script>
