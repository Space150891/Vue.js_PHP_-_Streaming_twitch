<template>
<div class="main-menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img class="nav-logo" src="../../../../public/images/logo.png" alt="logo"></a>
        <button @click.prevent="menuBurger()" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div v-bind:class="['collapse navbar-collapse', (clicked) ? 'toggle-block' : '']" id="navbarTogglerDemo01">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item" v-for="(item, index) in menuItems">
                    <router-link
                        class="nav-link"
                        v-bind:to="item.link" 
                        v-bind:key="index"
                    > 
                        {{ item.name }}
                    </router-link>
                </li>
            </ul>
            <a href="twitch/redirect"  class="sing-up">Sign up</a>
            <ul class="navbar-nav my-2 my-lg-0 left">
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/cash.svg" alt="cash"> 5,000</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/diamond.svg" alt="diamond"> 100</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><img class="nav-icon" src="../../../../public/images/arrows.svg" alt="arrows">0</a>
                </li>
                <li class="nav-item tagging">
                    <router-link 
                        class="nav-link bag-span"
                        v-bind:to="bagPage"
                        >
                            <img class="nav-icon" src="../../../../public/images/bag.svg" alt="bag">
                    </router-link>
                    <span class="tagging-item">2</span>
                </li>
                <li class="nav-item tagging social">
                    <a class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/google-plus.svg" alt="google-plus"></a>
                    <a class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/twitter.svg" alt="twitter"></a>
                    <a class="nav-link social-link" href="#"><img class="nav-icon" src="../../../../public/images/facebook.svg" alt="facebook"></a>
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
                selected: 0,
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
                ]
            }
        },
        methods: {
            setSelected(index) {
                this.selected = index;
            },
            menuBurger() {
                this.clicked = !this.clicked
           },
           authentication() {
                window.Twich = Twitch.init({
                    clientId: 'leh3fb6zxnnb4n3jtziooi0qrygx2e',
                    redirect_uri: 'http://127.0.0.1:8000/'
                }, function(error, status) {
                    console.log('the library is now loaded')
                });
                window.Twitch.login({
                    redirect_uri: 'http://127.0.0.1:8000/',
                    scope: ['user_read', 'channel_read']
                })
           }
        },
        
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
    .nav-logo {
        width: 4vw;
    }
    .sing-up {
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
        .sing-up {
            font-size: 14px;
        }
    }
</style>

