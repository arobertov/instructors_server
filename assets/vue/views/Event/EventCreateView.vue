<template>
  <div>
    <h1>Публикувай събитие</h1>
    <b-alert show dismissible variant="danger" v-if="isError">
      {{ error }}
    </b-alert>
    <b-container>
      <validation-observer ref="publicationForm" v-slot="{ handleSubmit, invalid}">
        <b-form @submit.stop.prevent="handleSubmit(onSubmit)">
          <title-input v-model="title" placeholder="Въведете заглавие с дължина минимум от 3 символа"/>
          <content-input v-model="content" placeholder="Въведете текст на събитието..."/>
          <b-form-group
              label="Номер на влак:"
              label-for="_train-select"
          >
            <b-form-select v-model="train" :options="options" id="_train-select">
              <b-form-select-option :value="null">Изберете номер на влак</b-form-select-option>
            </b-form-select>
          </b-form-group>
          <category-select v-model="category"/>
          <train-fault v-model="trainFaults"/>
          <b-form-row>
            <div class="m-4">
              <b-button :disabled="invalid" type="submit" variant="success" id="submit-btn">Публикувай</b-button>
            </div>
          </b-form-row>
        </b-form>
      </validation-observer>
    </b-container>
  </div>
</template>

<script>
import {mapFields} from 'vuex-map-fields';
import TitleInput from "../../components/form-components/TitleInputComponent";
import ContentInput from "../../components/form-components/ContentInputComponent";
import CategorySelect from "../../components/form-components/CategorySelectComponent";
import TrainFault from "../../components/form-components/TrainFaultSelectComponent";
import loginFormComponent from "../../components/security-component/LoginFormComponent";
export default {
  name: "EventCreateView",
  components:{
    TitleInput, ContentInput,CategorySelect,TrainFault
  },
  mounted() {
    this.$store.commit("EventModule/creatingEvent");
    this.$store.dispatch("TrainModule/findTrains");
    this.$store.dispatch("EventModule/findEvents");
  },
  beforeDestroy() {
    this.$store.commit("EventModule/creatingEvent");
  },
  computed:{
    event(){
      return this.$store.getters["EventModule/getItem"];
    },
    events(){
      return this.$store.getters["EventModule/getItems"]["hydra:member"];
    },
    isError(){
        return this.$store.getters["EventModule/isError"]
     },
    error(){
      return this.$store.getters["EventModule/getError"]
    },
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
    ...mapFields("EventModule",[
        'event.title',
        'event.content',
        'event.category',
        'event.train',
        'event.trainFaults'
    ])
  },
  methods:{
    onSubmit(){
      this.$refs.publicationForm.validate().then(success => {
        if (success) {
          this.createEvent()
        }
      })

    },
     async createEvent(){
       const result = await this.$store.dispatch("EventModule/createEvent",this.event);
       if(result.hasOwnProperty('id')){
         await this.$router.push({name:"site_event_preview",params:{"id":result.id}})
       }
       return result;
    }
  }
}
</script>

<style scoped>

</style>