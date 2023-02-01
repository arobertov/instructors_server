<template>
  <div>
    <div class="event event-caption">
      <h3>{{event.title}}</h3>
    </div>
    <div class="event-creation" v-if="event.owner">
      <p class="category-preview"><strong>Категория: </strong>{{event.category.name}}</p>
      <p id="date-user-data">написано от: {{event.owner.alias}} | дата: {{ event.dateEdited | formatDate }}</p>
    </div>
    <div style="clear: both"></div>
    <b-row>
      <b-col>
        <div class="event event-content">
          <span v-html="event.content" class="event-text"></span>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col md="2">
        <div class="event train-number" v-if="event.train">Влак №: {{event.train.trainNumber}}</div>
      </b-col>
      <b-col md="6">
        <div class="event train-number" v-if="event.trainFaults" >
          <b-button
              :id="`popover-id-${key}`"
              v-for="(selTF,key) in event.trainFaults"
              :key="key"
              size="sm"
              :variant="checkVariant(selTF)"
              class="m-1"
          >
            <b v-if="selTF.faultCategory!=='-'">Kат. {{selTF.faultCategory }}  </b>
            {{selTF.faultDescription}}
          </b-button>
        </div>
      </b-col>
    </b-row>
    <b-row>
      <b-col>
        <p v-if="checkAbility" id="owner-options"><a href="#">Редактирай! </a> | <a href="#">Изтрий!</a></p>
      </b-col>
    </b-row>
  </div>

</template>

<script>
export default {
  name: "EventPreview",
  computed:{
    event(){
      return this.$store.getters["EventModule/getItem"]
    },
    checkAbility(){
      const user = this.$store.getters["UserModule/getUser"];
      const event = this.$store.getters["EventModule/getItem"];
      if( user === null || !user.hasOwnProperty('alias')){
        return false;
      }
      if( user.hasOwnProperty('roles') && Array.isArray(user.roles)){
        if(user.roles.includes('ROLE_SUPER_ADMIN') || user.roles.includes('ROLE_ADMIN')) return true;
      }
      if(event !== null && event.hasOwnProperty('owner')){
        return user.alias === event.owner.alias;
      }
      return false;
    },
  },
  watch: {
    '$route.params': {
      handler(newValue) {
        this.$store.dispatch("EventModule/findEvent",newValue.id)
      },
      immediate: true,
    },
  },
  methods:{
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
  .event{
    margin-bottom: 1rem;
    background: #f4f4f4;
    border: 1px solid #aaa;
    border-radius: 0.25rem;
  }
  .event-creation{
    font-style: italic;
    color: #778080;
  }
  .event-creation #date-user-data{
    float: right;
  }
  #owner-options{
    float: left;
  }
  .event-caption{
    padding: 0.8rem;
    font-family: "Pt Serif", Serif;
  }

  .event-content,
  .train-number{
    padding:1rem 1rem 1.5rem 1.5rem;
  }
  .category-preview{
    padding-left: 2rem;
    float: left;
  }
</style>