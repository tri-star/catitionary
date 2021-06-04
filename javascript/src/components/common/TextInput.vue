<template>
  <input
    :type="type"
    :class="[
      'border',
      'border-gray-500',
      'p-1',
      'w-full',
      isError ? 'text-red-900 border-red-800 bg-red-100' : '',
    ]"
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
    isError: {
      type: Boolean,
      default: false,
    },
  },
  setup() {
    return {}
  },
})
</script>
