<template>
  <div :class="['checkbox', innerChecked ? 'checked' : 'unchecked']">
    <label class="mx-1">
      <input type="checkbox" v-model="innerChecked" />
      <span>{{ label }}</span>
    </label>
  </div>
</template>

<script>
import { defineComponent, ref, watch } from '@vue/composition-api'

export default defineComponent({
  props: {
    id: {
      type: String,
      required: true,
    },
    label: {
      type: String,
      required: true,
    },
    checked: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, context) {
    const innerChecked = ref(props.checked)

    watch(innerChecked, () => {
      context.emit('check', {
        id: props.id,
        checked: innerChecked.value,
      })
    })

    return {
      innerChecked,
    }
  },
})
</script>

<style scoped>
.checkbox {
  @apply py-1 px-2 inline-block;
  @apply rounded-md;
  @apply bg-primary-100 text-primary-900;
  @apply cursor-pointer;
}

input[type='checkbox'] {
  width: 20px;
  height: 20px;
}

label {
  cursor: pointer;
}

input[type='checkbox'] {
  position: absolute;
  left: -9999em;
}

.checkbox.checked {
  animation: check 0.15s linear;
  @apply bg-primary-200;
}
.checkbox.unchecked {
  animation: uncheck 0.15s linear;
}

.checkbox span {
  display: inline-block;
  position: relative;
  padding-left: 1.4rem;
  user-select: none;
}

.checkbox span::before {
  position: absolute;
  top: 50%;
  left: 0;
  width: 1em;
  height: 1em;
  content: '';
  @apply border border-secondary rounded-md;
  @apply bg-white text-primary-900;
  @apply shadow-inner;
  transform: translateY(-50%);
}

.checkbox span::after {
  position: absolute;
  top: 0em;
  left: 0.35em;
  width: 0.6em;
  height: 1em;
  @apply border-r-4;
  @apply border-b-4 border-accent-600;
  transform: rotate(40deg);
}

.checkbox input:focus + span::before {
  @apply border-secondary-300;
  @apply shadow-none;
}

.checkbox input:focus + span {
  @apply text-primary-700;
}

.checkbox input:checked + span::after {
  content: '';
}

@keyframes check {
  0% {
    transform: translateY(2px);
    background-color: theme('colors.primary.100');
  }

  50% {
    transform: translateY(4px) scale(0.95);
  }

  75% {
    transform: translateY(1.5px) scale(1);
  }

  100% {
    transform: translateY(0px);
    background-color: theme('colors.primary.200');
  }
}

@keyframes uncheck {
  0% {
    transform: translateY(2px);
    background-color: theme('colors.primary.200');
  }

  50% {
    transform: translateY(4px) scale(0.95);
  }

  75% {
    transform: translateY(1.5px) scale(1);
  }

  100% {
    transform: translateY(0px);
    background-color: theme('colors.primary.100');
  }
}
</style>
