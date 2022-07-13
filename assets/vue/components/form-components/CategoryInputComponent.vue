<template>
  <b-col lg="6" align-self="end" class="mb-3">
    <b-button
        id="edit-category-btn"
        :disabled="btnStatus"
        v-b-modal.category-modal variant="info"
        @click="setEditModal"
    >
      <b-icon icon="pencil-square"></b-icon>
      Редактирай
    </b-button>
    <b-button
        id="delete-category-btn"
        variant="danger"
        :disabled="btnStatus"
        @click="deleteMsgBox"
    >
      <b-icon icon="trash"></b-icon>
      Изтрий
    </b-button>
    <b-button
        v-b-modal.category-modal variant="info"
        @click="setCreateModal"
    >
      <b-icon icon="plus-square" aria-hidden="true"></b-icon>
      Добави категория
    </b-button>
    <b-modal
        id="category-modal"
        ref="modal"
        :title="modalTitle"
    >
      <template #default >
        <div class="alerts">
          <b-alert class="small"
                   :show="isError"
                   variant="danger"
          >
            {{ error }}
          </b-alert>
        </div>
        <validation-observer ref="observer" v-slot="{ handleSubmit }">
          <b-form  ref="form" @submit.stop.prevent="handleSubmit(onSubmit)">
            <validation-provider
                name="Име на категория"
                :rules="{ required: true, min: 3,max: 40 }"
                v-slot="validationContext"
            >
              <b-form-group
                  label="Име на категория :"
                  label-for="category-input"
                  :invalid-feedback="validationContext.errors[0] "
                  :state="categoryState"
              >
                <b-form-input
                    id="category-input"
                    name="category-input"
                    v-model="categoryName"
                    :state="getValidationState(validationContext)"
                    aria-describedby="category-live-feedback"
                ></b-form-input>
              </b-form-group>
            </validation-provider>
          </b-form>
        </validation-observer>
      </template>
      <template #modal-footer="{ ok, cancel, hide }">
        <b-button variant="info" @click="cancel()">
          <b-icon icon="x-circle"></b-icon>
          Затвори
        </b-button>
        <b-button type="submit" variant="success" @click="onSubmit">
          <b-icon icon="plus-circle"></b-icon>
          <b v-if="modalType==='CREATE'">Добави</b>
          <b v-if="modalType==='EDIT'">Редактирай</b>
        </b-button>
      </template>
    </b-modal>
  </b-col>
</template>

<script>

export default {
  name: "CategoryInput",
  data() {
    return {
      categoryName: '',
      categoryState: null,
      submittedCategories: [],
      modalTitle:'Създай категория!',
      modalType:'CREATE'
    }
  },
  props: ['valueSelect', 'categories'],
  computed: {
    isError:{
      get(){
        return this.$store.getters["CategoryModule/hasError"];
      },
      set(value){
        this.$store.commit("CategoryModule/hasError",value);
      }
    },
    error:{
      get(){
        return this.$store.getters["CategoryModule/getError"];
      },
      set(value){
        this.$store.commit("CategoryModule/setError",value);
      }
    },
    btnStatus() {
      return this.valueSelect === null;
    }
  },
  methods: {
    deleteMsgBox(){
      this.$bvModal.msgBoxConfirm('Потвърдете че желаете да изтриете категорията '+this.categoryName+' !', {
        title: 'МОЛЯ ПОТВЪРДЕТЕ',
        okVariant: 'danger',
        okTitle: 'ДА',
        cancelTitle: 'НЕ',
        footerClass: 'p-2',
        hideHeaderClose: false,
        centered: true
      })
          .then(value => {
              this.deleteCategory();
          })
          .catch(err => {
            console.log(err)
          })
    },
    async handleCategory(){
      const store = this.$store;let result
      if(this.modalType==='CREATE'){
        result = await this.createCategory();
      }
      if(this.modalType==='EDIT'){
        result = await this.editCategory();
      }
      if (result !== null && !this.isError) {
        await  store.dispatch("CategoryModule/findCategories");
        store.state.EventModule.event.category = result['@id'];
        this.$nextTick(() => {
          this.$bvModal.hide('category-modal')
        })
      }
    },
    async createCategory() {
      return  await this.$store.dispatch("CategoryModule/createCategory", this.categoryName);
    },
    async editCategory(){
      const category = {
        name : this.categoryName,
        url : this.valueSelect
      };
      return await this.$store.dispatch("CategoryModule/editCategory", category)
    },
    async deleteCategory() {
      let result = await this.$store.dispatch("CategoryModule/deleteCategory", this.valueSelect);
      if (result === 204) {
        this.$store.state.EventModule.event.category = '';
        await this.$store.dispatch("CategoryModule/findCategories");
      }
    },
    resetModal() {
      this.categoryName = ''
      this.categoryState = null;
      this.isError =false;
      this.error = '';
    },
    setEditModal(){
      this.setCategoryName(this.valueSelect);
      this.modalTitle='Редактирай категория!';
      this.modalType='EDIT';
    },
    setCreateModal(){
      this.resetModal();
      this.modalTitle='Създай категория!!';
      this.modalType='CREATE';
    },
    setCategoryName(valueSelect){
      if (Array.isArray(this.categories) && this.categories.length > 0) {
        this.categoryName = this.categories.filter(cat => cat['@id'] === valueSelect)[0].name;
      }
    },
    onSubmit() {
      this.$refs.observer.validate().then(success => {
        if (success) {
          this.submittedCategories.push(this.categoryName);
          this.handleCategory();
        }
      })
    },
    getValidationState({dirty, validated, valid = null}) {
      return dirty || validated ? valid : null;
    },
  }
}
</script>

<style scoped>

</style>