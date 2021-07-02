<template>
  <DefaultLayout>
    <div>
      <PageContent class="lg:w-1/2 mx-auto">
        <SectionTitle title="名前の提案" class="mb-4" />
        <FormRowList>
          <LabeledFormRow label-width="w-20" label="種類">
            <template v-slot:form>
              <CheckBoxList
                itemClass="mr-2"
                :items="typeCheckItemList"
                :checked="state.checkedTypes"
                @change="handleTypeChange"
              />
            </template>
          </LabeledFormRow>
          <LabeledFormRow label-width="w-20" label="特徴">
            <template v-slot:form>
              <CheckBoxList
                itemClass="mr-2"
                :items="charactericsCheckItemList"
                :checked="state.checkedCharacterics"
                @change="handleCharactericsChange"
              />
            </template>
          </LabeledFormRow>
          <FormRow class="justify-center">
            <SimpleButton
              title="送信"
              @onclick="handleGenerateNamesClick"
              :disabled="state.submitted"
            />
          </FormRow>
        </FormRowList>
        <div v-if="generateNamesHandler.isError()">エラーが発生しました。</div>
        <div v-else-if="generateNamesHandler.isDone()">
          <div class="flex flex-wrap my-4">
            <NameCard
              :name="name.name"
              v-for="name of state.names"
              :key="name.id"
              class="m-1"
            />
          </div>
        </div>
      </PageContent>
    </div>
    <LoadingIndicator :show="generateNamesHandler.isPending()" />
  </DefaultLayout>
</template>

<script>
import {
  computed,
  defineComponent,
  inject,
  onMounted,
} from '@vue/composition-api'
import { catRepositoryKey } from '@/domain/cat/catRepositoryInterface'
import { nameRepositoryKey } from '@/domain/name/NameRepositoryInterface'
import FormRowList from '@/components/common/form/FormRowList'
import FormRow from '@/components/common/form/FormRow'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import NameCard from '@/components/name/NameCard'
import SimpleButton from '@/components/common/button/SimpleButton'
import { HomeStore } from './HomeStore'

export default defineComponent({
  components: {
    LabeledFormRow,
    NameCard,
    FormRow,
    FormRowList,
    SimpleButton,
  },
  setup() {
    const catRepository = inject(catRepositoryKey)
    const nameRepository = inject(nameRepositoryKey)
    const homeStore = new HomeStore(catRepository, nameRepository)

    onMounted(async () => {
      await homeStore.loadMenuList()
    })

    const typeCheckItemList = computed(() => {
      return homeStore.state.typeList.map((item) => {
        return {
          id: item.id,
          label: item.name,
        }
      })
    })

    const charactericsCheckItemList = computed(() => {
      return homeStore.state.charactericsList.map((item) => {
        return {
          id: item.id,
          label: item.name,
        }
      })
    })

    return {
      state: homeStore.state,
      generateNamesHandler: homeStore.generateNamesHandler,
      handleGenerateNamesClick: homeStore.handleGenerateNamesClick,
      handleTypeChange: homeStore.handleTypeChange,
      handleCharactericsChange: homeStore.handleCharactericsChange,
      typeCheckItemList,
      charactericsCheckItemList,
    }
  },
})
</script>
