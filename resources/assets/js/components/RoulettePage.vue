<template>
    <div class="main-wrap">
        <div class="streams-block">
            <div  v-if="stage == 'watching' && checkToken" class="row">
                <div class="col-md-10">
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
                <div class="col-md-2 roulette-right-nav">
                    <div class="timer">
                        {{this.getMS.min}} : {{this.getMS.sec}}
                    </div>
                    <button class="btn btn-info" @click.prevent="nextStreams()">
                        next
                    </button>
                    <follow-drop-down v-bind:links="viewChannels"></follow-drop-down>
                    <drop-down mainLabel="Streamer Profile" baseUrl="profile" v-bind:links="viewChannels"></drop-down>
                    <drop-down mainLabel="Donate Streamer" baseUrl="donate" v-bind:links="viewChannels"></drop-down>
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
            <div v-if="stage == 'stoped' && checkToken" class="roulette-stoped">
                <h2>Confirm redeem points</h2>
                <form id="captcha-box">
                <div
                    id="captcha-button"
                >
                </div>
                </form>
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
    var config = require('./config/config.json');
    export default {
        data() {
            return {
                totalChannels : 0,
                stage: 'welcome',
                timeMax : 600,
                timeNow : 0,
                captcha : '',
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
                if (this.getCaptcha.length > 0) {
                    this.stage = 'watching';
                    this.$store.dispatch('nextRouletteAction');
                    this.$store.dispatch('redeemRouletteAction', this.getCaptcha);
                    this.startTimer();
                }
            },
            redeemStay() {
                if (this.getCaptcha.length > 0) {
                    this.stage = 'watching';
                    this.$store.dispatch('redeemRouletteAction', this.getCaptcha);
                    this.startTimer();
                }
            },
            startTimer() {
                const timer = setInterval(() => {
                    this.timeNow++;
                    if (this.timeNow >= this.timeMax) {
                        clearInterval(timer);
                        // time out
                        this.stage = 'stoped';
                        this.timeNow = 0;
                        this.renderCaptcha();        
                    }
                }, 1000);
            },
            renderCaptcha() {
                const waitCaptcha = setInterval(() => {
                    if (document.getElementById('captcha-button')) {
                        grecaptcha.render('captcha-button', {
                            'sitekey' : config.captcha_key,
                            'theme' : 'light'
                        });
                        clearInterval(waitCaptcha);
                    }
                }, 300);
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
            getCaptcha: function() {
                const form = document.getElementById('captcha-box');
                return form['g-recaptcha-response'].value;
            },
        },

    }
</script>