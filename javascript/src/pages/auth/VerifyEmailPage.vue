<template>
  <DefaultLayout>
    <CardItem v-if="state.state == 'default'">
      <p>ご登録ありがとうございます。</p>
      <p>
        入力いただいたメールアドレス宛に確認メールを送信させていただきました。
      </p>
      <p>
        メールに記載されているURLにアクセスし、会員登録を完了させてください。
      </p>
      <p>(メールの到着にはしばらく時間がかかることがあります)</p>
    </CardItem>
    <CardItem v-else-if="state.state == 'loading'">
      <p>処理中...</p>
    </CardItem>
    <CardItem v-else-if="state.state == 'complete'">
      <p>メールアドレスの確認が完了しました。</p>
      <p>ご登録ありがとうございました。</p>
    </CardItem>
    <CardItem v-else-if="state.state == 'failed'">
      <p>確認コードの検証に失敗しました。</p>
      <p>お手数ですが、再度会員登録の手続きをお願いいたします。</p>
    </CardItem>
    <CardItem v-else-if="state.state == 'server-error'">
      <p>システム側の事情によりリクエストを処理することが出来ませんでした。</p>
      <p>お手数ですが、時間を空けて再度アクセスお願いいたします。</p>
    </CardItem>
  </DefaultLayout>
</template>

<script>
import { defineComponent, inject } from '@vue/composition-api'
import CardItem from '@/components/common/CardItem.vue'
import { useRouter } from '@/hooks/useRouter'
import { VerifyEmailPageStore } from './VerifyEmailPageStore'
import { userRepositoryKey } from '@/domain/user/userRepositoryInterface'

export default defineComponent({
  components: {
    CardItem,
  },
  setup() {
    const router = useRouter()
    const userRepository = inject(userRepositoryKey)
    const store = new VerifyEmailPageStore(userRepository)

    const code = router.currentRoute.query.code
    if (code) {
      store.verify(code)
    }

    return {
      state: store.state,
      query: router.currentRoute.query,
    }
  },
})
</script>
