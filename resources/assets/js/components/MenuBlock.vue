<template>
<div class="main-menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img class="nav-logo" src="../../../../public/images/logo.png" alt="logo"></a>
        <button @click.prevent="menuBurger()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div v-bind:class="['collapse navbar-collapse', (clicked) ? 'toggle-block' : '']" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0 menu-right-part">
                <li class="nav-item" v-for="(item, index) in menuItems">
                    <router-link
                        class="nav-link"
                        v-bind:to="item.link" 
                        v-bind:key="index"
                        v-on:click.native="menuLink()"
                    > 
                        {{ item.name }}
                    </router-link>
                </li>
            </ul>
            <a href="#" class="sign" v-if="checkToken" @click.prevent="signOut()">Sign out</a>
            <a href="twitch/redirect" class="sign" v-else >Sign up</a>

            <a href="#/cabinet" class="cabinet-but" v-if="checkToken">Cabinet</a>
            <a href="#/subscribe" class="cabinet-but" v-if="checkToken">Subscribe</a>
            <a href="#/afiliate" class="cabinet-but" v-if="checkToken">Afiliate</a>
            <ul class="navbar-nav my-2 my-lg-0 left" v-if="checkToken">
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/cash.svg" alt="cash"> {{currentViewer.points}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/diamond.svg" alt="diamond"> {{currentViewer.diamonds}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/arrows.svg" alt="arrows">{{currentViewer.level}}</a>
                </li>
                <li class="nav-item tagging">
                    <a @click.prevent="showMessages()" href="#" class="nav-link bag-span">
                            <img class="nav-icon" src="../../../../public/images/bag.svg" alt="bag">
                    </a>
                    <span class="tagging-item" v-if="menuEvents.total > 0">{{menuEvents.total}}</span>
                    <ul v-if="messagesVisible" class="menu-message-list">
                        <li v-for="menuEvent in menuEvents.list">
                            {{menuEvent.message}}
                        </li>
                        <li v-if="menuEvents.total > 3" class="text-center">
                            <a href="#/notifications">
                                View all
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item tagging social">
                    <a class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/google-plus.svg" alt="google-plus" target="_blank"></a>
                    <a @click="sendTWAchivement()" class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/twitter.svg" alt="twitter" target="_blank"></a>
                    <a @click="sendFBAchivement()" class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/facebook.svg" alt="facebook" target="_blank"></a>
                </li>
            </ul>
        </div>
    </nav>
</div>
</template>

<script>
    export default {
        data(){
            return {
                clicked: false,
                bagPage: "/bag",
                menuItems: [
                    {
                        name: "Home",
                        activ: true,
                        link: "/",
                    },
                    {
                        name: "Directory",
                        activ: false,
                        link: "/directory",
                    },
                    {
                        name: "Prices",
                        activ: false,
                        link: "/prices",
                    },
                ],
                messagesVisible : false,
            }
        },
        computed: {
            checkToken: function() {
              return this.$store.getters.checkToken;
            },
            currentViewer: function() {
                return this.$store.getters.currentViewer;
            },
            menuEvents: function() {
                const allEvents = this.$store.getters.sseMenuEvents.reverse();
                let sortedEvents = [];
                let total = 0;
                for (let i=0; i<allEvents.length; i++) {
                    if (allEvents[i].event_type === 'user_message') {
                        total++;
                        if (sortedEvents.length < 3) {
                            sortedEvents.push(allEvents[i]);
                        }
                    }
                }
                return {
                    list : sortedEvents,
                    total : total
                    };
            }
        },
        mounted: function () {
            this.$store.commit('signUp');
            this.$store.commit('loadCurrentViewer');
        },
        methods: {
            menuBurger() {
                this.clicked = !this.clicked
            },
            menuLink() {
                (this.clicked) ? this.clicked = !this.clicked : this.clicked = this.clicked ;
            },
            signOut() {
                this.$store.commit('signOut');
            },
            showMessages() {
                this.messagesVisible = true;
                setTimeout(() => {
                    this.$store.commit('clearMenuEvents');
                    this.messagesVisible = false;
                }, 2000);
            },
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
        }
    }
</script>
<style lang="scss">
    body {
        height: 100vh;
        max-height: 100vh;
    }
    
    .main-menu {
        position: fixed;
        top: 22px;
        width: 100vw;
        height: auto;
        z-index: 10000;
    }
    .navbar {
        padding-top: 5px;
        height: 88px;
    }
    .left {
        margin-right: 20px;
    }
    .menu-right-part {
        margin-bottom: 4px;
    }
    .nav-logo {
        width: 4vw;
    }
    .sign {
        margin-bottom: 19px;
        padding: 6px 12px;
        background: #6441a4;
        font-size: 18px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        &:hover {
            background: #3f148c;
            text-decoration: none;
            color: white;
        }
        &:active {
            border-radius: 10px;
            transition: 0.2s;
        }
    }
    .cabinet-but {
        margin: 0 0 19px 10px;
        padding: 6px 12px;
        background: #6441a4;
        font-size: 18px;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        &:hover {
            background: #3f148c;
            text-decoration: none;
            color: white;
        }
        &:active {
            border-radius: 10px;
            transition: 0.2s;
        }
    }
    .sign-none {
        display: none;
    }
    .social {
        display: none;
    }
    .nav-icon {
        width: 1vw;
        min-width: 20px;
        margin: 0 10px 0 20px;
    }
    .tagging-item {
        background-color: red;
        padding: 0 8px 2px 8px;
        border-radius: 7px;
        color: #f7f7f7;
        font-weight: 600;
        position: relative;
        top: -51px;
        right: -39px;
    }
    .router-link-exact-active {
        background-color: #d2d2d2ed;
    }
    .tagging {
        position: relative;
    }
    .toggle-block {
        display: block !important;
        position: absolute;
        width: 250px;
        height: 100vh;
        top: 50px;
        right: -15px;
        background: #f1f1f1;
        text-align: center;
        font-size: 18px;
        z-index: 10;
        animation-name: slideLeft;
        -webkit-animation-name: slideLeft;  
        animation-duration: 0.5s; 
        -webkit-animation-duration: 0.5s;
        animation-timing-function: ease-in-out; 
        -webkit-animation-timing-function: ease-in-out;
        .left {
            text-align: left;
            margin-left: 30%;
        }
        .tagging-item {
            position: absolute;
            top: 275px;
            right: 115px;
            font-size: 13px;
            padding: 1px 8px 1px 8px;
        }
        .social {
            display: flex;
            justify-content: space-around;
            margin-left: -40%;
            margin-top: 20%;
            img {
                width: 50%;
            }
        }
    }
    .navbar-toggler{
        height: 30px;
        width: 38px;
        position: relative;
        .navbar-toggler-icon {
            background-size: 90% 90%;
            position: absolute;
            top: 1px;
            right: 5px;
        }
    }
    .bag-span {
        width: 78px;
        &:hover {
            background-color: #eaeaea;
        }
    }

    .menu-message-list {
        position: absolute;
        padding: 0 5px;
        top: 45px;
        right: 5px;
        >li {
            list-style: none;
            width : 250px;
            border: 1px #333 solid;
            border-top: none;
            background: #fff;
            color: #aaa;
            &:first-of-type {
                border-top: 1px #333 solid;
            }
        }
    }
         
    @keyframes slideLeft {
        0% {
            transform: translateX(150%);
        }
        100% {
            transform: translateX(0%);
        }
    }
    
    @-webkit-keyframes slideLeft {
        0% {
            -webkit-transform: translateX(150%);
        }
        100% {
            -webkit-transform: translateX(0%);
        }
    }
    @media screen and (max-width: 991px)  {
        .toggle-block {
            font-size: 16px;
            .tagging-item {
                top: -6px;
                right: 99px;
                font-size: 11px;
            }
        }
        .navbar {
            height: 50px;
        }
        .navbar-toggler {
            margin-right: 10px;
        }
        .toggle-block {
            .social {
                margin-top: 20%;
                position: relative;
                right: 11px;
                img {
                    width: 35%;
                }
            }
        }
        
    }
   
    @media screen and (max-width: 969px)  {
        .toggle-block {
            font-size: 16px;
            .tagging-item {
                top: -5px;
                right: 98px;
                font-size: 11px;
            }
        }
    }
    @media screen and (max-width: 750px)  {
        .toggle-block {
            font-size: 14px;
            .tagging-item {
                top: -8px;
                right: 98px;
                font-size: 11px;
            }
        }
        .navbar-nav {
            margin-bottom: 27px;
        }
        .nav-logo {
            width: 45px;
        }
        .social img {
            width: 40%;
        }
    }
    
    @media (max-height: 520px)  {
        .toggle-block {
            width: 200px;
            .left{
                display: flex;
                flex-direction: row;
                text-align: center;
                margin-left: 7px;
                margin-top: 9% !important;
                li {
                    a {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        margin-right: 10px;
                        font-size: 15px;
                            .nav-icon {
                                margin: 0px 5px 0 5px;
                            }
                    }
                }
            }
            .tagging-item {
                top: -11px;
                right: 74px;
            }
            .social {
                bottom: -12px;
                right: 125px;
                .social-link {
                    width: 35px;
                }
                .nav-icon {
                    width: 30px;
                }
            }
        }
        .navbar-nav {
            margin: 0;
        }
        .sign {
            display: block;
            font-size: 14px;
        }
    }
</style>

