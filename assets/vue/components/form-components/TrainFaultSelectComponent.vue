<template>
  <b-container class="train-faults-container mt-3">
    <b-row v-if="isSelectedTrainFaults">
      <b-col class="pt-3">
        <h6 class="train-faults-header">Избрани съобщения:</h6>
        <div  class="selected-message-area">
          <b-button
              :id="`popover-id-${key}`"
              v-for="(selTF,key) in selectedTrainFaults"
              :key="key"
              size="sm"
              :variant="selTF.variant"
              class="m-1"
          >
            <b v-if="selTF.faultCategory!=='-'">Kат. {{selTF.faultCategory }}  </b>
            {{selTF.faultId}}
            <b aria-keyshortcuts="Delete" type="button" @click="deselectTrainFaults(selTF['@id'])">×</b>
          </b-button>
        </div>
      </b-col>
    </b-row>
    <b-form-group
        label="Съобщения на HMI:"
        label-for="_hmi-messages"
    >
      <b-input-group size="sm">
        <b-input-group-prepend>
          <b-button disabled>Филтър <b-icon icon="search"></b-icon></b-button>
        </b-input-group-prepend>
        <b-form-input
            id="filter-input"
            v-model="filterKey"
            type="search"
            placeholder="Въведи стойност за търсене"
        ></b-form-input>

        <b-input-group-append>
          <b-button :disabled="!filterKey" @click="filterKey = ''">Изчисти</b-button>
        </b-input-group-append>
      </b-input-group>
      <b-form-select
          id="_hmi-messages"
          v-bind:value="value"
          v-on:input="$emit('input', $event)"
          :options="options"
          multiple :select-size="8"
      >
      </b-form-select>
    </b-form-group>
  </b-container>
</template>

<script>

export default {
  name: "TrainFaultSelectComponent",
  props: ['value'],
  data(){
    return{
      filterKey:"",
    }
  },
  mounted() {
    this.$store.dispatch("TrainFaults/findTrainFaults")
  },
  destroyed() {
    this.$store.commit("EventModule/creatingEvent");
  },
  computed: {
    isSelectedTrainFaults(){
       return Array.isArray(this.selectedTrainFaults)&&this.selectedTrainFaults.length>0;
    },
    selectedTrainFaults:{
      get(){
        let selectedTrains = [];
        if (Array.isArray(this.trainFaults) && this.trainFaults.length > 0 && this.value !== undefined) {
          selectedTrains = this.trainFaults.filter(tf =>this.value.includes(tf['@id']) );
          selectedTrains.map(st=>st.variant=this.checkVariant(st));
          return selectedTrains;
        }
        return selectedTrains;
      },
      set(value){
        this.$store.commit("EventModule/setTrainFaults",value.map(v=>v['@id']));
      }

    },
    trainFaults() {
      return  this.$store.getters["TrainFaults/getItems"]["hydra:member"];
    },
    options(){
      if(Array.isArray(this.trainFaults)){
        let options = this.trainFaults.map(function (tf){
          return{
            text:tf.faultDescription,
            value:tf['@id']
          }
      })
        options = options.filter(v => v.text.toLowerCase().includes(this.filterKey.toLowerCase()))
        return options.length>0?options:options =[{text:"Няма запис отговарящ на търсенето"}];
      }
    },
  },

  methods:{
    deselectTrainFaults(selectedValue){
      this.selectedTrainFaults = this.selectedTrainFaults.filter(tf => !tf['@id'].includes(selectedValue));
    },
    checkVariant(st){
      switch (st.faultCategory) {
          case 'A':
            return 'danger'
          case 'B':
            return 'dark'
          case 'C':
            return 'warning'
          case 'D':
            return 'light'
          default:
            return 'info'
      }
    },
  }
}
</script>

<style scoped>
  .train-faults-container{
    border: 2px solid #ccc;
    border-radius: 0.25rem
  }
  .train-faults-header{
    display: inline;
    margin-right: 0.5rem;
    margin-left: 1rem;
    color:#212529
  }
  .selected-message-area{
    width: 100%;
    background-color: #e0e0e0;
    border: 1px solid #ccc;
    border-radius: 0.25rem;
    margin-right: 1rem;
    display: inline-block;
  }
  .btn-dark{
    background-color: #ea5916;
    border-color: #343a40;
  }
</style>