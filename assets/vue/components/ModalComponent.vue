<template>
  <div class="my-modal" id="file-select">
    <transition name="modal" v-if="showModal">
      <div class="modal-mask">
        <div class="modal-wrapper" @click="close">
          <div class="modal-container">
            <a href="#" class="modal-close" @click.prevent="$emit('close')">
              <b-icon-x></b-icon-x>
            </a>
            <div class="modal-header">
              <slot name="header"></slot>
            </div>
            <div class="modal-body">
              <slot name="body"></slot>
            </div>
            <div class="modal-footer">
              <slot name="footer"></slot>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  name: "ModalComponent",
  props: {
    showModal: {
      type: Boolean,
      default() {
        return true;
      },
    },
  },
  methods:{
    close(e) {
      if (e.target.className === 'modal-wrapper') {
        this.$emit('close');
      }
    },
  }
}
</script>

<style scoped>

</style>