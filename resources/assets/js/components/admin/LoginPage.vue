<template>
    <div  >
    <admin-menu page="/login"></admin-menu>
    <h5 v-if="checkToken" class="success">logged successful</h5>
    <div v-else class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <form method="POST" action="">

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" required autofocus v-model="email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required v-model="password">

                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary" @click.prevent="loginAction">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
    export default {
        data() {
            return {
                count: 0,
                email: '',
                password: '',
            }
        },
        mounted() {
            
        },
        methods: {
           loginAction : function() {
               this.$store.commit('authWithToken', {email : this.email, password : this.password});
           }
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
        }
    }
</script>