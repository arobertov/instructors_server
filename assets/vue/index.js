import Vue from 'vue';
import Homepage from "@vue/views/Homepage";
import Common from '@vue/common-index';
import router from '@vue/router/main-router';
import store from "@vue/store/index";

Common.vueCommonSets();

Vue.prototype.$siteUser = window.user;

router.beforeEach((to, from, next)=> {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if(!store.getters["UserModule/getIsLogin"]){
      next({name: 'site_index'});
    }
    else{
      next();
    }
  } else {
    next();
  }
});
new Vue({
  components:{Homepage},
  template:"<Homepage/>",
  router,
  store
}).$mount('#vue-entry');