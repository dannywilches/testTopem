<template>
  <nav class="navbar navbar-expand bg-dark navbar-dark fixed-top">
      <div class="collapse navbar-collapse justify-content-between">
        <ul class="navbar-nav" ml-auto>
          <li v-if="valid_session" class="nav-item">
            <router-link to="/bills" class="nav-link">Facturas</router-link>
          </li>
          <li v-if="!valid_session" class="nav-item">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li v-if="!valid_session" class="nav-item">
            <router-link to="/register" class="nav-link">Registro</router-link>
          </li>
        </ul>
        <span class="text-light" v-if="valid_session">
          {{ name_session }}
          <button class="btn bg-light btn-ligth">Cerrar Sesión</button>
        </span>
      </div>
  </nav>
</template>
<script>
  import axios from 'axios';
  export default {
    name: 'Nav',
    data() {
      return {
        valid_session: false,
        name_session: null
      }
    },
    created() {
      this.validSession();
    },
    methods: {
      validSession() {
        axios.post('/auth/user').then(response => {
          if (response.status == 200) {
            this.valid_session = true;
            this.name_session = response.data.user.name;
          }
          else {
            this.$router.push('/login');
          }
        })
        .catch(error => {
          this.$router.push('/login');
          console.log(error);
        })
      }
    }
  }
</script>
