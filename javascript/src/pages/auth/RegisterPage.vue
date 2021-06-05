<template>
  <DefaultLayout>
    <AlertBox
      :visible="state.showUserRegisteredMessage"
      message="ユーザーを登録しました。"
    ></AlertBox>
    <FormRowList class="items-center justify-center mx-auto lg:w-1/2">
      <LabeledFormRow label="メールアドレス" label-width="w-36">
        <template slot="form">
          <TextInput
            v-model="state.form.email"
            :isError="'email' in state.errors"
          />
          <template v-if="'email' in state.errors">
            <FormError v-for="(message, i) in state.errors.email" :key="i">
              {{ message }}
            </FormError>
          </template>
        </template>
      </LabeledFormRow>
      <LabeledFormRow label="ログインID" label-width="w-36">
        <template slot="form">
          <TextInput
            v-model="state.form.loginId"
            :isError="'loginId' in state.errors"
          />
          <template v-if="'loginId' in state.errors">
            <FormError v-for="(message, i) in state.errors.loginId" :key="i">
              {{ message }}
            </FormError>
          </template>
        </template>
      </LabeledFormRow>
      <LabeledFormRow label="パスワード" label-width="w-36">
        <template slot="form">
          <TextInput
            v-model="state.form.password"
            :type="'password'"
            :isError="'password' in state.errors"
          />
          <template v-if="'password' in state.errors">
            <FormError v-for="(message, i) in state.errors.password" :key="i">
              {{ message }}
            </FormError>
          </template>
        </template>
      </LabeledFormRow>
      <LabeledFormRow label="確認用パスワード" label-width="w-36">
        <template slot="form">
          <TextInput
            v-model="state.form.confirmPassword"
            :type="'password'"
            :isError="'confirmPassword' in state.errors"
          />
          <template v-if="'confirmPassword' in state.errors">
            <FormError
              v-for="(message, i) in state.errors.confirmPassword"
              :key="i"
            >
              {{ message }}
            </FormError>
          </template>
        </template>
      </LabeledFormRow>
      <FormRow>
        <SimpleButton
          :title="'登録'"
          class="mr-3"
          :disabled="isError"
          @onclick="onRegisterClicked"
        />
      </FormRow>
    </FormRowList>
  </DefaultLayout>
</template>

<script>
import { defineComponent, computed, inject, watch } from '@vue/composition-api'
import AlertBox from '@/components/common/alert/AlertBox'
import DefaultLayout from '@/layouts/DefaultLayout'
import FormError from '@/components/common/form/FormError'
import FormRow from '@/components/common/form/FormRow'
import FormRowList from '@/components/common/form/FormRowList'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import SimpleButton from '@/components/common/button/SimpleButton'
import TextInput from '@/components/common/TextInput'
import { userRepositoryKey } from '@/domain/user/userRepositoryInterface'
import { RegisterPageStore } from './RegisterPageStore'

export default defineComponent({
  components: {
    AlertBox,
    DefaultLayout,
    FormError,
    FormRow,
    FormRowList,
    LabeledFormRow,
    SimpleButton,
    TextInput,
  },
  setup() {
    const userRepository = inject(userRepositoryKey)
    const registerFormStore = new RegisterPageStore(userRepository)
    registerFormStore.initialize()

    const state = registerFormStore.state

    watch(state.form, async () => {
      await registerFormStore.validate()
    })

    const isError = computed(() => {
      return state.errors && Object.keys(state.errors).length > 0
    })

    const onRegisterClicked = async () => {
      await registerFormStore.register()
    }

    return {
      state,
      isError,
      onRegisterClicked,
    }
  },
})
</script>
