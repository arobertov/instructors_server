<template>
  <b-card no-body id="category-events" v-if="category">
    <template #header>
      <h6>Събития по категории</h6>
    </template>
    <b-list-group flush  v-if="category.events">
      <b-list-group-item v-for="event in category.events" :key="event.id">
        <h5><router-link :to="{name:'site_event_preview',params:{id:event.id}}">{{event.title}}</router-link></h5>
        <elipsis :content="event.content" :word-length="45"/>
      </b-list-group-item>
    </b-list-group>
  </b-card>
</template>

<script>
import Elipsis from "@vue/components/common-component/Elipsis";

export default {
  name: "EventsByCategory",
  components:{Elipsis},
  computed:{
    category(){
      return this.$store.getters["CategoryModule/getCategory"];
    }
  },
  watch: {
    '$route.params': {
      handler(newValue) {
        this.$store.dispatch("CategoryModule/findCategory",newValue.category_id)
      },
      immediate: true,
    },
  },
}
</script>

<style scoped>

</style>