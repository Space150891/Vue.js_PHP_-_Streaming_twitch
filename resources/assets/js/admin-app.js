require('./bootstrap');
import VueRouter from 'vue-router'
import AdminStore from './components/store/AdminStore.js';
// import VueTimepicker from 'vue2-timepicker';
window.Vue = require('vue');

var LoginPage = require('./components/admin/LoginPage.vue');
var ItemTypesPage = require('./components/admin/ItemTypesPage.vue');
var ItemsPage = require('./components/admin/ItemsPage.vue');
var RaritiesPage = require('./components/admin/RaritiesPage.vue');
var CaseTypesPage = require('./components/admin/CaseTypesPage.vue');
var CasesPage = require('./components/admin/CasesPage.vue');
var LogoutPage = require('./components/admin/LogoutPage.vue');
var StreamersPage = require('./components/admin/StreamersPage.vue');
var PromotedPage = require('./components/admin/PromotedPage.vue');
var MainStreamersPage = require('./components/admin/MainStreamersPage.vue');
var MainContentPage = require('./components/admin/MainContentPage.vue');
// var EmailPage = require('./components/admin/EmailPage.vue');

var router = new VueRouter({
    routes: [
        { path: '/', component: LoginPage },
        { path: '/login', component: LoginPage },
        { path: '/item-types', component: ItemTypesPage },
        { path: '/rarities', component: RaritiesPage },
        { path: '/items', component: ItemsPage },
        { path: '/case-types', component: CaseTypesPage },
        { path: '/cases', component: CasesPage },
        { path: '/logout', component: LogoutPage },
        { path: '/streamers', component: StreamersPage },
        { path: '/promoted', component: PromotedPage },
        { path: '/main-streamers', component: MainStreamersPage },
        { path: '/main-content', component: MainContentPage },
        // { path: '/email', component: EmailPage },
    ]
});
Vue.use(VueRouter);

Vue.component('admin-menu', require('./components/admin/AdminMenu.vue'));
Vue.component('modal-delete', require('./components/admin/ConfirmDelete.vue'));
Vue.component('modal-alert', require('./components/admin/AlertModal.vue'));
Vue.component('inline-alert', require('./components/admin/AlertInline.vue'));
Vue.component('upload-image', require('./components/admin/UploadImage.vue'));
Vue.component('case-items', require('./components/admin/CasesItemsList.vue'));
Vue.component('pagination', require('./components/admin/pagination.vue'));
Vue.component('vue-timepicker', require('vue2-timepicker'));

const app = new Vue({
    el: '#admin-app',
    router: router,
    store: AdminStore,
    mounted () {

    },
});
