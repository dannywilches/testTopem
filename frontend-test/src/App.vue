<template>
  <div id="app">
    <Nav></Nav>
    <!-- <LoginInit/> -->
    <div class="auth-wrapper">
      <router-view/>
    </div>
  </div>
</template>

<script>
  import RouterLink from 'vue-router';
  import Nav from './components/Nav.vue'
  import LoginInit from './components/Login.vue'
  export default {
    name: 'App',
    components: {
      Nav, LoginInit, RouterLink
    }
  }
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* text-align: center; */
  color: #2c3e50;
  margin-top: 150px;
  background-color: cadetblue;
}
</style>
