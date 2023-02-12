<template>
  <div class="alert-manager" >
    <b-alert v-if="alert.isError" show dismissible variant="danger"  >
      <a href="#" class="alert-link">{{alert.error}}</a>
    </b-alert>
    <b-alert v-if="alert.isSuccess" :show="5" dismissible variant="success" @dismissed="clearAlerts">
      <a href="#" class="alert-link">{{alert.successMessage}}</a>
    </b-alert>
  </div>
</template>

<script>
export default {
  name: "AlertManagerComponent",
  data(){
    return{
      alert:{}
    }
  },
  props:{
    alertMessage:{
      type: Object
    }
  },
  watch:{
    alertMessage(newval,oldval){
      if(newval) {
        this.alert = newval
      }
    }
  },
  methods:{
    clearAlerts(){
      this.alert = {
        isError: false,
        error: '',
        isSuccess: false,
        successMessage: ''
      };
    }
  }
}
</script>

<style scoped>

</style>