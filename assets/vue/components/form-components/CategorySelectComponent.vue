<template>
  <b-form-row>
    <b-col lg="12" class="alerts">
      <b-alert class="small"
               v-if="isSuccess"
               :show="dismissCountDown"
               variant="success"
               dismissible
               @dismiss-count-down="countDownChanged"
               fade
      >
        {{ successMessage }}
      </b-alert>
    </b-col>
    <div class="col-lg-6 mb-3">
      <validation-provider
        name="Категория"
        :rules="{ required: true }"
        v-slot="validationContext"
        >
          <b-form-group
          label="Категория :"
          label-for="_category"
          class="d-inline"
      >
        <b-form-select
            id="_category"
            v-bind:value="valueSelect"
            v-bind:selected="true"
            v-on:input="$emit('input', $event)"
            :options="options"
            :state="getValidationState(validationContext)"
            aria-describedby="category-live-feedback"
        >
          <template #first>
            <b-form-select-option
                value="null"
                v-if="options.length===0"
                disabled
            >
              - Няма създадени категории
            </b-form-select-option>
            <b-form-select-option
                value="null"
                v-else-if="options.length>0"
                disabled
            >
              -- Изберете категория --
            </b-form-select-option>
          </template>
        </b-form-select>
          <b-form-invalid-feedback id="category-live-feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
      </b-form-group>
      </validation-provider>

    </div>
    <category-input :value-select="valueSelect" :categories="categories"/>
  </b-form-row>
</template>

<script>
import categoryInput from "./CategoryInputComponent";
export default {
  name: "CategorySelect",
  data() {
    return {
      dismissCountDown: 0,
      dismissSecs: 5
    }
  },
  components: {
    categoryInput
  },
  props: ['value'],
  created() {
    const categories = this.$store.getters["CategoryModule/getCategories"]
    if(Array.isArray(categories)&&categories.length===0){
      this.$store.dispatch("CategoryModule/findCategories");
    }
  },
  computed: {
    valueSelect(){
      if(this.value!==null){
        if(typeof this.value==='object'&& this.value.hasOwnProperty('@id')){
          return this.value["@id"];
        }
      }
      return this.value;
    },
    categories() {
      return this.$store.getters["CategoryModule/getCategories"]["hydra:member"];
    },
    options(){
      let options = [];
      if(Array.isArray(this.categories)){
        this.categories.forEach(cat=>{
          options.push({text:cat.name,value:cat['@id']});
        })
      }
      return options;
    },
    isSuccess() {
      const success = this.$store.getters["CategoryModule/getIsSuccess"];
      if (success) this.showSuccessAlert();
      return success;
    },
    successMessage() {
      return this.$store.getters["CategoryModule/getMessage"];
    },
  },
  methods: {
    getValidationState({ dirty, validated, valid = null }) {
      return dirty || validated ? valid : null;
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
      if (dismissCountDown === 0) {
        this.$store.commit("CategoryModule/actionSuccessful");
      }
    },
    showSuccessAlert() {
      this.dismissCountDown = this.dismissSecs;
    }
  }
}
</script>

<style scoped>

</style>