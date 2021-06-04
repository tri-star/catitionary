<template>
  <div class="mx-auto h-full bg-gradient-to-br from-gray-100 to-blue-200">
    <div class="flex flex-col items-center">
      <div class="container w-11/12 pt-3">
        <div class="w-6/12 mx-auto my-20">
          <h1 class="text-6xl w-full text-center mb-10">Catitionary</h1>
          <FormRowList class="items-center mx-auto lg:w-1/2">
            <LabeledFormRow label="ログインID" label-width="w-28">
              <template slot="form">
                <TextInput v-model="state.form.loginId" class="w-full" />
              </template>
            </LabeledFormRow>
            <LabeledFormRow label="パスワード" label-width="w-28">
              <template slot="form">
                <TextInput
                  v-model="state.form.password"
                  :type="'password'"
                  class="w-full"
                />
              </template>
            </LabeledFormRow>
            <FormRow>
              <SimpleButton
                :title="'ログイン'"
                class="mr-3"
                :disabled="state.isError"
                @onclick="onLoginClicked"
              />
            </FormRow>
          </FormRowList>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useValidator } from '@/hooks/useValidator'
import { constraints } from '@/lib/validator/constraints'
import { RuleCollection } from '@/lib/validator/Rule'
import { defineComponent, inject, reactive, watch } from '@vue/composition-api'
import FormRowList from '@/components/common/form/FormRowList'
import FormRow from '@/components/common/form/FormRow'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import SimpleButton from '@/components/common/button/SimpleButton'
import TextInput from '@/components/common/TextInput'
import { useRouter } from '@/hooks/useRouter'

export default defineComponent({
  components: {
    FormRow,
    FormRowList,
    LabeledFormRow,
    SimpleButton,
    TextInput,
  },
  setup() {
    const state = reactive({
      form: {
        loginId: '',
        password: '',
      },
      isError: false,
    })

    const authHandler = inject('AuthHandler')
    const router = useRouter()
    const validator = useValidator()
    const rules = new RuleCollection({
      loginId: {
        required: constraints.required(),
      },
      password: {
        required: constraints.required(),
      },
    })
    validator.setInitialData(state.form)

    watch(state.form, async () => {
      await validator.validate(state.form, rules)
      state.isError = validator.isError()
    })

    const onLoginClicked = async () => {
      const logined = await authHandler.login(
        state.form.loginId,
        state.form.password
      )
      if (!logined) {
        return
      }

      router.push({ name: 'Home' })
    }

    return { state, onLoginClicked, validator }
  },
})
</script>
