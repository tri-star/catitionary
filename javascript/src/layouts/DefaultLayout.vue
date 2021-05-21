<template>
  <div>
    <div class="container mx-auto">
      <AppHeader />
    </div>
    <main class="container mx-auto">
      <slot />
    </main>
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

import AppHeader from '@/components/common/AppHeader'

export default defineComponent({
  components: {
    AppHeader,
  },

  setup() {
    return {}
  },
})
</script>
