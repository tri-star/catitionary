<template>
  <DefaultLayout>
    <CardItem>
      <p>ご登録ありがとうございます。</p>
      <p>
        入力いただいたメールアドレス宛に確認メールを送信させていただきました。
      </p>
      <p>
        メールに記載されているURLにアクセスし、会員登録を完了させてください。
      </p>
      <p>(メールの到着にはしばらく時間がかかることがあります)</p>
    </CardItem>
  </DefaultLayout>
</template>

<script>
import { defineComponent } from '@vue/composition-api'
import DefaultLayout from '@/layouts/DefaultLayout'
import CardItem from '@/components/common/CardItem.vue'

export default defineComponent({
  components: {
    DefaultLayout,
    CardItem,
  },
  setup() {},
})
</script>
