<template>
    <div class="cabinet-page" >
        <h1>StartStreamPage</h1>
        <h3>{{message}}</h3>
    </div>
</template>
<script>
const config = require('./config/config.json');

    export default {
        props: {
          streamToken: {
            default: false,
            required: true
          },
        },
        data() {
            return {
                connect: false,
                message: '',
            }
        },
        mounted() {
            this.startConnection();
        },
        deactivated() {
            if (this.connect) {
                this.connect.close();
            }
        },
        destroyed() {
            if (this.connect) {
                this.connect.close();
            }
        },
        methods: {
           startConnection() {
                this.connect = new WebSocket(config.ws_server);
                const ws = this.connect;
                ws.onopen = () => {
                    const mess = {
                        role: 'streamer',
                        token:  this.streamToken
                    }
                    ws.send(JSON.stringify(mess));
                };
                ws.onmessage = (event) => {
                    this.message = event.data;
                };
           },
        },
        computed: {
            
        },
    }
</script>