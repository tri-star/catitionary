<template>
  <div
    class="container bg-primary-100 hover:bg-primary-200 rounded-md p-2 w-24"
  >
    <p class="name">{{ name }}</p>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    name: {
      type: String,
      required: true,
    },
  },
  setup() {
    return {}
  },
})
</script>

<style scoped>
.container {
  animation: 0.5s setup;
  cursor: pointer;
}

.container:hover {
  translate: 0.5s background-color;
}

@keyframes setup {
  0% {
    opacity: 0;
    transform: translateX(50px);
  }
  100% {
    opacity: 1;
    transform: translateX(0);
  }
}
</style>
