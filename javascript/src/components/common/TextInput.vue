<template>
  <input
    :type="type"
    class="border border-gray-500 p-1"
    :value="value"
    @input="$emit('input', $event.target.value)"
  />
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    value: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: 'text',
    },
  },
  setup() {
    return {}
  },
})
</script>
