<template>
  <form @submit.prevent="submit">
    <file-input
        v-model="images"
        :server="server"
    />
  </form>
</template>

<script>
import FileInput from "@vue/components/vue-image-manager/FileInputComponent";

export default {
  name: "ImageManager",
  components:{
    FileInput
  },
  data() {
    return {
      server: {
        home: 'https://localhost:8080',
        add_folder: '/api/public/files',
        file_uploads: '/api/images'
      }
    }
  },
  computed:{
    images:{
      get:function (){
        return this.$store.getters["EventModule/getImages"];
      },
      set:function (images){
        this.$store.commit("EventModule/attachImages",images);
      }
    }
  },
}
</script>

<style scoped>

</style>