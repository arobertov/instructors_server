<template>
  <b-navbar toggleable="md" type="dark" variant="green" sticky>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item :to="{ name: 'site_index'}">Начало</b-nav-item>
        <b-nav-item-dropdown v-if="isLogin" text="Събития" right >
          <b-dropdown-item :to="{name:'site_events'}">Прегледай</b-dropdown-item>
          <b-dropdown-item :to="{name:'site_events_create'}">Публикувай</b-dropdown-item>
        </b-nav-item-dropdown>
        <b-nav-item :to="{name:'categories_list'}">Категории</b-nav-item>
        <b-nav-item v-if="isLogin" :to="{name:'hmi_messages'}">Съобщения HMI</b-nav-item>
        <b-nav-item>Контакти</b-nav-item>
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item v-if="!isLogin">
          <b-button
              variant="success"
              data-toggle="modal"
              data-target="#loginModal"
          >
             Вход <b-icon class="ml-4" icon="box-arrow-in-right"></b-icon>
          </b-button>
        </b-nav-item>
        <b-nav-item v-if="!isLogin">
          <b-button
              variant="success"
              data-toggle="modal"
              data-target="#registerModal"
          >
            Регистрация <b-icon class="ml-2" icon="person-plus-fill"></b-icon>
          </b-button>
        </b-nav-item>
        <b-nav-item-dropdown right v-if="isLogin">
          <!-- Using 'button-content' slot -->
          <template #button-content>
            <em> {{ user.alias }}</em>
          </template>
          <div v-if="isLogin">
            <b-dropdown-item href="/admin/">Контролен панел</b-dropdown-item>
            <b-dropdown-item href="/logout">Изход<b-icon class="ml-4" icon="box-arrow-right"></b-icon> </b-dropdown-item>
          </div>
        </b-nav-item-dropdown>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  name: "NavbarTopMenu",
  props:['user'],
  computed: {
    isLogin() {
      return this.$store.getters["UserModule/getIsLogin"];
    },
  }
}
</script>

<style scoped>
  nav.navbar{
    background-color: rgba(98, 96, 96, 0.8);
  }
</style>