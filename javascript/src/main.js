import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CompositionApi from '@vue/composition-api'
import { ServiceProvider } from '@/ServiceProvider'
import '../css/index.css'

Vue.use(CompositionApi)

Vue.config.productionTip = false

new Vue({
  router,
  provide: ServiceProvider.boot(),
  render: (h) => h(App),
}).$mount('#app')
