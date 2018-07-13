<template>
    <div v-if="userId > 0 || checkToken" class="cabinet-page" >
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
                <div v-if="parseInt(userId) == 0">
                    <a class="btn btn-info pull-left" href="#/myviewers">My viewers</a>
                    <a  class="btn btn-info pull-right" href="#/mystreamers">My streamers</a>
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
            default: 0,
            required: false
          },
        },
        data() {
            return {
                
            }
        },
        mounted() {
            this.$store.commit('loadProfile', this.userId);
        },
        methods: {
           
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            profileData: function () {
                return this.$store.getters.profileData;
            },
        },
    }
</script>