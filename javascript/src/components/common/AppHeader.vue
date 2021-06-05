<template>
  <header class="flex bg-third p-4 items-end">
    <span class="text-primary text-3xl flex-grow">Catitionary</span>
    <div>
      <a id="account" @click="onIconClicked">
        <span class="text-white material-icons cursor-pointer"
          >account_circle</span
        >
      </a>
      <DropDown :show.sync="showPopup" target="#account">
        <template v-if="isGuest">
          <DropDownItem
            menu-id="login"
            title="ログイン"
            @click="onMenuClicked"
          />
          <DropDownItem
            menu-id="register"
            title="会員登録"
            @click="onMenuClicked"
          />
        </template>
        <template v-else>
          <DropDownItem
            menu-id="profile"
            title="プロフィール"
            @click="onMenuClicked"
          />
          <DropDownItem menu-id="setting" title="設定" @click="onMenuClicked" />
          <DropDownItemSeparator />
          <DropDownItem
            menu-id="logout"
            title="ログアウト"
            @click="onMenuClicked"
          />
        </template>
      </DropDown>
    </div>
  </header>
</template>

<script>
import { defineComponent, ref, inject } from '@vue/composition-api'
import { authHandlerKey } from '@/domain/user/authHandlerInterface'
import DropDown from '@/components/common/dropDown/DropDown'
import DropDownItem from '@/components/common/dropDown/DropDownItem'
import DropDownItemSeparator from '@/components/common/dropDown/DropDownItemSeparator'
import { useRouter } from '@/hooks/useRouter'
import { routes } from '@/router/routes'

export default defineComponent({
  components: {
    DropDown,
    DropDownItem,
    DropDownItemSeparator,
  },
  setup() {
    const authHandler = inject(authHandlerKey)
    const showPopup = ref(false)
    const isGuest = !authHandler.isLogined()
    const router = useRouter()

    const onIconClicked = () => {
      showPopup.value = !showPopup.value
    }
    const onMenuClicked = async (menuId) => {
      switch (menuId) {
        case 'login':
          router.push({ name: routes.login })
          break
        case 'register':
          router.push({ name: routes.authRegister })
          break
        case 'logout':
          break
      }
      showPopup.value = false
    }

    return {
      isGuest,
      showPopup,
      onIconClicked,
      onMenuClicked,
    }
  },
})
</script>

<style scoped></style>
