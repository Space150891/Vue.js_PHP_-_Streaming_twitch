<template>
<div>
    <div v-if="userId == '' && checkToken" class="cabinet-page" >
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
                    <div>
                        <h2>
                            Streaming  link: 
                            <a v-bind:href="'start-stream/' + profileData.stream_token" target="_blank">
                                http://dev.streamcases.tv/start-stream/{{profileData.stream_token}}
                            </a>
                        </h2>
                        <h5>
                            You may enter this link to your OBS to make your stream active in Gamificator.
                            Or simple open this link in browser.
                        </h5>
                    </div>
                    <div>
                        <label class="text-success">
                            Prize alert frequency:
                            <select class="form-control" v-model="prizeAlert" v-on:change="savePrizeAlert()">
                                <option value=1> 1 second </option>
                                <option value=30> 30 seconds </option>
                                <option value=60> 1 minute </option>
                                <option value=120> 2 minutes </option>
                                <option value=300> 5 minutes </option>
                                <option value=600> 10 minutes </option>
                            </select>
                        </label>
                    </div>
                    <a class="btn btn-info" href="#/myviewers">My viewers</a>
                    <a  class="btn btn-info" href="#/mystreamers">My streamers</a>
                    <a  class="btn btn-info" href="#/mycards">My cards</a>
                    <a class="btn btn-info" href="#/notifications">Notifications</a>
                    <a class="btn btn-info" href="#/achivements">Achivements</a>
                    <a class="btn btn-info" href="#/custom-donate">Customize donate page</a>
                    <a class="btn btn-info" href="#/custom-achivements">Customize achivements page</a>
                    <div>
                        <h5>Donation alerts</h5>
                        <a v-if="!profileData.streamlabs" class="btn btn-warning" href="streamlabs/login">Connect Streamlabs</a>
                        <span  v-if="profileData.streamlabs" class="btn btn-secondary">Streamlabs connected</span>
                        <a  v-if="!profileData.streamelements" @click.prevent="SeModal=true" href="#" class="btn btn-warning">Connect Streamelements</a>
                        <div v-if="SeModal" class="se-modal">
                            <div>
                                <label for="se-textarea">Enter JWT token from your Streamelements accaunt page</label>
                                <textarea class="form-control" id="se-textarea" v-model="SeToken"></textarea>
                                <div>
                                    <button v-if="SeWait==false" class="btn btn-success pull-left" @click.prevent="CheckSeToken()">Check token</button>
                                    <button class="btn btn-warning pull-right" @click.prevent="SeModal=false">Close</button>
                                </div>
                                <h5>{{ SeStatus }}</h5>
                            </div>
                        </div>
                        <span  v-if="profileData.streamelements" class="btn btn-secondary">Streamelements connected</span>
                    </div>
                    <div class="my-cases row" v-if="profileData.cases">
                        <div v-for="lootCase in profileData.cases.closed" :key="lootCase.id" class="col-md-1">
                            <img v-bind:src="'storage/' + lootCase.image" alt="case">
                            <button @click="openCase(lootCase.id)" class="btn btn-sm btn-primary">open</button>
                        </div>
                        <div v-for="lootCase in profileData.cases.opened" :key="lootCase.id" class="col-md-1">
                            <img v-bind:src="'storage/' + lootCase.image" alt="case">
                            <span class="badge badge-secondary">opened</span>
                        </div>
                    </div>
                    <div v-if="boxOpened" class="shop-modal">
                        <div class="shop-box items-box">
                            <h3 v-if="winedItems.length > 0">Win items:</h3>
                            <div v-for="item in winedItems" :key="item.id">
                                <img v-bind:src="'storage/' + item.icon" v-bind:alt="item.title">
                                <h5>{{ item.title }}</h5>
                            </div>
                            <h3 v-if="winedPrizes.length > 0">Win prizes:</h3>
                            <div v-for="item in winedPrizes"  :key="item.id">
                                <img v-bind:src="'storage/' + item.image" v-bind:alt="item.name">
                                <h5>{{ item.name }}</h5>
                                
                            </div>
                            <section v-if="winedPrizes.length > 0" class="">
                                <p>To receive your prize please confirm your contacts</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="contact-country">Country:</span>
                                    </div>
                                    <input v-model="currentViewer.contacts.country" type="text" class="form-control" aria-label="Country..." aria-describedby="contact-country">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="contact-city">City:</span>
                                    </div>
                                    <input v-model="currentViewer.contacts.city" type="text" class="form-control" aria-label="City..." aria-describedby="contact-city">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="contact-zip">Zip-code</span>
                                    </div>
                                    <input v-model="currentViewer.contacts.zip_code" type="text" class="form-control" aria-label="Zip-code..." aria-describedby="contact-zip">
                                </div>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="contact-address">Local address</span>
                                    </div>
                                    <input v-model="currentViewer.contacts.local_address" type="text" class="form-control" aria-label="Local address..." aria-describedby="contact-address">
                                </div>
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
                            </section>
                            <button @click.prevent="getModalItems()" class="btn btn-success">GET</button>
                        </div>
                    </div>
                    <div v-if="profileData.prizes && profileData.prizes.length > 0" class="cabinet-prizes">
                        <h2>Winned prizes:</h2>
                        <div v-for="prize in profileData.prizes" :key="prize.id">
                            <img v-bind:src="'storage/' + prize.image">
                            <h5>{{ prize.name }}</h5>
                        </div>
                    </div>
                    <table v-if="customAchievementsLoaded" class="table table-sm">
                        <tbody>
                            <tr v-for="field in profileData.fields" :key="field.id">
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
                            <tr v-for="field in profileData.fields" :key="field.id">
                                <td>{{field.alias}}</td>
                                <td>
                                    <div v-if="field.name == 'inventory' && field.data" class="cabinet-prizes">
                                        <div v-for="item in field.data" :key="item.id">
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
    <div v-if="!checkToken" class="cabinet-page">
        Please login
    </div>
