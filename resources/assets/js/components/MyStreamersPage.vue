<template>
    <div v-if="checkToken" class="cabinet-page" >
        <h1 class="text-center">My streamers</h1>
        <ul class="list-group">
            <li v-for="streamer in myStreamers" class="list-group-item">
                <a v-bind:href="'#/profile/' + streamer.name" target="_blank">{{streamer.name}}</a>
                <a @click.prevent="removeAction(streamer.streamer_id)" href="#" class="btn btn-danger pull-right">remove</a>
            </li>
        </ul>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            this.$store.commit('loadMyStreamers');
        },
        methods: {
           removeAction(id) {
               this.$store.dispatch('removeMyStreamer', id);
           },
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            myStreamers: function () {
                return this.$store.getters.myStreamers;
            },
        },
    }
</script>