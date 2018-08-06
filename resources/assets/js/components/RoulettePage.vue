<template>
    <div class="main-wrap">
        <div class="streams-block">
            <div  v-if="stage == 'watching' && checkToken" class="row">
                <div class="col-md-11">
                    <div class="row">
                        <stream-frame
                            v-for="(stream, index) in viewChannels"
                            v-bind:channel="stream"
                            v-bind:count="viewChannels.length"
                            :key="index"
                        >
                        </stream-frame>
                    </div>
                </div>
                <div class="col-md-1 roulette-right-nav">
                    <div class="timer">
                        {{this.getMS.min}} : {{this.getMS.sec}}
                    </div>
                    <button
                        class="btn btn-info"
                        @click.prevent="nextStreams()"
                    >
                            next
                    </button>
                </div>
            </div>
            <div v-if="stage == 'welcome' && checkToken && currentPoints > 0" class="roulette-welcome">
                <h1>Roulette</h1>
                <input v-model="totalChannels" type="radio" value=1 name="channels" id="cr1">
                <label for="cr1">
                    1 <br>channel
                </label>
                <input v-model="totalChannels" type="radio" value=2 name="channels"  id="cr2">
                <label for="cr2">
                    2 <br>channels
                </label>
                <input v-model="totalChannels" type="radio" value=4 name="channels"  id="cr3">
                <label for="cr3">
                    4 <br>channels
                </label>
                <button
                    v-if="totalChannels > 0"
                    @click.prevent="startViewRoulette()"
                    class="btn btn-lg btn-success"
                >
                    view
                </button>
            </div>
            <div v-if="stage == 'welcome' && checkToken && currentPoints < 10">
                <h2>You does not have enough points</h2>
            </div>
            <div v-if="stage == 'stoped' && checkToken">
                <h2>Confirm redeem points</h2>
                    <vue-recaptcha sitekey="6LeKiWgUAAAAAMoKLZ5JqthjMkOmXEC-g1x_k5Bq"></vue-recaptcha>
                <div>
                    <button @click.prevent="redeemNext()" class="btn btn-success">next random</button>
                    <button @click.prevent="redeemStay()" class="btn btn-warning">stay with this channel(s)</button>
                </div>
            </div>
            <div v-if="!checkToken">
                <h2>Only users. Please login.</h2>
            </div>
        </div>
        <right-part></right-part>
    </div>
</template>
<script>
    // import VueRecaptcha from 'vue-recaptcha';

    export default {
        data() {
            return {
                totalChannels : 0,
                stage: 'welcome',
                timeMax : 4,
                timeNow : 0,
                captcha : 'z',
            }
        },
        mounted() {
        },
        methods: {
            startViewRoulette() {
                this.stage = 'watching';
                this.$store.dispatch('startWatchingRouletteAction', this.totalChannels);
                this.startTimer();
            },
            nextStreams() {
                this.$store.dispatch('nextRouletteAction');
            },
            redeemNext() {
                this.stage = 'watching';
                this.$store.dispatch('nextRouletteAction');
                this.$store.dispatch('redeemRouletteAction', this.captcha);
                this.startTimer();
            },
            redeemStay() {
                this.stage = 'watching';
                this.$store.dispatch('redeemRouletteAction', this.captcha);
                this.startTimer();
            },
            startTimer() {
                const timer = setInterval(() => {
                    this.timeNow++;
                    if (this.timeNow >= this.timeMax) {
                        clearInterval(timer);
                        // time out
                        this.stage = 'stoped';
                        this.timeNow = 0;
                    }
                }, 1000);
            }
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            channelsCount: function () {
                return this.$store.getters.rouletteChannelsCount;
            },
            viewChannels:  function () {
                return this.$store.getters.rouletteChannels;
            },
            currentPoints: function () {
                return this.$store.getters.currentViewer.points;
            },
            getMS: function() {
                const min = Math.floor(this.timeNow / 60);
                const sec = this.timeNow % 60;
                return {
                    min : min > 9 ? min + '' : '0' + min,
                    sec : sec > 9 ? sec + '' : '0' + sec,
                };
            },
        },

    }
</script>