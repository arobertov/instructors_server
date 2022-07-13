<template>
  <div>
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
        <router-link :to="{name:'site_event_preview',params:{id:data.item.id}}">{{data.item.title}}</router-link>
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
</template>

<script>
export default {
  name: "ListEvents",
  data(){
    return{
      recordsPerPage:5,
      currentPage:1,
      sortDirection: 'asc',
      filter: null,
      filterOn: [],
    }
  },
  computed:{
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
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalItems = filteredItems.length
      this.currentPage = 1
    }
  }
}
</script>

<style scoped>

</style>