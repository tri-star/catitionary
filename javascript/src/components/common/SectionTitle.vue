<template>
  <div class="px-2 py-4 text-2xl text-third-500 bg-primary-100 rounded-2xl">
    <div>{{ title }}</div>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    title: {
      type: String,
      required: true,
    },
  },
  setup() {
    return {}
  },
})
</script>
