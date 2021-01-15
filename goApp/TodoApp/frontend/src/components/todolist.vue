<template>
  <div class="container">
    <div class="row">
      <h1>Todoリスト</h1>
    </div>
    <!-- 検索条件 -->
    <div class="form-check form-check-inline">
      <!--      <label class="form-check-label" v-for="label in options">-->
      <label class="form-check-label" v-for="(label, key) in options" :key="key">
        <input
            class="form-check-input"
            type="radio"
            v-model="current"
            v-bind:value="label.value"
        />{{ label.label }}
      </label>
    </div>

    <form>
      <div class="form-group row">
        <label for="todona" class="col-sm-2 col-form-label">タイトル</label>
        <div class="col-sm-10">
          <input
              type="text"
              class="form-control"
              id="todona"
              name="todoName"
              v-model="todoName"
              v-bind:class="{'alert-color': !validate }"
              value=""
              placeholder="Todoタイトルを入力してください※必須"
          />
        </div>
      </div>
      <div class="form-group row">
        <label for="todome" class="col-sm-2 col-form-label">メモ</label>
        <div class="col-sm-10">
          <input
              type="text"
              class="form-control"
              id="todome"
              name="todoMemo"
              v-model="todoMemo"
              value=""
          />
        </div>
      </div>
      <!-- 追加ボタン -->
      <div class="form-group">
        <button
            class="btn btn-primary"
            v-on:click="doAddTodo"
            v-bind:disabled="!isEntered"
        >
          追加
        </button>
      </div>
    </form>

    <hr/>
    <div class="container">
      <table class="table">
        <!-- テーブルヘッダー -->
        <thead class="thead-light" v-pre>
        <th class="index" style="width: 10%">No</th>
        <th class="name" style="width: 25%">タイトル</th>
        <th class="memo" style="width: 25%">メモ</th>
        <th class="state" style="width: 20%">状態</th>
        <th class="delete" style="width: 20%">削除</th>
        </thead>
        <tbody>
        <tr v-for="(item, index) in computedTodos" v-bind:key="item.id">
          <td class="index">{{ index + 1 }}</td>
          <td class="name">{{ item.name }}</td>
          <td class="memo">{{ item.memo }}</td>
          <td class="state">
            <!-- 状態変更ボタン -->
            <button
                class="btn btn-outline-secondary"
                v-on:click="doChangeTodoState(item)"
            >
              {{ labels[item.state] }}
            </button>
          </td>
          <td class="delete">
            <!-- 削除ボタン -->
            <button
                class="btn btn-outline-secondary"
                v-on:click="doDeleteTodo(item)"
            >
              削除
            </button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>