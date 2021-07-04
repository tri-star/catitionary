<template>
  <div>
    <LabeledCheckBox
      :class="itemClass"
      v-for="item in items"
      :key="item.id"
      :id="item.id"
      :label="item.label"
      :checked="checked.includes(item.id)"
      @check="handleCheck"
    />
  </div>
</template>

<script>
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  props: {
    // チェックボックスのリスト。id,labelのプロパティを持ったオブジェクトの配列
    items: {
      required: true,
    },
    // チェック済要素のIDを持った配列
    checked: {
      type: Array,
      default: () => [],
    },
    itemClass: {
      type: String,
      default: '',
    },
  },
  setup(props, context) {
    const handleCheck = (payload) => {
      let newCheckedList = props.checked.filter((itemId) => {
        return itemId !== payload.id
      })

      if (payload.checked) {
        newCheckedList.push(payload.id)
      }
      context.emit('change', newCheckedList)
    }

    return {
      handleCheck,
    }
  },
})
</script>
