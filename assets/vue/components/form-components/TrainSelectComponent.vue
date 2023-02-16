<template>

  <b-form-group
      label="Номер на влак:"
      label-for="_train-select"
  >
    <b-form-select v-model="selectedTrain" :options="options" id="_train-select">
      <b-form-select-option :value="undefined">Изберете номер на влак</b-form-select-option>
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
    selectedTrain:{
      get:function (){
        let train = this.value;
        if(train !==null && typeof train ==='object' && train.hasOwnProperty('@id')){
          return train['@id']
        }
          return train;
      },
      set:function (newValue) {
        if(newValue!==undefined) this.$store.commit("EventModule/setTrain",newValue);
      }
    },
  }
}
</script>

<style scoped>

</style>