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
import AppHeader from '@/components/common/AppHeader'

export default {
  components: {
    AppHeader,
  },

  setup() {
    return {}
  },
}
</script>
