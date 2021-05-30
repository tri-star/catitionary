<template>
  <div class="flex flex-col sm:flex-row">
    <div :class="['w-full', `sm:${labelWidth}`]">
      <slot name="label">
        <p>{{ label }}</p>
      </slot>
    </div>
    <div>
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
