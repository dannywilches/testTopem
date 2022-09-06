import Vue from 'vue'
import Vuelidate from 'vuelidate'
import VueSweetalert2 from 'vue-sweetalert2'
import App from './App'
import router from './router'
import './components/axios';;

Vue.config.productionTip = false;
/* eslint-disable no-new */
Vue.use(VueSweetalert2);
Vue.use(Vuelidate)

new Vue({
  el: '#app',
  router,
  render: h => h(App)
})
