<template>
    Soy el Login
    <div class="container">
        <button class="" @click="LoginSession()"> Login</button>
    </div>
</template>
<script>
    import axios from 'axios';
    export default {
        name: 'LoginInit',
        
        /* computed: {
            username() {
                return this.$route.params.username
            }
        }, */
        data() {
            return {
                name_session: null
            }
        },
        methods: {
            LoginSession() {
                const item_session = {
                    email: 'dannywilches23@gmail.com',
                    password: 'Danny_23',
                };
                axios
                    .post('http://127.0.0.1:8000/api/auth/login', item_session)
                    .then(response => {
                        console.log(response);
                    })
            }
        }
    }
</script>