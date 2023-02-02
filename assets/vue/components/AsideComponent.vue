<template>
  <div>
    <b-card class="mb-2" no-body>
      <template #header>
        <h6>Категории</h6>
      </template>
      <b-list-group flush v-if="categories">
        <b-list-group-item
            class="d-flex justify-content-between align-items-center"
            v-for="category in categories" :key="category.id"
            :to="{name:'site_event_by_category_preview',params:{category_id:category.id}}"
        >
          {{category.name}}
          <b-badge variant="secondary" v-if="Array.isArray(category.events)">{{category.events.length}}</b-badge>
        </b-list-group-item>
      </b-list-group>
      <b-list-group v-else>
        <b-list-group-item>Няма публикувани категории</b-list-group-item>
      </b-list-group>
    </b-card> <!---  categories list ----->
    <b-card no-body class="mb-3">
      <template #header>
        <h6 variant="light" v-b-toggle.collapse-train class="mb-0">
          Влакове
          <b-icon class="ml-2" icon="arrow-down-short"></b-icon>
        </h6>
      </template>
      <b-collapse id="collapse-train" class="mt-2">
        <b-list-group flush v-if="trains">
          <b-list-group-item
              class="d-flex justify-content-between align-items-center"
              v-for="train in trains" :key="train.id"
          >
            {{train.trainNumber}}
            <b-badge variant="secondary" v-if="Array.isArray(train.events)">{{train.events.length}}</b-badge>
          </b-list-group-item>
        </b-list-group>
        <b-list-group v-else>
          <b-list-group-item>Няма публикувани влакове</b-list-group-item>
        </b-list-group>
      </b-collapse>
    </b-card><!---  trains list ----->
  </div>
</template>

<script>
export default {
  name: "AsideComponent",
  beforeCreate() {
    const categories = this.$store.getters["CategoryModule/getCategories"]
    if(Array.isArray(categories)&&categories.length===0){
      this.$store.dispatch("CategoryModule/findCategories");
    }
    const trains = this.$store.getters["TrainModule/getItems"];
    if(Array.isArray(trains)&&trains.length===0){
      this.$store.dispatch("TrainModule/findTrains");
    }
  },
  computed:{
    categories() {
      return this.$store.getters["CategoryModule/getCategories"]["hydra:member"];
    },
    trains(){
      return this.$store.getters["TrainModule/getItems"]["hydra:member"];
    }
  }
}
</script>

<style scoped>

</style>