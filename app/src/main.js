import Vue from 'vue'
import App from './App.vue'
import VueMaterial from 'vue-material'
import{MdButton, MdContent, MdList, MdTable, MdIcon, MdDivider, MdCard} from 'vue-material/dist/components'
import 'vue-material/dist/vue-material.min.css'
import 'vue-material/dist/theme/black-green-dark.css'
Vue.config.productionTip = false

new Vue({
  render: h => h(App),
}).$mount('#app');

Vue.use(VueMaterial);
Vue.use(MdButton);
Vue.use(MdContent);
Vue.use(MdTable);
Vue.use(MdList);
Vue.use(MdIcon);
Vue.use(MdDivider);
Vue.use(MdCard);