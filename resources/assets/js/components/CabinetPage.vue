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
            </div>
        </div>
        <div>
            <div>
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
                    <a class="btn btn-info" href="#/custom-donate">Customize donate page</a>
                    <a class="btn btn-info" href="#/custom-achivements">Customize achivements page</a>
                    <div v-if="profileData.prizes && profileData.prizes.length > 0" class="cabinet-prizes">
                        <h2>Winned prizes:</h2>
                        <div v-for="prize in profileData.prizes">
                            <img v-bind:src="'storage/' + prize.image">
                            <h5>{{ prize.name }}</h5>
                        </div>
                    </div>
                    <table v-if="customAchievementsLoaded" class="table table-sm">
                        <tbody>
                            <tr v-for="field in profileData.fields">
                                <td>{{field.alias}}</td>
                                <td>{{field.value}}</td>
                                <td>
                                    <i v-if="checkHiden(field.name)" class="fa fa-eye-slash"></i>
                                    <i v-else class="fa fa-eye"></i>
                                </td>
                                <td>
                                    <button v-if="checkHiden(field.name)" @click.prevent="setUnHidden(field.name)" class="btn btn-xs btn-info">
                                        show
                                    </button>
                                    <button v-else @click.prevent="setHidden(field.name)" class="btn btn-xs btn-warning">
                                        hide
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div v-if="!customAchievementsLoaded" class="v-loading">
                    </div>
                </div>
                <div v-if="userId != ''">
                    <a
                        v-if="profileData.paypal"
                        v-bind:href="'#/donate/' + profileData.streamer_id"
                        class="btn btn-warning"
                    >
                        Donate Page
                    </a>
                    <table class="table table-sm">
                        <tbody>
                            <tr v-for="field in profileData.fields">
                                <td>{{field.alias}}</td>
                                <td>
                                    <div v-if="field.name == 'inventory' && field.data" class="cabinet-prizes">
                                        <div v-for="item in field.data">
                                            <img v-bind:src="'storage/' + item.icon">
                                            <h5>{{ item.title }}</h5>
                                        </div>
                                    </div>
                                    <span v-else>{{field.value}}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
            checkHiden(field) {
                return (this.profileData.hide_fields.indexOf(field) > -1) ? true : false;
            },
            setHidden(field) {
                this.$store.dispatch('hideProfileFieldAction', field);
            },
            setUnHidden(field) {
                this.$store.dispatch('showProfileFieldAction', field);
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
            customAchievementsLoaded: function () {
                return this.$store.getters.customAchievementsLoaded;
            },
        },
    }
</script>