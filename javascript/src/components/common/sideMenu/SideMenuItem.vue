<template>
  <div>
    <div
      class="p-3 bg-third-500 text-secondary-300"
      @click="handleClick"
      data-test="menu-item"
    >
      {{ title }}
    </div>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    id: {
      type: String,
      required: true,
    },
    title: {
      type: String,
      required: true,
    },
  },
  setup(props, context) {
    const handleClick = () => {
      context.emit('click', props.id)
    }

    return {
      handleClick,
    }
  },
})
</script>
