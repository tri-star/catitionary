<template>
  <header class="flex bg-third p-4 items-end">
    <span class="text-primary text-3xl flex-grow">Catitionary</span>
    <div>
      <a id="account" @click="onIconClicked">
        <span class="text-white material-icons cursor-pointer"
          >account_circle</span
        >
      </a>
    </div>
    <SideMenu :show="state.showSubMenu">
      <SideMenuItem
        v-for="sideMenu in sideMenues"
        :key="sideMenu.id"
        :id="sideMenu.id"
        :title="sideMenu.title"
        @click="sideMenu.click"
        class="my-1"
      />
    </SideMenu>
  </header>
</template>

<script>
import { defineComponent, reactive, inject } from '@vue/composition-api'
import { authHandlerKey } from '@/domain/user/authHandlerInterface'
import { useRouter } from '@/hooks/useRouter'
import SideMenu from './sideMenu/SideMenu'
import SideMenuItem from './sideMenu/SideMenuItem'
import { sideMenuDefinitions } from './sideMenu/sideMenuDefinitions'

export default defineComponent({
  components: {
    SideMenu,
    SideMenuItem,
  },
  setup() {
    const authHandler = inject(authHandlerKey)
    const isGuest = !authHandler.isLogined()
    const router = useRouter()

    const state = reactive({
      showSubMenu: false,
    })
    const sideMenues = sideMenuDefinitions(state, router)

    const onIconClicked = () => {
      state.showSubMenu = !state.showSubMenu
    }

    return {
      state,
      isGuest,
      onIconClicked,
      sideMenues,
    }
  },
})
</script>

<style scoped></style>
