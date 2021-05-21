<template>
  <div>
    <transition name="popup">
      <div
        v-if="show"
        ref="container"
        class="absolute z-50 shadow-md bg-white border-gray-500 rounded-md py-2"
      >
        <ul>
          <slot><li>MENU</li></slot>
        </ul>
      </div>
    </transition>
    <div
      v-if="show"
      class="absolute z-40 w-full h-full left-0 top-0"
      @mousedown="onMaskMouseDown"
    ></div>
  </div>
</template>

<script>
import { ref, watch } from '@vue/composition-api'

export default {
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    target: {
      type: String,
      default: null,
    },
  },
  emits: ['update:show'],
  setup(props, context) {
    const container = ref(document.createElement('div'))

    watch(
      () => props.show,
      () => {
        setTimeout(() => {
          if (!props.show || !container.value) {
            return
          }
          if (!props.target) {
            return
          }
          const targetElement = document.querySelector(props.target)
          if (!targetElement) {
            return
          }
          const targetRect = targetElement.getBoundingClientRect()
          const containerRect = container.value.getBoundingClientRect()
          const screenW = document.body.clientWidth
          const targetLeft = Math.min(
            targetRect.x,
            screenW - containerRect.width - 10
          )

          container.value.style.left = container.value.style.left =
            String(targetLeft) + 'px'
        })
      }
    )

    const onMaskMouseDown = () => {
      context.emit('update:show', !props.show)
    }

    return {
      container,
      onMaskMouseDown,
    }
  },
}
</script>

<style scoped>
.popup-enter-active,
.popup-leave-active {
  transition: all 0.5s ease-out;
  overflow: hidden;
}

.popup-enter-from,
.popup-leave-to {
  opacity: 0;
  height: 0;
}
</style>
