<template>
  <div>
    <p>{{categories}}</p>
  </div>

</template>

<script>
export default {
  name: "CategoriesListView",
  computed:{
    categories(){
      return this.$store.getters["CategoryModule/getCategories"]
    }
  }
}
</script>

<style scoped>

</style>