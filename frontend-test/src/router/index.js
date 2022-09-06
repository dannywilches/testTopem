import Vue from 'vue'
import Router from 'vue-router'
import Login from '@/components/Login'
import Register from '@/components/Register'
import Bills from '@/components/Bills'
import ManageBill from '@/components/ManageBill'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base:   process.env.BASE_URL,
  routes: [
    {
      path: '/',
      redirect: '/login'
    },
    {
      path: '/login',
      component: Login
    },
    {
      path: '/register',
      component: Register
    },
    {
      path: '/bills',
      component: Bills,
    },
    {
      path: '/manage-bill',
      component: ManageBill
    },
    {
      path: '/manage-bill/:id',
      component: ManageBill
    },
  ]
})
