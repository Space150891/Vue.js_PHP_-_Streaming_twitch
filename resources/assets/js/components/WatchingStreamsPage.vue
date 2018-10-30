<template>
    <div class="main-wrap">
        <div class="streams-block">
            <div  v-if="canWatch" class="row">
                <div class="col-md-9">
                    <div class="row">
                        <stream-frame
                            v-for="(stream, index) in wachingStreamers"
                            v-bind:channel="stream"
                            v-bind:count="wachingStreamers.length"
                            :key="index"
                        >
                        </stream-frame>
                    </div>
                </div>
                <div class="col-md-3">
                    <chat-part v-bind:channels="wachingStreamers"></chat-part>
                </div>
            </div>
            <div v-if="!canWatch">
                <h2>select streams in Directory Page</h2>
            </div>
        </div>
        <right-part></right-part>
    </div>
</template>
<script>
const config = require('./config/config.json');

    export default {
        data() {
            return {
                connect: false,
                timer: false,
            }
        },
        mounted() {
            if (this.checkToken && this.wachingStreamers.length > 0) {
                this.startConnection();
            }
        },
        deactivated() {
            this.closeAll();
        },
        destroyed() {
            this.closeAll();
        },
        methods: {
            startConnection() {
                this.timer = setInterval(() => {
                this.$store.commit('viewingChannel', {'channels' : this.wachingStreamers});
                }, 1000 * 60); // one minute 
           },
           closeAll() {
                if (this.timer) {
                    clearInterval(this.timer);
                }
           },
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            wachingStreamers: function () {
                return this.$store.getters.wachingStreamers;
            },
            canWatch: function () {
                const totalStreams = this.wachingStreamers.length;
                const correctSize = [1, 2, 4];
                return (correctSize.indexOf(totalStreams) > -1);
            },
            token: function () {
                return this.$store.getters.jwt;
            },
        },
    }
</script>