import Vue from 'vue';
import Homepage from "@vue/views/Homepage";
import Common from '@vue/common-index';
import router from '@vue/router/main-router';
import store from "@vue/store/index";

Common.vueCommonSets();

Vue.prototype.$siteUser = window.user;

new Vue({
  components:{Homepage},
  template:"<Homepage/>",
  router,
  store
}).$mount('#vue-entry');