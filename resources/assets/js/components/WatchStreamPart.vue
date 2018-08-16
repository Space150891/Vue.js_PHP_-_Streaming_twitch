<template>
    <div v-bind:class="divClass">
        <iframe
            v-bind:src="twitchVideoUrl(channel)"
            v-bind:height="height"
            width=100%
            frameborder="0"
            scrolling="no"
            allowfullscreen="false"
        >
        </iframe>
    </div>
</template>
<script>
    export default {
        props: {
            channel: {
                type: String,
                required: true
            },
            count: {
                type: Number,
                required: true
            },
        },
        data() {
            return {

            }
        },
        mounted() {
        },
        methods: {
            twitchVideoUrl(channelName) {
                return "https://player.twitch.tv/?channel=" + channelName;
            },
        },
        computed: {
            divClass: function () {
                let cl = 'col-md-12 video-iframe-item';
                if (this.count == 2) {
                    cl = 'col-md-12 video-iframe-item';
                }
                if (this.count == 4) {
                    cl = 'col-md-6 video-iframe-item';
                }
                return cl;
            },
            height: function () {
                let h = "700px";
                if (this.count == 2) {
                    h = '400px';
                }
                if (this.count == 4) {
                    h = '400px';
                }
                return h;
            },
        },
    }
</script>