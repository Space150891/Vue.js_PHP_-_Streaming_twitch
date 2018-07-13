
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('hideshowpassword');
var password = require('password-strength-meter');

import VueRouter from 'vue-router';
import UserSignStore from './components/store/UserSignStore.js';

import VuePaginate from 'vue-paginate';
Vue.use(VuePaginate);

window.Vue = require('vue');
var Home = require('./components/Home.vue');
var Directory = require('./components/Directory.vue');
var Price = require('./components/Price.vue');
var Bag = require('./components/Bag.vue');
var Cabinet = require('./components/CabinetPage.vue');
var Subscribe = require('./components/SubscribePage.vue');
var MyStreamers = require('./components/MyStreamersPage.vue');
var MyViewers = require('./components/MyViewersPage.vue');
var Afiliate = require('./components/AfiliatePage.vue');

var router = new VueRouter({
    routes: [
        { path: '/', component: Home },
        { path: '/directory', component: Directory },
        { path: '/prices', component: Price },
        { path: '/bag', component: Bag },
        { path: '/cabinet', component: Cabinet},
        { path: '/profile/:userId', component: Cabinet,  props: true },
        { path: '/subscribe', component: Subscribe},
        { path: '/mystreamers', component: MyStreamers},
        { path: '/myviewers', component: MyViewers},
        { path: '/afiliate', component: Afiliate},
    ]
});
Vue.use(VueRouter);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('users-count', require('./components/UsersCount.vue'));
Vue.component('chat-tabs', require('./components/StreamChatTabsComponent.vue'));
Vue.component('menu-block', require('./components/MenuBlock.vue'));
Vue.component('left-part', require('./components/LeftPart.vue'));
Vue.component('right-part', require('./components/RighrPart.vue'));
Vue.component('midle-part-home', require('./components/MidlePartHome.vue'));
Vue.component('midle-part-price', require('./components/MidlePricesPart.vue'));
Vue.component('midle-part-directory', require('./components/MidleDirectoryPart.vue'));
Vue.component('midle-part-bag', require('./components/MidleBagPart.vue'));
Vue.component('video-part', require('./components/VideoPart.vue'));
Vue.component('up-nav', require('./components/UpNav.vue'));
Vue.component('footer-part', require('./components/FooretPart.vue'));


const app = new Vue({
    el: '#app',
    router: router,
    store: UserSignStore
});
