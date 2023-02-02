<template>
  <validation-observer ref="publicationForm" v-slot="{ handleSubmit, invalid}">
    <b-form @submit.stop.prevent="onSubmit">
      <title-input v-model="title" placeholder="Въведете заглавие с дължина минимум от 3 символа"/>
      <content-input v-model="content" placeholder="Въведете текст на събитието..."/>
      <image-manager/>
      <train-select :event="event"></train-select>
      <category-select v-model="category"/>
      <train-fault v-model="trainFaults"/>
      <b-form-row>
        <div class="m-4">
          <slot name="submit-btn" :invalid="invalid">
            <b-button :disabled="invalid" type="submit" variant="success" id="submit-btn">Публикувай</b-button>
          </slot>
        </div>
      </b-form-row>
    </b-form>
  </validation-observer>
</template>

<script>
import TitleInput from "@vue/components/form-components/TitleInputComponent";
import ContentInput from "@vue/components/form-components/ContentInputComponent";
import ImageManager from "@vue/components/form-components/ImageManagerComponent";
import CategorySelect from "@vue/components/form-components/CategorySelectComponent";
import TrainFault from "@vue/components/form-components/TrainFaultSelectComponent";
import TrainSelect from "@vue/components/form-components/TrainSelectComponent";
import {mapFields} from "vuex-map-fields";


export default {
  name: "EventFormComponent",
  components:{
    TitleInput, ContentInput,CategorySelect,TrainFault,ImageManager,TrainSelect
  },
  mounted() {
    this.$store.dispatch("TrainModule/findTrains");
  },
  computed:{
    event(){
      return this.$store.getters["EventModule/getItem"];
    },
    trainFaults:{
      get(){
        let selectedTrains = [],trainFaults = this.event.trainFaults
        if (Array.isArray(trainFaults) && trainFaults.length > 0) {
          selectedTrains = trainFaults.map(tf=>tf['@id'])
          console.log(selectedTrains)
          return selectedTrains;
        }
        return trainFaults
      },
      set(value){
        this.$store.commit("EventModule/setTrainFaults",value.map(v=>v['@id']));
      }
    },
    ...mapFields("EventModule",[
    'event.title',
    'event.content',
    'event.category',
    'event.trainFaults',
  ]),
    events(){
      return this.$store.getters["EventModule/getItems"]["hydra:member"];
    },
  },
  methods:{
    onSubmit(){
      this.$refs.publicationForm.validate().then(success => {
        if (success) {
          this.$emit('submitForm',this.event)
        }
      })
    },
  }
}
</script>

<style scoped>

</style>