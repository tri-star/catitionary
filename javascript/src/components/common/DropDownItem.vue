<template>
  <li class="hover:bg-blue-100 cursor-pointer" role="menuitem">
    <a
      class="px-4 py-1 block box-border text-left"
      style="width: 120px"
      @click="onClicked"
      >{{ title }}</a
    >
  </li>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    menuId: {
      type: String,
      default: '',
    },
    title: {
      type: String,
      required: true,
    },
  },
  emits: ['click'],
  setup(props, context) {
    const onClicked = () => {
      context.emit('click', props.menuId)
    }

    return {
      onClicked,
    }
  },
})
</script>
