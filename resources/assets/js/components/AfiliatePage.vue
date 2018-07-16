<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">Afiliate</h1>
        <h2 class="">To participate in our affiliate system, just shared your account URL:</h2>
        <h3 class="text-center">{{baseLink + currentUser.id}}</h3>
        
        <h4>Visited: {{afiliates.visited}}</h4>
        <h4>Registered: {{afiliates.registered}}</h4>
        <h4>Total: {{afiliates.total}}</h4>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    var config = require('./config/config.json');
    export default {
        data: () => {
            return {
                baseLink: config.baseUrl + '/api/afiliate/',
            }
        },
        mounted() {
            this.$store.dispatch('loadAfiliated');
        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            afiliates: function () {
                return this.$store.getters.afiliates;
            },
            currentUser: function () {
                return this.$store.getters.profileData;
            },
        },
    }
</script>