import Vue from "vue";
import App from "./App.vue";
import todoList from "./components/todolist.vue"
// --bootstrapのimport START--
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";
// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
// --bootstrapのimport END--

if ( `${process.env.NODE_ENV}` === 'local' ){
    // 開発用tipsをONにする
    Vue.config.productionTip = true;
}

// コンポーネントをグローバル登録する(すべてのコンポーネントの中で使えるようにする)
Vue.component('todoList', todoList)

const vm = new Vue({
    render: h => h(App)
});
vm.$mount("#app");

// --bootstrap設定 START--
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
Vue.config.productionTip = false;
// --bootstrap設定 END--

// console.log(App);
