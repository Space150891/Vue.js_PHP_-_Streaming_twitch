
require('./bootstrap');
import VueRouter from 'vue-router'
import AdminStore from './components/store/AdminStore.js';
window.Vue = require('vue');

var LoginPage = require('./components/admin/LoginPage.vue');
var ItemTypesPage = require('./components/admin/ItemTypesPage.vue');
var ItemsPage = require('./components/admin/ItemsPage.vue');
var RaritiesPage = require('./components/admin/RaritiesPage.vue');
var CaseTypesPage = require('./components/admin/CaseTypesPage.vue');

var router = new VueRouter({
    routes: [
        { path: '/', component: LoginPage },
        { path: '/login', component: LoginPage },
        { path: '/item-types', component: ItemTypesPage },
        { path: '/rarities', component: RaritiesPage },
        { path: '/items', component: ItemsPage },
        { path: '/case-types', component: CaseTypesPage },
    ]
});
Vue.use(VueRouter);

Vue.component('admin-menu', require('./components/admin/AdminMenu.vue'));
Vue.component('modal-delete', require('./components/admin/ConfirmDelete.vue'));
Vue.component('modal-alert', require('./components/admin/AlertModal.vue'));
Vue.component('upload-image', require('./components/admin/UploadImage.vue'));

const app = new Vue({
    el: '#admin-app',
    router: router,
    store: AdminStore,
    mounted () {

    },
});
