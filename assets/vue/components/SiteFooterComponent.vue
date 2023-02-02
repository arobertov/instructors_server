<template>
  <footer>
    <b-row>
      <b-col class="footer-content"></b-col>
      <b-col class="footer-content"></b-col>
      <b-col class="footer-content"></b-col>
    </b-row>
  </footer>
</template>

<script>
export default {
  name: "SiteFooterComponent"
}
</script>

<style scoped>
  footer{
    background-color: #211e1e;
  }
  .footer-content{
    background-color: white;
    margin: 1rem;
    padding: 0.5rem 2rem;
  }
</style>