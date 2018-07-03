<template>
    <div class="container">
    <admin-menu page="/logout"></admin-menu>
    <div v-if="checkToken" class="row justify-content-center">
        <div class="jumbotron">
            <button class="btn btn-danger" @click.prevent="logoutAction">LOGOUT</button>
        </div>
    </div>
    <h5 v-if="!checkToken">login first</h5>
</div>
</template>
<script>
    export default {
        methods: {
           logoutAction : function() {
               this.$store.commit('logout');
           }
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
        }
    }
</script>