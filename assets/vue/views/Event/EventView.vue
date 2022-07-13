<template>
  <b-container fluid="lg" id="content-wrapper">
    <router-view></router-view>
  </b-container>

</template>

<script>
export default {
  name: "EventView",
}
</script>

<style scoped>
#content-wrapper{
  padding-top: 10px;
  padding-bottom: 15px;
  background-color: #ffffff;
}
</style>