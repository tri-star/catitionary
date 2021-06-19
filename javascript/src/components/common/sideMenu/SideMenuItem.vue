<template>
  <div>
    <div class="p-3 bg-third-500 text-secondary-300" @click="onClick">
      {{ title }}
    </div>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'
import { useRouter } from '@/hooks/useRouter'

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
    to: {
      type: Object,
      required: false,
    },
  },
  setup(props, context) {
    const router = useRouter()

    const onClick = () => {
      if (props.to) {
        router.push(props.to)
        return
      }
      context.emit('click', props.id)
    }

    return {
      onClick,
    }
  },
})
</script>
