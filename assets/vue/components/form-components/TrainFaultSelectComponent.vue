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
      <b-form-select
          id="_hmi-messages"
          v-bind:value="value"
          v-on:input="$emit('input', $event)"
          :options="options"
          multiple :select-size="4"
      >
      </b-form-select>
    </b-form-group>
  </b-container>
</template>

<script>
export default {
  name: "TrainFaultSelectComponent",
  props: ['value'],
  mounted() {
    this.$store.dispatch("TrainFaults/findTrains")
  },
  computed: {
    isSelectedTrainFaults(){
       return Array.isArray(this.selectedTrainFaults)&&this.selectedTrainFaults.length>0;
    },
    selectedTrainFaults:{
      get(){
        let selectedTrains = []
        if (Array.isArray(this.trainFaults) && this.trainFaults.length > 0) {
          selectedTrains = this.trainFaults.filter(tf =>this.value.includes(tf['@id']) );
          selectedTrains.map(st=>st.variant=this.checkVariant(st))
        }
        return selectedTrains;
      },
      set(value){
        this.$store.commit("EventModule/setTrainFaults",value.map(v=>v['@id']));
      }

    },
    trainFaults() {
      return this.$store.getters["TrainFaults/getItems"]["hydra:member"];
    },
    options(){
      let options = [];
      if(Array.isArray(this.trainFaults)){
        this.trainFaults.forEach(tf=>{
          options.push({text:tf.faultDescription,value:tf['@id']});
        })
      }
      return options;
    },
  },
  methods:{
    deselectTrainFaults(selectedValue){
      let selected = this.selectedTrainFaults.filter(tf=>!tf['@id'].includes(selectedValue));
      this.selectedTrainFaults = selected;
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