<template>
  <span v-html="limitedContent"></span>
</template>

<script>
export default {
  name: "Elipsis",
  props: ['content','wordLength'],
  computed:{
    limitedContent(){
      let inputContent = this.content
      if(inputContent.length > this.wordLength){
        return inputContent.slice(0,this.wordLength) + "......";
      }
        return inputContent
    }
  }
}
</script>

<style scoped>

</style>