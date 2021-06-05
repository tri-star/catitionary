<template>
  <div>
    <transition name="float-alert">
      <div
        v-if="visible"
        class="float-alert bg-green-300 p-3 my-3 rounded-md w-full"
      >
        {{ message }}
      </div>
    </transition>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    message: {
      type: String,
      required: true,
    },
    visible: {
      type: Boolean,
      required: true,
    },
  },
})
</script>

<style scoped>
.float-alert-enter-active,
.float-alert-leave-active {
  transition: all 0.5s ease;
}

.float-alert-enter-from,
.float-alert-leave-to {
  opacity: 0;
  height: 0;
}

.float-alert {
  height: 50px;
  @apply text-green-900;
}
</style>
