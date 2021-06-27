import Vue from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import LabeledCheckBox from './checkBox/LabeledCheckBox'
import PageContent from './PageContent'
import SectionTitle from './SectionTitle'

export function registerComponents() {
  Vue.component('DefaultLayout', DefaultLayout)
  Vue.component('LabeledCheckBox', LabeledCheckBox)
  Vue.component('PageContent', PageContent)
  Vue.component('SectionTitle', SectionTitle)
}
