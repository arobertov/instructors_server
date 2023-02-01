<template>
  <div>
    <h1>Публикувай събитие</h1>
    <b-alert show dismissible variant="danger" v-if="isError">
      {{ error }}
    </b-alert>
    <b-container>
      <event-form @submitForm="createEvent"></event-form>
    </b-container>
  </div>
</template>

<script>
import EventForm from "@vue/components/event-components/EventFormComponent";

export default {
  name: "EventCreateView",
  components:{
    EventForm
  },
  mounted() {
    this.$store.commit("EventModule/creatingEvent");
  },
  beforeDestroy() {
    this.$store.commit("EventModule/creatingEvent");
  },
  computed:{
    isError(){
      return this.$store.getters["EventModule/isError"]
    },
    error(){
      return this.$store.getters["EventModule/getError"]
    },
  },
  methods:{
     async createEvent(event){
       const result = await this.$store.dispatch("EventModule/createEvent",event);
       if(result.hasOwnProperty('id')){
         await this.$router.push({name:"site_event_preview",params:{"id":result.id}})
       }
       return result;
    }
  }
}
</script>

<style scoped>

</style>