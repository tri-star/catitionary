<template>
  <div class="flex flex-col sm:flex-row w-full">
    <div :class="['w-full', `sm:${labelWidth}`, 'self-center']">
      <slot name="label">
        <p>{{ label }}</p>
      </slot>
    </div>
    <div class="w-full">
      <slot name="form" />
    </div>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    label: {
      type: String,
      default: '',
    },
    labelWidth: {
      type: String,
      default: 'w-auto',
    },
  },
  setup() {
    return {}
  },
})
</script>
