
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('hideshowpassword');
const password = require('password-strength-meter');

import VueRouter from 'vue-router';
import UserSignStore from './components/store/UserSignStore.js';
// import VueGrecaptcha from 'vue-grecaptcha';

import VuePaginate from 'vue-paginate';
Vue.use(VuePaginate);

window.Vue = require('vue');
const Home = require('./components/Home.vue');
const Directory = require('./components/Directory.vue');
const Price = require('./components/Price.vue');
const Bag = require('./components/Bag.vue');
const Cabinet = require('./components/CabinetPage.vue');
const Subscribe = require('./components/SubscribePage.vue');
const MyStreamers = require('./components/MyStreamersPage.vue');
const MyViewers = require('./components/MyViewersPage.vue');
const Afiliate = require('./components/AfiliatePage.vue');
const Notifications = require('./components/NotificationsPage.vue');
const Achivements = require('./components/AchivementsPage.vue');
const Donate = require('./components/DonatePage.vue');
const WatchingStreamsPage = require('./components/WatchingStreamsPage.vue');
const MyCardsPage = require('./components/MyCardsPage.vue');
const RoulettePage = require('./components/RoulettePage.vue');
const ShopPage = require('./components/ShopPage.vue');
const CustomizeDonatePage = require('./components/CustomizeDonatePage.vue');
const CustomAchivementsPage = require('./components/CustomAchivementsPage.vue');

const router = new VueRouter({
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
        { path: '/notifications', component: Notifications},
        { path: '/achivements', component: Achivements},
        { path: '/donate/:userId', component: Donate,  props: true },
        { path: '/watch-streams', component: WatchingStreamsPage},
        { path: '/mycards', component: MyCardsPage},
        { path: '/roulette', component: RoulettePage},
        { path: '/shop', component: ShopPage},
        { path: '/custom-donate', component: CustomizeDonatePage},
        { path: '/custom-achivements', component: CustomAchivementsPage},
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
Vue.component('chat-part', require('./components/StreamChatTabs.vue'));
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
Vue.component('stream-frame', require('./components/WatchStreamPart.vue'))
Vue.component('drop-down', require('./components/DropDown.vue'))
Vue.component('follow-drop-down', require('./components/FollowDropDown.vue'))
Vue.component('modal-alert', require('./components/admin/AlertModal.vue'));
Vue.component('viewer-card', require('./components/Card.vue'));
Vue.component('modal-delete', require('./components/admin/ConfirmDelete.vue'));
Vue.component('modal-confirm', require('./components/ConfirmModal.vue'));
Vue.component('inline-alert', require('./components/AlertInline.vue'));

const app = new Vue({
    el: '#app',
    router: router,
    store: UserSignStore
});
