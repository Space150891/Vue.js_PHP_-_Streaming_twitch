import Vue from 'vue';
import Vuex from 'vuex';
var config = require('../admin/config.json');

Vue.use(Vuex);

const AdminStore = new Vuex.Store({
    state: {
        token: false,
        apiUrl : config.baseUrl + '/api/',
        itemTypes: [],
        rarities: [],
        items: [],
        caseTypes: [],
        cases: [],
        caseItems: [],
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
        // items
        getItemsList(state) {
            var formData = new FormData();

            formData.append('token', state.token);
            fetch(state.apiUrl + 'items/list',
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
                console.log('get list response');
                state.items = jsonResp.data ? jsonResp.data.items : [];
            });
        },
        async createItem(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('title', data.title);
            formData.append('item_type_id', data.item_type_id);
            formData.append('description', data.description);
            formData.append('worth', data.worth);
            if (data.image) {
                formData.append('image', data.image);
            }
            if (data.icon) {
                formData.append('icon', data.icon);
            }
            var res = await fetch(state.apiUrl + 'items/store',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            });
            console.log('get create response');
            var jsonResp = await res.json();
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
        },
        deleteItem(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'items/delete',
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
        saveItem(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', data.id);
            formData.append('title', data.title);
            formData.append('item_type_id', data.item_type_id);
            formData.append('description', data.description);
            formData.append('worth', data.worth);
            if (data.image) {
                formData.append('image', data.image);
            }
            if (data.icon) {
                formData.append('icon', data.icon);
            }
            fetch(state.apiUrl + 'items/update',
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
        // case types mutation
        getCaseTypesList(state) {
            var formData = new FormData();

            formData.append('token', state.token);
            fetch(state.apiUrl + 'cases/types/list',
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
                state.caseTypes = jsonResp.data ? jsonResp.data.caseTypes : [];
            });
        },
        createCaseType(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('name', data.name);
            formData.append('price', data.price);
            if (data.image) {
                formData.append('image', data.image);
            }
            fetch(state.apiUrl + 'cases/types/store',
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
        deleteCaseType(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'cases/types/delete',
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
        saveCaseType(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', data.id);
            formData.append('name', data.name);
            formData.append('price', data.price);
            if (data.image) {
                formData.append('image', data.image);
            }
            fetch(state.apiUrl + 'cases/types/update',
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
        // cases
        getCases(state) {
            var formData = new FormData();

            formData.append('token', state.token);
            fetch(state.apiUrl + 'cases/list',
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
                state.cases = jsonResp.data ? jsonResp.data.cases : [];
            });
        },
        createCase(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('name', data.name);
            formData.append('case_type_id', data.case_type_id);
            fetch(state.apiUrl + 'cases/store',
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
        deleteCase(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'cases/delete',
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
        saveCase(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', data.id);
            formData.append('name', data.name);
            formData.append('case_type_id', data.case_type_id);
            fetch(state.apiUrl + 'cases/update',
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
        // case items
        getCaseItems(state, CaseId) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', CaseId);
            fetch(state.apiUrl + 'cases/item/list',
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
                state.caseItems = jsonResp.data ? jsonResp.data.items : [];
            });
        },
        createCaseItem(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('item_id', data.item_id);
            formData.append('rarity_id', data.rarity_id);
            formData.append('case_id', data.case_id);
            fetch(state.apiUrl + 'cases/item/add',
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
        deleteCaseItem(state, id) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'cases/item/delete',
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
        clearCaseItems(state) {
            state.caseItems = [];
        }
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
        // rarities
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
        // items
        getItemsListAction(context) {
            context.commit('getItemsList');
            context.commit('getItemTypesList');
        },
        async createItemAction(context, data) {
            console.log('before create action');
            await context.commit('createItem', data);
            console.log('after create action');
            await context.commit('getItemsList');
            console.log('after get action');
        },
        async ItemDeleteAction(context, id) {
            await context.commit('deleteItem', id);
            await context.commit('getItemsList');
        },
        async ItemSaveAction(context, data) {
            await context.commit('saveItem', data);
            await context.commit('getItemsList');
        },
        // case types
        getCaseTypesListAction(context) {
            context.commit('getCaseTypesList');
        },
        createCaseTypeAction(context, data) {
            context.commit('createCaseType', data);
            context.commit('getCaseTypesList');
        },
        CaseTypeDeleteAction(context, id) {
            context.commit('deleteCaseType', id);
            context.commit('getCaseTypesList');
        },
        CaseTypeSaveAction(context, data) {
            context.commit('saveCaseType', data);
            context.commit('getCaseTypesList');
        },
        // cases
        CasesListAction(context) {
            context.commit('getCases');
            context.commit('getCaseTypesList');
        },
        CaseCreateAction(context, data) {
            context.commit('createCase', data);
            context.commit('getCases');
        },
        CaseDeleteAction(context, id) {
            context.commit('deleteCase', id);
            context.commit('getCases');
        },
        CaseSaveAction(context, data) {
            context.commit('saveCase', data);
            context.commit('getCases');
        },
        // case items
        CaseItemsListAction(context, id) {
            context.commit('getItemsList');
            context.commit('getRaritiesList');
            context.commit('getCaseItems', id); //
        },
        CaseItemCreateAction(context, data) {
            context.commit('createCaseItem', data); //
            context.commit('getCaseItems', data.case_id); //
        },
        CaseItemDeleteAction(context, id) {
            context.commit('deleteCaseItem', id);
            context.commit('getCaseItems', id);
        },
        CaseItemClear(context) {
            context.commit('clearCaseItems');
        }
    },
    getters : {
        checkToken: state => {
            return state.token ? true : false;
        },
        itemTypes: state => {
            return state.itemTypes;
        },
        rarities: state => {
            return state.rarities;
        },
        items: state => {
            return state.items;
        },
        caseTypes: state => {
            return state.caseTypes;
        },
        cases: state => {
            return state.cases;
        },
        caseItems: state => {
            return state.caseItems;
        },
    }
});

export default AdminStore;