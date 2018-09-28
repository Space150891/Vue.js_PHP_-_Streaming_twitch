require('./bootstrap');
import VueRouter from 'vue-router'
import AdminStore from './components/admin/store/AdminStore.js';
// import VueTimepicker from 'vue2-timepicker';
window.Vue = require('vue');

const LoginPage = require('./components/admin/LoginPage.vue');
const ItemTypesPage = require('./components/admin/ItemTypesPage.vue');
const ItemsPage = require('./components/admin/ItemsPage.vue');
const RaritiesPage = require('./components/admin/RaritiesPage.vue');
const CaseTypesPage = require('./components/admin/CaseTypesPage.vue');
const CasesPage = require('./components/admin/CasesPage.vue');
const LogoutPage = require('./components/admin/LogoutPage.vue');
const StreamersPage = require('./components/admin/StreamersPage.vue');
const PromotedPage = require('./components/admin/PromotedPage.vue');
const MainStreamersPage = require('./components/admin/MainStreamersPage.vue');
const MainContentPage = require('./components/admin/MainContentPage.vue');
const AllUsersPage = require('./components/admin/AllUsersPage.vue');
const StockPrizesPage = require('./components/admin/StockPrizesPage.vue');
const DiamondsPage = require('./components/admin/DiamondsPage.vue');
const StatisticPage = require('./components/admin/StatisticPage.vue');
const CustomAchivementsPage = require('./components/admin/CustomAchivementsPage.vue');
const SubscriptionBonusPointsPage = require('./components/admin/SubscriptionBonusPointsPage.vue');
const AchievementPage = require('./components/admin/AchievementPage.vue');
const SubscriptionsPage = require('./components/admin/SubscriptionsPage.vue');

const router = new VueRouter({
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
        { path: '/users', component: AllUsersPage},
        { path: '/stock-prizes', component: StockPrizesPage},
        { path: '/diamonds', component: DiamondsPage},
        { path: '/statistic', component: StatisticPage},
        { path: '/custom-achivements', component: CustomAchivementsPage},
        { path: '/bonus-points', component: SubscriptionBonusPointsPage},
        { path: '/achievements', component: AchievementPage},
        { path: '/subscriptions', component: SubscriptionsPage},
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
