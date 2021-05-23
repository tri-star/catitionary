<template>
  <DefaultLayout>
    <div>
      <CardItem>
        <div class="flex">
          <span class="self">種類</span>
          <select>
            <option>テスト</option>
          </select>
        </div>
      </CardItem>
      <CardItem>
        <div class="flex">
          <span class="self">特徴</span>
          <select>
            <option>テスト</option>
          </select>
        </div>
      </CardItem>
    </div>
  </DefaultLayout>
</template>

<script>
import DefaultLayout from '@/layouts/DefaultLayout'
import CardItem from '@/components/common/CardItem'

export default {
  components: {
    DefaultLayout,
    CardItem,
  },
  setup() {},
}
</script>
