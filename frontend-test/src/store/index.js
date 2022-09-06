import Vue from "vue";
import Vuex from 'vuex';
import axios from 'axios'

Vue.use(Vuex, axios);

// const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  state: {
    posts: []
  },
  actions: {
    getListBills({commit}) {
      console.log('entro al list');
      axios.get('bills/list').then(resp => {
        console.log(resp);
        commit('SET_Items', resp)
      }).catch(error => {
        console.log(error);
      });
    }
  },
  mutations: {

  },
})
