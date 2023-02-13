<template>
  <div v-if="totalItems>0">
    <b-row>
      <b-col lg="6">
        <b-form-group
            label=""
            label-for="filter-input"
            label-cols-sm="3"
            label-align-sm="right"
            label-size="sm"
            class="mb-0"
        >
          <b-input-group size="sm">
            <b-input-group-prepend>
              <b-button disabled>Филтър <b-icon icon="search"></b-icon></b-button>
            </b-input-group-prepend>
            <b-form-input
                id="filter-input"
                v-model="filter"
                type="search"
                placeholder="Въведи стойност за търсене"
            ></b-form-input>

            <b-input-group-append>
              <b-button :disabled="!filter" @click="filter = ''">Изчисти</b-button>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col lg="6">
        <b-form-group
            v-model="sortDirection"
            label="Търсене по колони:"
            description="Ако не е избрано нищо, ще търси в цялата таблица"
            label-cols-sm="3"
            label-align-sm="right"
            label-size="sm"
            class="mb-0"
            v-slot="{ ariaDescribedby }"
        >
          <b-form-checkbox-group
              v-model="filterOn"
              :aria-describedby="ariaDescribedby"
              class="mt-1"
          >
            <b-form-checkbox value="id">ID</b-form-checkbox>
            <b-form-checkbox value="title">Заглавие</b-form-checkbox>
            <b-form-checkbox value="category.name">Категория</b-form-checkbox>
            <b-form-checkbox value="trainFaults">HMI Съобщ.</b-form-checkbox>
            <b-form-checkbox value="dateEdited">Дата</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
      </b-col>
    </b-row>

    <b-table
        id="events"
        striped bordered hover
        responsive
        :items="items"
        :fields="fields"
        :current-page = currentPage
        :per-page = recordsPerPage
        :filter= filter
        :filter-included-fields= filterOn
        @filtered="onFiltered"
    >
      <template v-slot:cell(title)="data">
        <router-link :to="{name:'site_event_preview',params:{id:data.item.id}}">{{data.item.title}}</router-link><br>
        <b-button-group  v-if="checkAbility(data.item)">
          <b-button :to="{name:'site_edit_preview',params:{id:data.item.id}}" variant="outline-warning">Редактирай</b-button>
          <b-button variant="outline-danger" @click="deleteMsgBox(data.item)">Изтрий</b-button>
        </b-button-group>
      </template>
      <template v-slot:cell(trainFaults)="data">
        <ul>
          <li v-for="trainFault in data.item.trainFaults">{{trainFault.faultId}}</li>
        </ul>
      </template>
      <template v-slot:cell(dateEdited)="data">
        {{data.item.dateEdited | formatDate}}
      </template>
    </b-table>
    <div>
      <b-button variant="success">Публикувани са <b-badge variant="light">{{totalItems}}</b-badge> събития</b-button>
      <b-pagination
          v-model="currentPage"
          :total-rows = totalItems
          :per-page= recordsPerPage
          align="center"
          size="sm"
          aria-controls="events"
      ></b-pagination>
    </div>
  </div>
  <div v-else>
    <h3>Няма нито едно публикувано събитие!</h3>
    <h5>Бъди първия който ще публикува ---> <b-button variant="success" :to="{name:'site_events_create'}">Публикувай!</b-button></h5>
  </div>
</template>

<script>
export default {
  name: "ListEvents",
  data(){
    return{
      recordsPerPage:10,
      currentPage:1,
      sortDirection: 'asc',
      filter: null,
      filterOn: [],
    }
  },
  computed:{
    user() {
      return this.$store.getters["UserModule/getUser"];
    },
    items(){
      return this.$store.getters["EventModule/getItems"]["hydra:member"]
    },
    totalItems:{
      get(){
        return this.$store.getters["EventModule/getItems"]["hydra:totalItems"];
      },
      set(value){

      }
    },
    fields(){
      return [
        {
          key:'id',
          label:'ID',
          sortable: true
        },
        {
          key:'title',
          label:'Заглавие',
          sortable:true
        },
        {
          key:'category.name',
          label:'Категория',
          sortable:true
        },
        {
          key:'train.trainNumber',
          label: 'Влак',
          sortable: true
        },
        {
          key:'trainFaults',
          label:'HMI съобщ.'
        },
        {
          key:'dateEdited',
          label:'Дата',
          sortable: true,
        },
        {
          key:'owner.alias',
          label:'Автор',
          sortable:true
        },
      ]
    },
  },
  methods:{
    checkAbility(event){
      const user = this.user;
      //$store.getters["UserModule/getUser"];
      //const event = this.$store.getters["EventModule/getItem"];
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
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalItems = filteredItems.length
      this.currentPage = 1
    },
    async deleteEvent(id) {
      const result = await this.$store.dispatch("EventModule/deleteEvent",id);
      console.log(result)
    },
    deleteMsgBox(event){
      this.$bvModal.msgBoxConfirm('Потвърдете че желаете да изтриете събитието: -  '+ event.title +'!', {
        title: 'МОЛЯ ПОТВЪРДЕТЕ',
        okVariant: 'danger',
        okTitle: 'ДА',
        cancelTitle: 'НЕ',
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true
      })
          .then(value => {
            if(value) this.deleteEvent(event.id);
          })
          .catch(err => {
            console.log(err)
          })
    },
  }
}
</script>

<style scoped>
.btn{
  padding: 0.1rem 0.7rem;
  font-size: 0.75rem;
}
.btn-outline-warning{
  color: #333336;
  border-color: #333336;
}
</style>