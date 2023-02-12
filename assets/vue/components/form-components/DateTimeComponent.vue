<template>
  <div class="my-2">
    <p>{{dateCreated}}</p>
    <label for="event-datepicker" >Изберете дата на събитието</label>
    <b-form-datepicker id="event-datepicker" v-model="value" value-as-date></b-form-datepicker>
  </div>

</template>

<script>
export default {
  name: "DateTimeComponent",
  props:['value']
}
</script>

<style scoped>

</style>