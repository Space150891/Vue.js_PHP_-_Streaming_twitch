import Vue from 'vue';
import Vuex from 'vuex';
var config = require('../admin/config.json');

Vue.use(Vuex);

const AdminStore = new Vuex.Store({
    state: {
        token: false,
        apiUrl : config.baseUrl + '/api/',
        itemTypes: {
            list: [],
            loaded: false,
        },
        rarities: {
            list: [],
            loaded: false,
        },
        items: {
            list: [],
            loaded: false,
            saved : true,
        },
        caseTypes: {
            list: [],
            loaded: false,
            saved : true,
        },
        cases: {
            list: [],
            loaded: false,
        },
        caseItems: {
            list: [],
            loaded: false,
        },
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
            state.itemTypes.loaded = false;
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
                state.itemTypes.list = jsonResp.data ? jsonResp.data.item_types : [];
                state.itemTypes.loaded = true;
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
            state.rarities.loaded = false;
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
                state.rarities.list = jsonResp.data ? jsonResp.data.rarities : [];
                state.rarities.loaded = true;
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
            state.items.loaded = false;
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
                state.items.list = jsonResp.data ? jsonResp.data.items : [];
                state.items.loaded = true;
            });
        },
        createItem(state, data) {
            var formData = new FormData();
            state.items.saved = false;
            state.items.loaded = false;
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
            fetch(state.apiUrl + 'items/store',
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
                state.items.saved = true;
            });
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
            console.log('start loading');
            var formData = new FormData();
            state.caseTypes.loaded = false;
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
                state.caseTypes.list = jsonResp.data ? jsonResp.data.caseTypes : [];
                state.caseTypes.loaded = true;
                console.log('end loading');
            });
        },
        createCaseType(state, data) {
            console.log('start saving');
            var formData = new FormData();
            state.caseTypes.saved = false;
            state.caseTypes.loaded = false;
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
                console.log(res);
                return res.json();
            })
            .then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                }
                console.log('end saving');
                state.caseTypes.saved = true;
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
            state.cases.loaded = false;
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
                state.cases.list = jsonResp.data ? jsonResp.data.cases : [];
                state.cases.loaded = true;
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
            state.caseItems.loaded = false;
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
                state.caseItems.list = jsonResp.data ? jsonResp.data.items : [];
                state.caseItems.loaded = true;
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
            state.caseItems.list = [];
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
        createItemAction(context, data) {
            context.commit('createItem', data);
            setTimeout(() => {
                context.commit('getItemsList');
              }, config.timeOut);
        },
        ItemDeleteAction(context, id) {
            context.commit('deleteItem', id);
            context.commit('getItemsList');
        },
        ItemSaveAction(context, data) {
            context.commit('saveItem', data);
            setTimeout(() => {
                context.commit('getItemsList');
              }, config.timeOut);
        },
        // case types
        getCaseTypesListAction(context) {
            context.commit('getCaseTypesList');
        },
        createCaseTypeAction(context, data) {
            context.commit('createCaseType', data);
        },
        CaseTypeDeleteAction(context, id) {
            context.commit('deleteCaseType', id);
            context.commit('getCaseTypesList');
        },
        CaseTypeSaveAction(context, data) {
            context.commit('saveCaseType', data);
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
            return state.itemTypes.list;
        },
        rarities: state => {
            return state.rarities.list;
        },
        items: state => {
            return state.items.list;
        },
        caseTypes: state => {
            return state.caseTypes.list;
        },
        cases: state => {
            return state.cases.list;
        },
        caseItems: state => {
            return state.caseItems.list;
        },
        itemTypesLoaded: state => {
            return state.itemTypes.loaded;
        },
        raritiesLoaded: state => {
            return state.rarities.loaded;
        },
        itemsLoaded: state => {
            return state.items.loaded;
        },
        caseTypesLoaded: state => {
            return state.caseTypes.loaded;
        },
        casesLoaded: state => {
            return state.cases.loaded;
        },
        caseItemsLoaded: state => {
            return state.caseItems.loaded;
        },
        caseTypesSaved: state => {
            return state.caseTypes.saved;
        },
        itemsSaved: state => {
            return state.items.saved;
        },
    }
});

export default AdminStore;