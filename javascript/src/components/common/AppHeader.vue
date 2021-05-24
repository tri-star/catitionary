<template>
  <header class="flex bg-third p-4">
    <span class="text-primary text-3xl">Catitionary</span>
    <div class="items-end flex-grow text-right">
      <a id="account" @click="onIconClicked">
        <span class="text-white material-icons cursor-pointer"
          >account_circle</span
        >
      </a>
      <DropDown :show.sync="showPopup" target="#account">
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
      </DropDown>
    </div>
  </header>
</template>

<script>
import { defineComponent, ref } from '@vue/composition-api'
import DropDown from '@/components/common/dropDown/DropDown'
import DropDownItem from '@/components/common/dropDown/DropDownItem'
import DropDownItemSeparator from '@/components/common/dropDown/DropDownItemSeparator'

export default defineComponent({
  components: {
    DropDown,
    DropDownItem,
    DropDownItemSeparator,
  },
  setup() {
    const showPopup = ref(false)

    const onIconClicked = () => {
      showPopup.value = !showPopup.value
    }
    const onMenuClicked = async (menuId) => {
      switch (menuId) {
        case 'logout':
          break
      }
      showPopup.value = false
    }

    return {
      showPopup,
      onIconClicked,
      onMenuClicked,
    }
  },
})
</script>

<style scoped></style>
