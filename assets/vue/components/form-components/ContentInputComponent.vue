<template>
  <validation-provider
      :name="'Текст на събитието'"
      :rules="{ required: true, min: 30 }"
      v-slot="validationContext"
  >
    <b-form-group
        :label="'Текст на събитието:'"
        label-for="_content"
    >
      <b-form-invalid-feedback
          :class="display"
          id="content-live-feedback"
      >
        {{ validationContext.errors[0] }}
      </b-form-invalid-feedback>
      <vue-editor
          :style="style"
          id="_content"
          name="content"
          :editorOptions="editorSettings"
          v-bind:value="value"
          v-on:input="$emit('input', $event)"
          :state="getValidationState(validationContext)"
          class="bg-white"
          :placeholder=placeholder
          aria-describedby="content-live-feedback"
      >
      </vue-editor>
    </b-form-group>
  </validation-provider>
</template>

<script>
import {VueEditor,Quill} from "vue2-editor";
import {ImageDrop} from "quill-image-drop-module";
import ImageResize from "quill-image-resize-module";

Quill.register('modules/imageDrop', ImageDrop);
Quill.register('modules/imageResize', ImageResize);

export default {
  name: "ContentInputComponent",
  data() {
    return {
      editorSettings: {
        modules: {
          imageDrop: true,
          imageResize: {}
        }
      },
      style:"",
      display:"d-none"
    }
  },
  props: ["value","placeholder"],
  components: {
    VueEditor,Quill
  },
  methods: {
    getValidationState({dirty, validated, valid = null}) {
      if ((dirty || validated) && !valid) {
        this.style = "border: 2px solid #dc3545;border-radius: 0.25rem;transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"
        this.display = "d-block";
      } else this.style = ""
      return dirty || validated ? valid : null;
    },
  }
}
</script>

<style scoped>
#content-live-feedback{
  padding-bottom: 4px;
}
.quillWrapper{
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
  transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
</style>