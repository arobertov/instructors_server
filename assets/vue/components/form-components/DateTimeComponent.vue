<template>
  <div class="my-3">
    <label for="event-datepicker" >Изберете дата на събитието</label>
    <b-form-datepicker id="event-datepicker" v-model="dateCreated" value-as-date></b-form-datepicker>
  </div>

</template>

<script>
export default {
  name: "DateTimeComponent",
  computed:{
    dateCreated:{
      get:function (){
        return this.$store.getters["EventModule/getItem"].dateCreated;
      },
      set:function (value) {
        this.$store.commit("EventModule/setDateCreated",value);
      }
    }
  }
}
</script>

<style scoped>

</style>