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
  import Swal from 'sweetalert2';
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
        // Función que realiza el registro de nuevos usuarios enviando todos los datos necesarios
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
                    if (response.status == 201) {
                      // this.$swal.fire('Usuario Registrado');
                      Swal.fire("Usuario Registrado", '', 'success').then((result) => {
                        if (result.isConfirmed) {
                          this.$router.push('/login');
                        }
                      });
                    }
                    else {
                      Swal.fire("El Usuario no pudo ser registrado valide los datos ingresados o intente nuevamente", '', 'error').then((result) => {
                        if (result.isConfirmed) {
                          this.$router.push('/login');
                        }
                      });

                    }
                }).catch(error => {
                  Swal.fire("El Usuario no pudo ser registrado valide los datos ingresados o intente nuevamente", '', 'error');
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
