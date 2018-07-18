<template>
    <div v-if="userId > 0 || checkToken" class="cabinet-page" >
        <h1 class="text-center">Donate</h1>
        
    </div>
    <div v-if="!userId || checkToken" class="cabinet-page" >
        <h2>click button Donate from Stream or Profile page</h2>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        props: {
          userId: {
            default: false,
            required: false
          },
        },
        data() {
            return {
                
            }
        },
        mounted() {
            this.$store.commit('loadProfile', this.userId);
        },
        methods: {
            // https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' + profileData.paypal + '&item_name=Donate+to+streamer+' + profileData.nikname
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            streamer: function () {
                return this.$store.getters.profileData;
            },
        },
    }
</script>