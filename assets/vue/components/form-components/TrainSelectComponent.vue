<template>
  <b-form-group
      label="Номер на влак:"
      label-for="_train-select"
  >
    <b-form-select v-model="train" :options="options" id="_train-select">
      <b-form-select-option :value="undefined">Изберете номер на влак</b-form-select-option>
    </b-form-select>
  </b-form-group>
</template>

<script>
export default {
  name: "TrainSelectComponent",
  props:{
    event:{
      type:Object
    }
  },
  beforeMount() {
    let trains = this.$store.getters["TrainModule/getItems"];
    if(Array.isArray(trains) && trains.length===0){
      this.$store.dispatch("TrainModule/findTrains");
    }
  },
  computed:{
    options(){
      let trains = this.$store.getters["TrainModule/getItems"]["hydra:member"],trainNumber;
      if(Array.isArray(trains)){
        return trains.map(function (t){
          return { text:t.trainNumber, value:t['@id'] }
        });
      }
      return  trainNumber;
    },
    train:{
      get:function (){
        let event = this.event;
        if(event !== null){
          if( typeof event ==='object'&& event.hasOwnProperty('train') && event.train !== null ){
            if(event.train.hasOwnProperty('@id')) return  event.train['@id']
          }
          return undefined;
        }
      },
      set:function (newValue) {
        this.event.train = newValue
      }
    },
  }
}
</script>

<style scoped>

</style>