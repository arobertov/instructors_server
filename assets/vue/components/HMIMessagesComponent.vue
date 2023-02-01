<template>
  <div>
    <b-row>
      <b-col lg="12">
        <b-pagination
            v-model="currentPage"
            align="center"
            :total-rows = totalItems
            :per-page= recordsPerPage
            size="sm"
            aria-controls="train-fault"
            class="mt-4"
        ></b-pagination>
      </b-col>
    </b-row>
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
            label="ПО КОЛОНИ:"
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
            <b-form-checkbox value="faultId">ID</b-form-checkbox>
            <b-form-checkbox value="faultDescription">СЪБИТИЕ</b-form-checkbox>
            <b-form-checkbox value="faultCategory">КАТЕГОРИЯ</b-form-checkbox>
          </b-form-checkbox-group>
        </b-form-group>
      </b-col>
    </b-row>

    <b-table
        id="train-fault"
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
    </b-table>
    <b-pagination
        v-model="currentPage"
        :total-rows = totalItems
        :per-page= recordsPerPage
        align="center"
        size="sm"
        aria-controls="train-fault"
    ></b-pagination>
  </div>
</template>

<script>
export default {
  name: "HMIMessages",
  data(){
    return{
      recordsPerPage:30,
      currentPage:1,
      sortDirection: 'asc',
      filter: null,
      filterOn: [],
    }
  },
  mounted() {
    this.$store.dispatch("TrainFaults/findTrainFaults")
  },
  computed:{
    items(){
      return this.$store.getters["TrainFaults/getItems"]["hydra:member"];
    },
    fields(){
      return [
        {
          key:'faultId',
          label:'ID',
          sortable: true
        },
        {
          key:'faultDescription',
          label:'СЪБИТИЕ',
        },
        {
          key:'shortAdvice',
          label:'КЪС СЪВЕТ',
        },
        {
          key:'longAdvice',
          label:'ДЪЛЪГ СЪВЕТ',
        },
        {
          key:'faultCategory',
          label:'КАТЕГОРИЯ',
          sortable: true,
          tdClass:(type, key, item) => {
            switch (item.faultCategory) {
              case "A":
                return "text-center align-middle table-danger";
                break;
              case "B":
                return "text-center align-middle table-danger";
                break;
              case "C":
                return "text-center align-middle table-warning";
                break;
              default:
                return "text-center align-middle";
            }
          },

        },
      ]
    },
    totalItems:{
      get(){
        return this.$store.getters["TrainFaults/getItems"]["hydra:totalItems"];
      },
      set(value){

      }
    }
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