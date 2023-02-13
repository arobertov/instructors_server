<template>
  <main>
    <b-container fluid="lg" id="wrapper">
      <navbar-top-menu :user="user"/>
      <div class="site-breadcrumb"><b-breadcrumb :items="items"></b-breadcrumb></div>
      <router-view/>
      <login-form/>
      <register-form/>
    </b-container>
    <b-container fluid="lg" id="footer-wrapper">
      <site-footer/>
    </b-container>
  </main>

</template>

<script>
import NavbarTopMenu from "../components/NavbarTopMenuComponent";
import LoginForm from "../components/security-component/LoginFormComponent";
import RegisterForm from "../components/security-component/RegisterFormComponent";
import SiteFooter from "@vue/components/SiteFooterComponent";

export default {
  name: "Homepage",
  components:{
    NavbarTopMenu,
    LoginForm,
    RegisterForm,
    SiteFooter
  },
  data() {
    return {
      items: this.$route.meta.item
    }
  },
  mounted() {
    if (window.user) {
      this.$store.commit("UserModule/USER_LOGIN",window.user);
    }
    if(this.$store.getters["EventModule/getItems"].length===0){
      this.$store.dispatch("EventModule/findEvents");
    }
  },
  computed:{
    user() {
      return this.$siteUser == null ? this.$store.getters["UserModule/getUser"] : this.$siteUser;
    },

  },
  watch:{
    '$route'(){
      this.items = this.$route.meta.item;
    }
  },
}
</script>

<style scoped>
body{
  margin: 0;
  font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,Liberation Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #212529;
  text-align: left;
}
.site-breadcrumb{
  margin: 5px 15px;
}
#wrapper,
#footer-wrapper {
  padding: 0;
  background-color: #cccccc;
}
</style>