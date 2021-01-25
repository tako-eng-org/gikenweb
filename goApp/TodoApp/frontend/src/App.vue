<template>
  <div id="app">
    <!-- ヘッダー設定ここから -->
    <myheader></myheader>
    <!-- ヘッダー設定ここまで -->

    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
    <button type="button" class="btn btn-primary">テストボタン_Primary</button>

    <!-- テストコードここから -->
    <todolist></todolist>
    <my-conponent></my-conponent>
    <!-- テストコードここまで -->

    <!-- フッター設定ここから -->
    <myfooter></myfooter>
    <!-- フッター設定ここまで -->
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'
import myheader from './components/myheader'
import todolist from './components/todolist.vue'
import myfooter from './components/myfooter'

export default {
  // name: 'App',
  name: 'app',
  components: {
    HelloWorld,
    myheader,
    todolist,
    myfooter,
  }

}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
