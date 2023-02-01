<template>
  <div class="file-select-wrapper">
    <Modal
      :show-modal="showModal"
      @close="$emit('close')"
    >
      <template #body>
        <div class="navigation">
          <ul>
            <li>
              <a href="#" class="btn btn-primary btn-sm">
                <b-icon-caret-left></b-icon-caret-left> Назад
              </a>
            </li>
            <li>
              <a href="#" ><b-icon-house></b-icon-house> /</a>
            </li>
            <li class="float-right">
              <a href="#" class="btn btn-primary btn-sm" @click.prevent="clickUploadInput">
                <b-icon-upload></b-icon-upload>
                Качи файл
              </a>
            </li>
            <li class="float-right" style="margin-right: 1rem;">
              <a
                  href="#"
                  class="btn btn-primary btn-sm"
                  @click.prevent="show_add_folder = !show_add_folder"
              >
                <b-icon-folder2></b-icon-folder2> Папка
              </a>
              <div class="add-folder" v-if="show_add_folder">
                <input type="text" placeholder="Name" v-model="new_folder"/>
                <button class="btn btn-primary btn-sm" >save</button>
              </div>
            </li>
          </ul>
        </div>
        <AlertManager :alert-message="alertMessage"></AlertManager>
        <div class="loading" v-if="isLoading">
          <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div class="images" v-else>
          <div class="image" v-for="(dir, i) in dirs" :key="`folder_${i}`">
            <a href="#" >
                    <span class="preview">
                      <i class="fa fa-folder-o"></i>
                    </span>
              <span class="name">{{ dir }}</span>
            </a>
          </div>
          <!-------- select image grid  ---------------->
          <div class="image" v-for="(file, i) in files" :key="`file_${i}`">
            <input
                type="radio"
                :id="`file_${i}`"
                :value="[file]"
                v-model="selected_files"
                style="display: none;"
            />
            <label :for="`file_${i}`">
              <figure class="preview">
                <img :src="require(`@images/${file.filePath}`)" :alt="file.filePath">
              </figure>
              <span class="name" :title="file.id">
                      <a  href="#" class="delete-image" @click="deleteImage(file['@id'])">
                        <b-icon-trash  variant="danger"></b-icon-trash>
                      </a>
                    </span>
            </label>
          </div>
        </div>
      </template>
      <template #footer>
        <b-button
            variant="info"
            size="sm"
            @click.prevent="$emit('close')">
          <b-icon-x-circle></b-icon-x-circle> Затвори
        </b-button>
        <slot name="checkButton">
          <b-button
              variant="success"
              size="sm"
              :disabled="selected_files.length===0"
              @click.prevent="$emit('selected', selected_files)"
          >
            <b-icon-check2></b-icon-check2> Избор
          </b-button>
        </slot>
      </template>
    </Modal>

    <input
        type="file"
        style="display: none"
        ref="upload_files"
        @input="uploadFiles"
        id="file_uploads_selector"
    />
    <b-button block variant="primary" @click.prevent="clickUploadInput">
      <b-icon-upload></b-icon-upload>Качи файл
    </b-button>
  </div>
</template>

<script>
import Modal from "@vue/components/ModalComponent";
import AlertManager from "@vue/components/common-component/AlertManagerComponent";
export default {
  name:"FileSelect",
  components:{ Modal, AlertManager },
  mounted() {
    if (this.$store.getters["ImageModule/getImages"].length < 1) {
      this.$store.dispatch("ImageModule/findAllImages");
    }
  },
  data() {
    return {
      dirs: [],
      dir: '',
      selected_files: [],
      show_add_folder: false,
      new_folder: '',
    };
  },
  props: {
    alertMessage:{
      type:Object
    },
    clearSelectedFile:{
      type: Array,
      default(){
        return [];
      }
    },
    showModal: {
      type: Boolean,
      default() {
        return true;
      },
    },
    multiple: {
      type: Boolean,
      default() {
        return false;
      },
    },
    server: {
      type: Object,
      default() {
        return {home: '', add_folder: '', file_uploads: ''};
      },
    },
  },
  computed: {
    breadcrumbs() {
      return this.dir.split('/').filter(crumb => {
        return crumb !== '';
      });
    },
    files() {
      return this.$store.getters["ImageModule/getImages"];
    },
    isLoading() {
      return this.$store.getters["ImageModule/getIsLoading"];
    },
  },

  methods: {
    clickUploadInput() {
      this.$refs.upload_files.click()
    },

    async uploadFiles() {
      try{
        let formData = new FormData();
        let data = this.$refs.upload_files.files[0];
        formData.append('fileImage', data);
        let result = await this.$store.dispatch("ImageModule/uploadImage", formData);
        this.selected_files.push(result)
        this.$emit('selected',this.selected_files);
      }catch (e) {
        console.log(e)
      }
    },

    async deleteImage(imageIri){
      const result = await this.$store.dispatch("ImageModule/delete",imageIri)
    }
    /*
    fetchDir(dir) {
      this.dir += dir + '/';
      this.fetch();
    },

    goBack() {
      let deep = this.dir.split('/');
      this.dir = deep.splice(deep.length - 1, 1).join('/');
      this.fetch();
    },

    addFolder() {
      let data = {
        path: this.dir,
        name: this.new_folder,
      };

      axios.post(this.server.add_folder, data).then(response => {
        this.show_add_folder = false;
        this.dirs.push(this.new_folder);
        this.new_folder = '';
      });
    },
     */
  },
  watch: {
    clearSelectedFile(newval,oldval){
      if(newval){
        this.selected_files = [];
      }
    },
  },
};
</script>

<style lang="css" scoped>

#file-select label{
  padding: 5px;
}

.name{
  background-color: rgba(239, 239, 239, 1);
}

img {
  max-width: 100%;
  height: auto;
}

figure {
  width: 120px;
  height: 120px;
  height: auto;
  float: left;
  margin: 3px;
  padding: 3px;
}
</style>