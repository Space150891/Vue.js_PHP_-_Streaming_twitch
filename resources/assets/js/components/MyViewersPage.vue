<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">My viewers</h1>
        <ul class="list-group">
            <li v-for="viewer in myViewers" class="list-group-item">
                {{viewer.name}}
            </li>
        </ul>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        mounted() {
            this.$store.commit('loadMyViewers');
        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            myViewers: function () {
                return this.$store.getters.myViewers;
            },
        },
    }
</script>