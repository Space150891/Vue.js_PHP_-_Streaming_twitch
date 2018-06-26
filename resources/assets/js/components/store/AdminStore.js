import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const AdminStore = new Vuex.Store({
    state: {
        token: false,
        apiUrl : 'http://localhost:8000/api/',
        itemTypes: [],
        rarities: [],
    },
    mutations: {
        authWithToken(state, data) {
            var formData = new FormData();

            formData.append('email', data.email);
            formData.append('password', data.password);

            fetch(state.apiUrl + 'auth/login',
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
                state.token = jsonResp.access_token ? jsonResp.access_token : false;
            });
        },
        getItemTypesList(state) {
            var formData = new FormData();

            formData.append('token', state.token);
            fetch(state.apiUrl + 'itemtypes/list',
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
                state.itemTypes = jsonResp.data ? jsonResp.data.item_types : [];
            });
        },
        createItemType(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('name', data.name);
            fetch(state.apiUrl + 'itemtypes/store',
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
        },
        deleteItemType(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'itemtypes/delete',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            }).then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                }
            });
        },
        saveItemType(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', data.id);
            formData.append('name', data.name);
            fetch(state.apiUrl + 'itemtypes/update',
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
        },
        ////
        getRaritiesList(state) {
            var formData = new FormData();

            formData.append('token', state.token);
            fetch(state.apiUrl + 'rarities/list',
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
                state.rarities = jsonResp.data ? jsonResp.data.rarities : [];
            });
        },
        createRarity(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('name', data.name);
            formData.append('percent', data.percent);
            fetch(state.apiUrl + 'rarities/store',
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
        },
        deleteRarity(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'rarities/delete',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            }).then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                }
            });
        },
        saveRarity(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', data.id);
            formData.append('name', data.name);
            formData.append('percent', data.percent);
            fetch(state.apiUrl + 'rarities/update',
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
        },
    },
    actions: {
        getItemTypesListAction(context) {
            context.commit('getItemTypesList');
        },
        createItemTypeAction(context, data) {
            context.commit('createItemType', data);
            context.commit('getItemTypesList');
        },
        ItemTypeDeleteAction(context, id) {
            context.commit('deleteItemType', id);
            context.commit('getItemTypesList');
        },
        ItemTypeSaveAction(context, data) {
            context.commit('saveItemType', data);
            context.commit('getItemTypesList');
        },
        getRaritiesListAction(context) {
            context.commit('getRaritiesList');
        },
        createRarityAction(context, data) {
            context.commit('createRarity', data);
            context.commit('getRaritiesList');
        },
        RarityDeleteAction(context, id) {
            context.commit('deleteRarity', id);
            context.commit('getRaritiesList');
        },
        RaritySaveAction(context, data) {
            context.commit('saveRarity', data);
            context.commit('getRaritiesList');
        },
    },
    getters : {
        checkToken: state => {
            return state.token ? true : false;
        },
        itemTypes: state => {
            return state.itemTypes;
        },
        Rarities: state => {
            return state.rarities;
        },
    }
});

export default AdminStore;