<template>
  <DefaultLayout>
    <div>
      <PageContent class="lg:w-1/2 mx-auto">
        <SectionTitle title="名前の提案" class="mb-4" />
        <FormRowList>
          <LabeledFormRow label-width="w-20" label="種類">
            <template v-slot:form>
              <LabeledCheckBox
                class="mr-2"
                v-for="type of state.typeList"
                :key="type.id"
                :id="type.id"
                :label="type.name"
              />
            </template>
          </LabeledFormRow>
          <LabeledFormRow label-width="w-20" label="特徴">
            <template v-slot:form>
              <LabeledCheckBox
                class="mr-2"
                v-for="character of state.charactericsList"
                :key="character.id"
                :id="character.id"
                :label="character.name"
              />
            </template>
          </LabeledFormRow>
          <FormRow class="justify-center"
            ><SimpleButton title="送信"
          /></FormRow>
        </FormRowList>
      </PageContent>
    </div>
  </DefaultLayout>
</template>

<script>
import { defineComponent, inject, onMounted } from '@vue/composition-api'
import { catRepositoryKey } from '@/domain/cat/catRepositoryInterface'
import FormRowList from '@/components/common/form/FormRowList'
import FormRow from '@/components/common/form/FormRow'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import SimpleButton from '@/components/common/button/SimpleButton'
import { HomeStore } from './HomeStore'

export default defineComponent({
  components: {
    LabeledFormRow,
    FormRow,
    FormRowList,
    SimpleButton,
  },
  setup() {
    const catRepository = inject(catRepositoryKey)
    const homeStore = new HomeStore(catRepository)

    onMounted(async () => {
      await homeStore.loadMenuList()
    })

    return {
      state: homeStore.state,
    }
  },
})
</script>
