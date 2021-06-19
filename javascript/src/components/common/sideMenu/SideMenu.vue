<template>
  <transition name="sidemenu">
    <div
      class="absolute top-0 right-0 z-40 w-56 h-full bg-third-600 flex flex-col"
      ref="container"
      v-if="show"
    >
      <slot />
    </div>
  </transition>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    show: {
      type: Boolean,
      default: false,
    },
  },
  setup(props) {
    return {}
  },
})
</script>

<style scoped>
.sidemenu-enter-active,
.sidemenu-leave-active {
  transition: all 0.3s ease-in-out;
  overflow: hidden;
}

.sidemenu-enter,
.sidemenu-leave-to {
  width: 0;
}
</style>
