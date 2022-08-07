<template>
  <main>
    <navbar-top-menu :user="user"/>
    <b-container fluid="lg" id="wrapper">
      <b-breadcrumb :items="items"></b-breadcrumb>
      <router-view/>
      <login-form/>
      <register-form/>
    </b-container>
  </main>

</template>

<script>
import NavbarTopMenu from "../components/NavbarTopMenuComponent";
import LoginForm from "../components/security-component/LoginFormComponent";
import RegisterForm from "../components/security-component/RegisterFormComponent";
export default {
  name: "Homepage",
  components:{
    NavbarTopMenu,
    LoginForm,
    RegisterForm
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
#wrapper{
  padding: 0  ;
  background-color: #ffffff;
}
</style>