</div>
</template>
<style>
.se-modal {
    position: fixed; top:0; left:0; width:100%; height: 100%; background: rgb(1,1,1, .5);
}
.se-modal > div {
    position:absolute;  left:50%; top:300px; margin-left:-150px; width:300px; background:#fff;  padding:15px;  border-radius:10px;
}
.se-modal > div >div:after{
    content: ''; display:block; clear:both;
}
.se-modal > div textarea {
    width: 100%; height: 200px; margin-bottom: 10px;
}
.my-cases {
    margin-top:10px; margin-bottom:10px;
}
.my-cases > div > img {
    width:100%;
}
.my-cases > div> button {
    display:block; margin: 0 auto;
}
</style>
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
                prizeAlert: 30,
                SeModal: false,
                SeStatus: '',
                SeWait: false,
                SeToken: '',
                boxOpened: false,
                boxName: '',
                boxImage: '',
                phone: '',
                smsSended: false,
                openAlertModal: false,
                winItems: false,
                winedItems: [],
                winedPrizes: [],
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
            savePrizeAlert() {
                this.$store.dispatch('savePrizeAlertAction', this.prizeAlert);
            },
            CheckSeToken() {
                if (this.SeToken == '') {
                    this.SeStatus = 'JWT token empty!';
                } else {
                    this.SeStatus = 'waiting reply...';
                    this.SeWait = true;
                    const myHeaders = new Headers({
                        "Authorization": "Bearer " + this.SeToken.trim(),
                    });
                    let _this = this;
                    fetch('https://api.streamelements.com/kappa/v2/channels/me',
                    {
                        method: "GET",
                        credentials: 'omit',
                        mode: 'cors',
                        headers: myHeaders,
                    })
                    .then(function(res){
                        
                        if (res.ok) {
                            _this.SeStatus = 'token checked successful';
                            _this.saveSeToken();
                        } else {
                            _this.SeWait = false;
                            _this.SeStatus = 'token false';
                        }
                    });
                }
            },
            openCase(caseId) {
                let _this = this;
                let formData = new FormData();
                formData.append('token', this.$store.state.token);
                formData.append('viewer_case_id', caseId);
                fetch('api/cases/open',
                {
                    method: "POST",
                    credentials: 'omit',
                    mode: 'cors',
                    body: formData,
                })
                .then(function(res){
                    return res.json();
                })
                .then(function(jsonResp){
                    if (jsonResp.data) {
                        _this.winedItems = jsonResp.data.items;
                        _this.winedPrizes = jsonResp.data.prizes;
                        if ((jsonResp.data.items.length + jsonResp.data.prizes.length) > 0) {
                            _this.winItems = true;
                        }
                        _this.boxOpened = true;
                    }
                });
            },
            saveSeToken() {
                let _this = this;
                let formData = new FormData();
                formData.append('token', this.$store.state.token);
                formData.append('se_token', this.SeToken.trim());
                fetch('api/streamers/savesetoken',
                {
                    method: "POST",
                    credentials: 'omit',
                    mode: 'cors',
                    body: formData,
                })
                .then(function(res){
                    return res.json();
                })
                .then(function(jsonResp){
                    console.log(jsonResp);
                    if (jsonResp.message) {
                        _this.SeStatus = 'token save successful';
                        _this.profileData.streamelements = true;
                    } else {
                        _this.SeStatus = 'token save error';
                        _this.SeWait = false;
                    }
                });
            },
            sendSMS() {
               this.$store.commit('sendSMS', this.phone);
               this.smsSended = true;
            },
            checkCode() {
                this.$store.dispatch('checkCodeAction', this.code);
            },
            getModalItems() {
                if (this.winedPrizes.length > 0) {
                    let canSave = true;
                    if (this.currentViewer.contacts.country == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.city == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.zip_code == '') {
                        canSave = false;
                    }
                    if (this.currentViewer.contacts.local_address == '') {
                        canSave = false;
                    }
                    if (!this.profileData.verified) {
                        canSave = false;
                    }
                    if (canSave) {
                        this.$store.dispatch('updateViewerContacts', this.currentViewer.contacts);
                        this.boxOpened = false;
                    }
                } else {
                    this.boxOpened = false;
                }
                this.$store.commit('loadProfile', this.userId);
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
                this.prizeAlert= data.prize_alert;
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
            currentViewer: function () {
                return this.$store.getters.currentViewer;
            },
            
        },
    }
</script>