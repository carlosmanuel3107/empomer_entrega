import 'core-js/stable'
import Vue from 'vue'
import App from './App'
import router from './router'
import CoreuiVue from '@coreui/vue'
import { iconsSet as icons } from './assets/icons/icons.js'
import store from './store'
import * as VueGoogleMaps from "vue2-google-maps";
import JwPagination from 'jw-vue-pagination';

Vue.prototype.$apiAdress = 'http://127.0.0.1:8000'
Vue.prototype.$server='http://127.0.0.1:8000'; 
Vue.config.performance = true
Vue.use(CoreuiVue)
Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyDp3Ud3SixagW8bJOwtosy5bBMB5JRNS_k",
  },
});
Vue.component('jw-pagination', JwPagination);

new Vue({
  el: '#app',
  router,
  store,  
  icons,
  template: '<App/>',
  components: {
    App
  },
})
