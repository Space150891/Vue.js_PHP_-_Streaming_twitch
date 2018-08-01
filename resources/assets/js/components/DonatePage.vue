<template>
    <div>
        <div v-if="userId.length > 0  && checkToken && streamer.paypal" class="cabinet-page" >
            <h1 class="text-center">Donate</h1>
                <label class="form-control">
                    <h2 class="text-center">
                        to streamer
                        <strong>{{streamer.name}}</strong>
                    </h2>
                </label>

                <label  class="form-control">
                    donater name
                    <input v-model="donater" type="text"  class="form-control">
                </label>
                <label  class="form-control">
                    sum USD
                    <input v-model="sum" type="number"  class="form-control">
                </label>
                <button @click.prevent="dotate()" class="btn btn-success form-control">DONATE</button>
        </div>
        <div v-if="userId.length == 0 && checkToken" class="cabinet-page" >
            <h2>click button Donate from Stream or Profile page</h2>
        </div>
        <div v-if="streamer && streamer.paypal == null" class="cabinet-page">
            <h2 class="text-danger text-center">This streamer did not have paypal accaunt</h2>
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
            dotate() {
                const link = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=" + this.streamer.paypal + "&item_name=Donate+to+streamer+" + this.streamer.name + "&amount=" + this.sum;
                this.$store.commit('pushAchivement', {name: 'Donate100Achievement', points: this.sum});
                this.$store.commit('pushAchivement', {name: 'FirstDonateAchievement'});
                window.location = link;
            }
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