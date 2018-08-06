<template>
    <div v-if="userId == '' || checkToken" class="cabinet-page" >
        <h1 class="text-center">Profile</h1>
        <div class="row">
            <div class="col-md-3">
                <img v-if="profileData.avatar" v-bind:src="profileData.avatar" class="img-thumbnail avatar-img" alt="avatar"/>
            </div>
            <div class="col-md-9">
                {{profileData.bio ? profileData.bio : ''}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                 <viewer-card
                    v-if="profileData.card"
                    v-bind:frame="profileData.card.frame"
                    v-bind:hero="profileData.card.hero"
                    v-bind:achivement="profileData.card.achievement"
                ></viewer-card>
            </div>
            <div class="col-md-9">
                <h5>Twitch details</h5>
                <ul class="list-group">
                    <li class="list-group-item">username <span class="badge">{{profileData.username}}</span></li>
                    <li class="list-group-item">nikname <span class="badge">{{profileData.nikname}}</span></li>
                    <li class="list-group-item" v-if="profileData.email">email <span class="badge">{{profileData.email}}</span></li>
                </ul>
                <a 
                v-if="profileData.paypal"
                v-bind:href="'https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' + profileData.paypal + '&item_name=Donate+to+streamer+' + profileData.nikname">
                    Donate
                </a>
                <a
                    v-if="profileData.paypal"
                    v-bind:href="'#/donate/' + profileData.streamer_id">
                    Donate Page
                </a>
                <div v-if="userId == ''">
                    Phone status:
                    <span v-if="profileData.verified">verified</span>
                    <span v-if="!profileData.verified">Unverified</span>
                    <div v-if="!profileData.verified">
                        <div v-if="!smsSended" class="form-inline">
                            <input
                                v-model="phone"
                                placeholder="Phone..."
                                class="form-control"
                            >
                            <button
                                @click.prevent="sendSMS()"
                                placeholder="Code..."
                                class="btn btn-success"
                            >
                                send SMS
                            </button>
                        </div>
                        <div
                            v-if="smsSended"
                            class="form-inline"
                        >
                            <input
                                v-model="code"
                                class="form-control"
                            >
                            <button
                                @click.prevent="checkCode()"
                                class="btn btn-success"
                            >
                                check Code
                            </button>
                        </div>
                        <modal-alert
                            v-if="checkedCode==='false'"
                            AlertType="warning"
                            v-bind:messages="['code wrong']"
                            v-bind:opened="openAlertModal"
                            v-on:close-alert-modal="openAlertModal=false"
                        ></modal-alert>
                    </div>
                    <br>
                    <a class="btn btn-info" href="#/myviewers">My viewers</a>
                    <a  class="btn btn-info" href="#/mystreamers">My streamers</a>
                    <a  class="btn btn-info" href="#/mycards">My cards</a>
                    <a class="btn btn-info" href="#/notifications">Notifications</a>
                    <a class="btn btn-info" href="#/achivements">Achivements</a>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="cabinet-page">
        Please login
    </div>
</template>
<script>
    export default {
        props: {
          userId: {
            default: '',
            required: false
          },
        },
        data() {
            return {
                phone: '',
                code: '',
                smsSended: false,
                openAlertModal: false,
            }
        },
        mounted() {
            this.$store.commit('loadProfile', this.userId);
        },
        methods: {
           sendSMS() {
               this.$store.commit('sendSMS', this.phone);
               this.smsSended = true;
           },
           checkCode() {
                this.$store.dispatch('checkCodeAction', this.code);
           },
        },
        computed: {
            checkToken: function () {
                return this.$store.getters.checkToken;
            },
            profileData: function () {
                const data = this.$store.getters.profileData;
                if (data.phone && this.phone == '') {
                    this.phone = data.phone;
                }
                return data;
            },
            checkedCode: function () {
                const result = this.$store.getters.checkedCode;
                if (result === 'true') {
                    window.location.reload();
                }
                if (result === 'false') {
                    this.openAlertModal = true;
                    this.smsSended = false;
                }
                return result;
            },
        },
    }
</script>