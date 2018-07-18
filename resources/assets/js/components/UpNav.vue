<template>
<div class="up-nav">
    <ul class="up-nav-main">
        <li><a href="#">HOW IT WORKS</a></li>
        <li><a href="#">SUPPORT</a></li>
        <li><a href="#">APPS</a></li>
        <li><a href="#">STORE</a></li>
        <li class="up-nav-active"><a href="#" >BUTTON</a></li>
    </ul>
    <ul class="up-nav-social">
        <li>
            <a v-bind:href="'https://plus.google.com/share?url=' + url"  target="_blank">
                <img class="up-nav-social-icon" src="../../../../public/images/google-plus.svg" alt="google-plus">
            </a>
        </li>
        <li>
            <a @click="sendTWAchivement()" v-bind:href="'https://twitter.com/share?url=' + url"  target="_blank">
                <img class="up-nav-social-icon" src="../../../../public/images/twitter.svg" alt="twitter">
            </a>
        </li>
        <li>
            <a @click="sendFBAchivement()" v-bind:href="'http://www.facebook.com/sharer.php?u=' + url"  target="_blank">
                <img class="up-nav-social-icon" src="../../../../public/images/facebook.svg" alt="facebook">
            </a>
        </li>
    </ul>
</div>
</template>

<style lang="scss">
    .up-nav {
        width: 100%;
        height: 22px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000000;
        display: flex;
        justify-content: space-between;
        background: #30303e;
        ul {
            list-style: none;
            a {
                text-decoration: none;
                color: white;
                padding: 1px 10px;
                &:active {
                    background-color: #db4646;
                }
            }
        }
    }
    .up-nav-main {
        display: flex;
        justify-content: start;
        padding: 0;
        margin: 0;
        margin-left: 20px;
        li {
            font-weight: 800;
            font-size: 14px;
            &:hover {
                background-color: #aa6161;
            }
            
            
        }
    }
    .up-nav-social {
        display: flex;
        justify-content: start;
        padding: 0;
        margin: 0;
        margin-right: 20px;
        li {
            margin: 0px 15px;
        }
    }
    .up-nav-social-icon {
        margin-bottom: 5px;
    }
    .up-nav-active {
        background-color: #db3939;
    }
    
    

    @media screen and (max-width: 991px)  {
        .up-nav-social {
            display: none;
        }
    }
    @media screen and (max-width: 438px)  {
        .up-nav-main {
            li {
                font-size: 12px;
            }
        }
    }
    @media screen and (max-width: 385px)  {
        .up-nav-main {
            li {
                font-size: 10px;
            }
        }
        .up-nav {
            ul {
                a {
                    padding: 1px 4px;
                }
            }
        }
    }
</style>

<script>
    export default {
        props: {
          
        },
        data() {
            return {
                
            }
        },
        mounted() {
            
        },
        methods: {
           sendFBAchivement() {
                this.$store.commit('pushAchivement', {name: 'FirstFBlikeAchievement'});
                this.$store.commit('pushAchivement', {name: 'FB10likeAchievement'});
                this.$store.commit('pushAchivement', {name: 'FB20likeAchievement'});
                this.$store.commit('pushAchivement', {name: 'FB50likeAchievement'});
            },
            sendTWAchivement() {
                this.$store.commit('pushAchivement', {name: 'FirstTweetAchievement'});
                this.$store.commit('pushAchivement', {name: 'Tweet10Achievement'});
                this.$store.commit('pushAchivement', {name: 'Tweet20Achievement'});
                this.$store.commit('pushAchivement', {name: 'Tweet50Achievement'});
            }
        },
        computed: {
            checkToken: function () {
              return this.$store.getters.checkToken;
            },
            url: function () {
                return window.location.href;
            }
        },
    }
</script>

