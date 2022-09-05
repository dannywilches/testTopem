<template>
  <div class="container">
    <div class="card card-login mx-auto mt-5 shadow-card">
      <div class="card-header">
        Nuevo Usuario
      </div>
      <div class="card-body">
        <div class="form-group mb-3">
          <label for="">Name</label>
          <input class="form-control form-control-sm" type="text" v-model="name">
        </div>
        <div class="form-group mb-3">
          <label for="">Email</label>
          <input class="form-control form-control-sm" type="email" v-model="email">
        </div>
        <div class="form-group mb-3">
          <label for="">Contraseña</label>
          <input class="form-control form-control-sm" type="password" v-model="password">
        </div>
        <div class="form-group mb-3">
          <label for="">Confirme Contraseña</label>
          <input class="form-control form-control-sm" type="password" v-model="password_confirmation">
        </div>
      </div>
      <div class="card-footer text-center">
        <button class="btn btn-success" @click="RegisterUser()"> Registrarse</button>
        <!-- <button class="btn btn-info"> Registrarse</button> -->
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios';
  import RouterLink from 'vue-router';
  // import store from '../store'
  export default {
      name: 'Register',
      components: {
        RouterLink
      },
      data() {
          return {
              name: null,
              email: null,
              password: null,
              password_confirmation: null
          }
      },
      methods: {
          RegisterUser() {
              const item_register = {
                  name: this.name,
                  email: this.email,
                  password: this.password,
                  password_confirmation: this.password_confirmation,
              };
              axios
                  .post('auth/register', item_register)
                  .then(response => {
                      console.log(response);
                  }).catch(error => {
                    console.log(error);
                  })
          }
      }
  }
</script>
<style>
  .card {
    position: relative;
    border-radius: 0.5rem;
  }
  .card-login{
    max-width: 25rem;
  }
</style>
