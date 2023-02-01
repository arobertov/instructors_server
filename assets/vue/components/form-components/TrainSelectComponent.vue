<template>
  <b-form-group
      label="Номер на влак:"
      label-for="_train-select"
  >
    <b-form-select v-model="train" :options="options" id="_train-select">
      <b-form-select-option :value="null">Изберете номер на влак</b-form-select-option>
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
  computed:{
    options(){
      let trains = this.$store.getters["TrainModule/getItems"]["hydra:member"],trainNumber;
      if(Array.isArray(trains)){
        trainNumber = trains.map(function (t){
          return{
            text:t.trainNumber,
            value:t['@id']
          }
        });
      }
      return  trainNumber;
    },
    train:{
      get:function (){
        let event = this.event;
        if(event !== null && event.train !== null){
          if(typeof event ==='object'&& event.train.hasOwnProperty('@id')){
            return event.train['@id'];
          }
          return event.train;
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