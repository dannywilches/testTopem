<template>
  <div class="container">
    <div class="card card-login mx-auto mt-5 shadow-card">
      <div class="card-header">
        Iniciar Sesión
      </div>
      <div class="card-body">
        <div class="form-group mb-3">
          <label for="">Email</label>
          <input class="form-control form-control-sm" type="email" v-model="email">
        </div>
        <div class="form-group mb-3">
          <label for="">Contraseña</label>
          <input class="form-control form-control-sm" type="password" v-model="password">
        </div>
      </div>
      <div class="card-footer text-center">
        <button class="btn btn-success" @click="LoginSession()"> Login</button>
      </div>
    </div>
  </div>
</template>
<script>
  import axios from 'axios';
  import RouterLink from 'vue-router';
  import Swal from 'sweetalert2';
  export default {
      name: 'Login',
      components: {
        RouterLink
      },
      data() {
          return {
              email: null,
              password: null
          }
      },
      methods: {
          LoginSession() {
              const item_session = {
                  email: this.email,
                  password: this.password,
              };
              axios
                  .post('auth/login', item_session)
                  .then(response => {
                      console.log(response);
                      localStorage.setItem('token', response.data.token);
                      this.$router.push('/bills');
                  }).catch(error => {
                    console.log(error);
                    Swal.fire("No fue posible iniciar sesión", '', 'error');
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
