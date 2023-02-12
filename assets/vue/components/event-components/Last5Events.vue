<template v-if="events">
  <b-card no-body id="last5-events" v-if="events">
    <template #header>
      <h6>Последни събития</h6>
    </template>
    <b-list-group flush >
      <b-list-group-item v-for="event in events" :key="event.id + 100">
        <h5><router-link :to="{name:'site_event_preview',params:{id:event.id}}">{{event.title}}</router-link></h5>
        <elipsis :content="event.content" :word-length="45"/>
      </b-list-group-item>
    </b-list-group>
  </b-card>
</template>

<script>
import Elipsis from "@vue/components/common-component/Elipsis";
export default {
  name: "Last5Events",
  components:{Elipsis},
  mounted() {
    if(this.$store.getters["EventModule/getItems"].length===0){
      this.$store.dispatch("EventModule/findEvents");
    }
  },
  computed:{
    events(){
      let events = this.$store.getters["EventModule/getItems"]["hydra:member"];
      if(Array.isArray(events)&&events.length>4){
        return events.slice(0,5);
      }
      return events
    }
  }
}
</script>

<style scoped>

</style>