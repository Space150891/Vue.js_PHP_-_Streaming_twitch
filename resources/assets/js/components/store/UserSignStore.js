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
            paypal: null,
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
        myStreamers: {
            list: [],
            loaded: false,
        },
        myViewers: {
            list: [],
            loaded: false,
        },
        afiliates: {
            visited: 0,
            registered: 0,
            total: 0,
        },
        games: {
            list: [],
            loaded: false,
        },
        streamers: {
            list: [],
            loaded: false,
        },
        afiliateLink: '',
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
        loadProfile(state, id = 0) {
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
        loadMyStreamers(state){
            state.myStreamers.list = [];
            state.myStreamers.loaded = false;
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/signedviewers/mystreamers/list',
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
                        state.myStreamers.list = jsonResp.data.streamers;
                        state.myStreamers.loaded = true;
                    }
                });
            }
        },
        loadMyViewers(state){
            state.myViewers.list = [];
            state.myViewers.loaded = false;
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/signedviewers/myviewers/list',
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
                        state.myViewers.list = jsonResp.data.viewers;
                        state.myViewers.loaded = true;
                    }
                });
            }
        },
        removeMyStreamer(state, id){
            state.myStreamers.list = [];
            state.myStreamers.loaded = false;
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                formData.append('id', id);
                fetch('api/signedviewers/delete',
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
                    }
                });
            }
        },
        getAfiliatedList(state){
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/afiliates/mylist',
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
                        state.afiliates = jsonResp.data;
                    }
                });
            }
        },
        getAfiliatedLink(state){
            state.afiliateLink = '';
            if (state.token) {
                var formData = new FormData();
                formData.append('token', state.token);
                fetch('api/afiliates/mylink',
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
                        state.afiliateLink = jsonResp.data;
                    }
                });
            }
        },
        loadGames(state){
            state.games.loaded = false;
            fetch('api/games/list',
            {
                method: "POST",
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                if (!jsonResp.errors) {
                    state.games.loaded = true;
                    state.games.list = jsonResp.data.games;
                }
            });
        },
        loadStreamersByGame(state, gameGame) {
            state.streamers.loaded = false;
            var formData = new FormData();
            formData.append('game_name', gameGame);
            fetch('api/streamers/bygamename',
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
                if (!jsonResp.errors) {
                    state.streamers.loaded = true;
                    state.streamers.list = jsonResp.data.streamers;
                }
            });
        },
        flashStreamers(state) {
            state.streamers.loaded = false;
            state.streamers.list = [];
        }
    },
    actions: {
        getSubscribeData(context) {
            context.commit('loadCurrentStreamer');
            context.commit('getSubscriptionPlansList');
            context.commit('getMonthPlansList');
        },
        removeMyStreamer(context, id) {
            context.commit('removeMyStreamer', id);
            setTimeout(() => {
                context.commit('loadMyStreamers');
            }, 2000);
        },
        loadAfiliated(context) {
            context.commit('getAfiliatedList');
            context.commit('loadProfile');
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
        myStreamers: state => {
            return state.myStreamers.list;
        },
        myViewers: state => {
            return state.myViewers.list;
        },
        afiliates: state => {
            return state.afiliates;
        },
        afiliateLink: state => {
            return state.afiliateLink;
        },
        games: state => {
            return state.games.list;
        },
        streamers: state => {
            return state.streamers.list;
        },
        streamersLoaded: state => {
            return state.streamers.loaded;
        },
    },

});

export default UserSignStore;