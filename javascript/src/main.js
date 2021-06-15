import Vue from 'vue'
import App from './App.vue'
import router from './router'
import CompositionApi from '@vue/composition-api'
import { ServiceProvider } from '@/ServiceProvider'
import { registerComponents } from '@/components/common/commonComponents'
import '../css/index.css'

Vue.use(CompositionApi)

Vue.config.productionTip = false

const serviceProvider = new ServiceProvider()
serviceProvider.register()

registerComponents()

new Vue({
  router,
  provide: serviceProvider.boot(),
  render: (h) => h(App),
}).$mount('#app')
