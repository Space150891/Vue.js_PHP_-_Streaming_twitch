
require('./bootstrap');
import VueRouter from 'vue-router'
import AdminStore from './components/store/AdminStore.js';
window.Vue = require('vue');

var LoginPage = require('./components/admin/LoginPage.vue');
var ItemTypesPage = require('./components/admin/ItemTypesPage.vue');

var router = new VueRouter({
    routes: [
        { path: '/', component: LoginPage },
        { path: '/login', component: LoginPage },
        { path: '/item-types', component: ItemTypesPage },
    ]
});
Vue.use(VueRouter);

Vue.component('admin-menu', require('./components/admin/AdminMenu.vue'));


const app = new Vue({
    el: '#admin-app',
    router: router,
    store: AdminStore,
    mounted () {
        
    },
});
