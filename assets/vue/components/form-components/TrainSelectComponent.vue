<template>

  <b-form-group
      label="Номер на влак:"
      label-for="_train-select"
  >
    <b-form-select
        id="_train-select"
        v-bind:value="value"
        v-on:input="$emit('input', $event)"
        :options="options" >
      <b-form-select-option :value="null">Изберете номер на влак</b-form-select-option>
    </b-form-select>
  </b-form-group>
</template>

<script>
export default {
  name: "TrainSelectComponent",
  props: ['value'],
  beforeMount() {
    let trains = this.$store.getters["TrainModule/getItems"];
    if(Array.isArray(trains) && trains.length===0){
      this.$store.dispatch("TrainModule/findTrains");
    }
  },
  computed:{
    options(){
      let trains = this.$store.getters["TrainModule/getItems"]["hydra:member"];
      if(Array.isArray(trains)){
        return trains.map(function (t){return { text:t.trainNumber, value:t['@id'] }});
      }
      return  trains;
    },
  }
}
</script>

<style scoped>

</style>