<template>
    <div>
        <div v-if="userId.length > 0  && checkToken && streamer.paypal" class="donate-page">
            <img v-if="streamer.donate_back" v-bind:src="'storage/' + streamer.donate_back" class="back-image">
            <div class="box">
                <div class="header">
                    <img v-if="streamer.donate_front" v-bind:src="'storage/' + streamer.donate_front" class="back-front">
                    <img v-if="streamer.user.avatar" v-bind:src="streamer.user.avatar" class="avatar">
                    <p>
                        {{streamer.donate_text}}
                    </p>
                </div>
                <div class="form">
                    <label  class="form-control">
                        donater name
                        <input v-model="donater" type="text"  class="form-control">
                    </label>
                    <label  class="form-control">
                        comment
                        <input v-model="comment" type="text"  class="form-control">
                    </label>
                    <label  class="form-control">
                        sum USD
                        <input v-model="sum" type="number"  class="form-control">
                    </label>
                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="business"  v-model="streamer.paypal">
                        <input type="hidden" name="cmd" value="_donations">
                        <input type="hidden" name="amount" v-model="sum">
                        <input type="hidden" name="item_name" v-model="comment">
                        <input type="hidden" name="item_number" value="Gamificator">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="notify_url" value="http://dev.streamcases.tv/paypal/notify">
                        <input type="submit" name="DONATE" class="btn btn-success form-control">
                    </form>
                    
                </div>
            </div>
        </div>
        <div v-if="userId.length == 0 && checkToken" class="cabinet-page" >
            <h2>click button Donate from Stream or Profile page</h2>
        </div>
        <div v-if="streamer && streamer.paypal == null" class="cabinet-page">
            <h2 class="text-danger text-center">This streamer did not have paypal account</h2>
        </div>
        <div v-if="!checkToken" class="cabinet-page">
            Please login
        </div>
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
                sum : 100,
                donater: '',
                comment: '',
            }
        },
        mounted() {
            this.$store.commit('loadStreamerFullData', this.userId);
            if (this.checkToken) {
                this.$store.commit('loadCurrentViewer');
                setTimeout(() => {
                    this.donater = this.getDonater;
                }, 2000);
            }
            
        },
        methods: {
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            streamer: function () {
                console.log('streamer', this.$store.getters.streamerFullData);
                return this.$store.getters.streamerFullData;
            },
            getDonater: function () {
                if (this.checkToken) {
                    const viewer = this.$store.getters.currentViewer;
                    return viewer.name;
                }
                return '';
            },
        },
    }
</script>