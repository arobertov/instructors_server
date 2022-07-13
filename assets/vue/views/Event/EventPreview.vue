<template>
  <div>
    <div class="event-creation" v-if="event.owner">
      <p v-if="isOwner" id="owner-options"><a href="#">Редактирай! </a> | <a href="#">Изтрий!</a></p>
      <p id="date-user-data">написано от: {{event.owner.alias}} | дата: {{ event.dateEdited | formatDate }}</p>
    </div>
    <div style="clear: both"></div>
    <div class="event event-caption">
      <span class="mr-2">Заглавие: </span><h3 class="d-inline">{{event.title}}</h3>
    </div>
    <b-row>
      <b-col>
        <div class="event event-content">
          <p>Съдържание: <span v-html="event.content"></span></p>
        </div>
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
    user() {
      return this.$siteUser === null ? this.$store.getters["UserModule/getUser"] : this.$siteUser;
    },
    isOwner(){
      if(typeof this.event ==='object' && this.event.hasOwnProperty('owner')){

        return this.event.owner.alias === this.user.alias
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
  #date-user-data{
    float: right;
  }
  #owner-options{
    float: left;
  }
  .event-caption{
    padding:1rem 1rem 1.5rem 1.5rem;
  }
  .event-content{
    padding:1rem 1rem 1.5rem 1.5rem;
  }
</style>