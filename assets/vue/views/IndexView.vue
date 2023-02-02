<template>
  <b-row>
    <b-col md="8" order-md="2" class="mb-3">
      <last5-events/>
    </b-col>
    <b-col md="4" order-md="1">
      <aside-component/>
    </b-col ><!--------- aside ----------->
  </b-row>
</template>

<script>
import Last5Events from "@vue/components/event-components/Last5Events";
import AsideComponent from "@vue/components/AsideComponent";

export default {
  name: "IndexView",
  components:{Last5Events,AsideComponent},
}
</script>

<style scoped>
  .row{
    margin:0;
  }
</style>