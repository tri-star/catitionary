<template>
  <DefaultLayout>
    <div>
      <FormRowList>
        <CardItem>
          <LabeledFormRow label-width="w-20" label="種類">
            <template v-slot:form>
              <select>
                <option>テスト</option>
              </select>
            </template>
          </LabeledFormRow>
        </CardItem>
        <CardItem>
          <LabeledFormRow label-width="w-20" label="特徴">
            <template v-slot:form>
              <select>
                <option>テスト</option>
              </select>
            </template>
          </LabeledFormRow>
        </CardItem>
        <CardItem>
          <FormRow class="justify-center"
            ><SimpleButton title="送信"
          /></FormRow>
        </CardItem>
      </FormRowList>
    </div>
  </DefaultLayout>
</template>

<script>
import CardItem from '@/components/common/CardItem'
import DefaultLayout from '@/layouts/DefaultLayout'
import FormRowList from '@/components/common/form/FormRowList'
import FormRow from '@/components/common/form/FormRow'
import LabeledFormRow from '@/components/common/form/LabeledFormRow'
import SimpleButton from '@/components/common/button/SimpleButton'

export default {
  components: {
    DefaultLayout,
    CardItem,
    LabeledFormRow,
    FormRow,
    FormRowList,
    SimpleButton,
  },
  setup() {},
}
</script>
