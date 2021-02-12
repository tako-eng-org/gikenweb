import Vue from "vue";
import App from "./App.vue";
// --bootstrapのimport START--
import {BootstrapVue, IconsPlugin} from "bootstrap-vue";
// Import Bootstrap an BootstrapVue CSS files (order is important)
import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
// --bootstrapのimport END--

if ( `${process.env.NODE_ENV}` === 'local' ){
    // vue設定がlocalの場合、開発用ヒントをコンソールへ表示する
    Vue.config.productionTip = true;
}

const vm = new Vue({
    render: h => h(App)
});
vm.$mount("#app");

// --bootstrap設定 START--
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue);
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin);
// --bootstrap設定 END--