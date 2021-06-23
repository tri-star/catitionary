import Vue from 'vue'
import DefaultLayout from '@/layouts/DefaultLayout.vue'
import LabeledCheckbox from './checkBox/LabeledCheckBox'
import PageContent from './PageContent'
import SectionTitle from './SectionTitle'

export function registerComponents() {
  Vue.component('DefaultLayout', DefaultLayout)
  Vue.component('LabeledCheckbox', LabeledCheckbox)
  Vue.component('PageContent', PageContent)
  Vue.component('SectionTitle', SectionTitle)
}
