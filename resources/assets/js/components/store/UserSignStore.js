import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const UserSignStore = new Vuex.Store({
    state: {
        token: false,
        currentViewer: {
            diamonds: 0,
            points: 0,
            level: 0,
        },
        currentStreamer: {
            id: 0,
        },
        message: "",
        profileData: {
            avatar : null,
            username: null,
            nickname: null,
            email: null,
            bio: null,
        },
        promotedStreamers: {
            list: [],
            loaded: false,
        },
        subscriptionPlans: {
            list: [],
            loaded: false,
        },
        monthPlans: {
            list: [],
            loaded: false,
        },
    },
    mutations: {
        signUp(state) {
            state.token = localStorage.getItem("userToken");
        },
        loadCurrentViewer(state) {
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/viewers/current',
                {
                    method: "POST",
                    body: formData,
                    credentials: 'omit',
                    mode: 'cors',
                })
                .then(function(res){
                    return res.json();
                })
                .then(function(jsonResp){
                    if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                        state.token = false;
                    } else {
                        state.currentViewer = jsonResp.data;
                    }
                });
            }
        },
        signOut(state) {
            var formData = new FormData();
            formData.append('token', state.token);
            
            fetch('api/auth/logout',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                delete localStorage["userToken"];
                state.token = false;
                state.message = jsonResp.message;
            });
        },
        loadProfile(state, id) {
            var formData = new FormData();
            var url = 'api/profile/current';
            if (id > 0) {
                formData.append('id', id);
                url = 'api/profile/get';
            } else {
                formData.append('token', state.token);
            }
            fetch(url,
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                } else {
                    state.profileData = jsonResp.data;
                }
            });
        },
        getPromotedList(state) {
            var formData = new FormData();
            state.promotedStreamers.loaded = false;
            formData.append('token', state.token);
            fetch('api/streamers/promoted/list',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                state.promotedStreamers.list = jsonResp.data ? jsonResp.data.promoted : [];
                state.promotedStreamers.loaded = true;
            });
        },
        getSubscriptionPlansList(state) {
            var formData = new FormData();
            state.subscriptionPlans.loaded = false;
            formData.append('token', state.token);
            fetch('api/subscriptionplans/list',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                state.subscriptionPlans.list = jsonResp.data ? jsonResp.data.subscription_plans : [];
                state.subscriptionPlans.loaded = true;
            });
        },
        getMonthPlansList(state) {
            var formData = new FormData();
            state.monthPlans.loaded = false;
            formData.append('token', state.token);
            fetch('api/monthplans/list',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                state.monthPlans.list = jsonResp.data ? jsonResp.data.month_plans : [];
                state.monthPlans.loaded = true;
            });
        },
        loadCurrentStreamer(state) {
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/streamers/current',
                {
                    method: "POST",
                    body: formData,
                    credentials: 'omit',
                    mode: 'cors',
                })
                .then(function(res){
                    return res.json();
                })
                .then(function(jsonResp){
                    if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                        state.token = false;
                    } else {
                        state.currentStreamer = jsonResp.data;
                    }
                });
            }
        },
    },
    actions: {
        getSubscribeData(context) {
            context.commit('loadCurrentStreamer');
            context.commit('getSubscriptionPlansList');
            context.commit('getMonthPlansList');
        },
    },
    getters : {
        checkToken: state => {
            return state.token ? true : false;
        },
        profileData: state => {
            return state.profileData;
        },
        promotedStreamers: state => {
            return state.promotedStreamers.list;
        },
        promotedLoaded: state => {
            return state.promotedStreamers.loaded;
        },
        currentViewer: state => {
            return state.currentViewer;
        },
        subscriptionPlans: state => {
            return state.subscriptionPlans.list;
        },
        monthPlans: state => {
            return state.monthPlans.list;
        },
        currentStreamer: state => {
            return state.currentStreamer;
        },
    },

});

export default UserSignStore;