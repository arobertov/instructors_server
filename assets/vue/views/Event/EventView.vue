<template>
  <div id="content-wrapper">
    <router-view></router-view>
  </div>

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

}
</style>