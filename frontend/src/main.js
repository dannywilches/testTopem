import { createApp } from 'vue'
import App from './App.vue'
// import VueRouter from 'vue-router'
import { createRouter, createWebHistory } from 'vue-router'
import Login from './components/Login.vue'
import HelloWorld from './components/HelloWorld.vue'

// createApp(App).mount('#app')

const routes = [
    {
        path: '/hello',
        // name: 'home',
        component: HelloWorld
    },
    {
        path: '/login',
        // name: 'login',
        component: Login
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
})

const app = createApp(App)

app.use(router)
app.mount("#app")