<template>
  <div>
    <div class="mask" v-if="show">
      <div class="container">
        <div class="indicator">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </div>
    </div>
  </div>
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
  setup() {
    return {}
  },
})
</script>

<style scoped>
.mask {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.5);
  animation: 0.5s show;
  z-index: 999;
}

.container {
  margin: auto;
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.indicator {
  display: block;
}

span {
  display: inline-block;
  width: 10px;
  height: 10px;
  margin: 5px;
  background: #cacaca;
  border-radius: 50%;
  animation: 1.2s load infinite;
}

span:nth-child(1) {
  animation-delay: 0.1s;
}
span:nth-child(2) {
  animation-delay: 0.2s;
}
span:nth-child(3) {
  animation-delay: 0.3s;
}
span:nth-child(4) {
  animation-delay: 0.4s;
}
span:nth-child(5) {
  animation-delay: 0.5s;
}

@keyframes show {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

@keyframes load {
  0% {
    opacity: 0;
    transform: scale(0);
  }
  70% {
    opacity: 0.7;
    transform: scale(0.7) translateY(-10px);
  }
  100% {
    opacity: 1;
    transform: scale(1) translateY(0px);
  }
}
</style>
