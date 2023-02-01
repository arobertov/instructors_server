<template>
  <event-form @submitForm="editEvent">
    <template v-slot:submit-btn="{invalid}">
      <b-button :disabled="invalid" type="submit" variant="success" id="submit-btn">Редактирай</b-button>
    </template>
  </event-form>
</template>

<script>
import EventForm from "@vue/components/event-components/EventFormComponent";
export default {
  name: "EditEventComponent",
  components:{
    EventForm
  },
  methods:{
    editEvent(ev){
      console.log(ev)
    }
  },
  watch: {
    '$route.params': {
      handler(newValue) {
        this.$store.dispatch("EventModule/findEvent", newValue.id)
      },
      immediate: true,
    },
  },
}
</script>

<style scoped>

</style>