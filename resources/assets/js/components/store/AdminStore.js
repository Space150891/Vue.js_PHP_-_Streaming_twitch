import Vue from 'vue';
import Vuex from 'vuex';
var config = require('../config/config.json');

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
        sseMessages : [],
        streamers: {
            list: [],
            loaded: false,
            saved : true,
            pages: 1,
        },
        promotedStreamers: {
            list: [],
            loaded: false,
            saved : true,
        },
        mainStreamers: {
            list: [],
            loaded: false,
            saved : true,
        },
        mainContent: {
            list: [],
            loaded: false,
        },
        alerts: [],
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
                if (jsonResp.access_token) {
                    state.token = jsonResp.access_token;
                    document.cookie = "token=" + jsonResp.access_token;
                } else {
                    state.token = false;
                }
                
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
            });
        },
        createCaseType(state, data) {
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
                return res.json();
            })
            .then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                }
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
        },
        logout(state) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch(state.apiUrl + 'auth/logout',
            {
                method: "POST",
                body: formData,
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            }).then(function(jsonResp){
                state.token = false;
            });
        },
        deleteMessage(state, index) {
            state.sseMessages.splice(index, 1);
        },
        // streamers
        getStreamersList(state) {
            var formData = new FormData();
            state.streamers.loaded = false;
            formData.append('token', state.token);
            fetch(state.apiUrl + 'streamers/list',
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
                state.streamers.list = jsonResp.data ? jsonResp.data.streamers : [];
                state.streamers.loaded = true;
            });
        },
        getPaggStreamersList(state, data) {
            var formData = new FormData();
            state.streamers.loaded = false;
            formData.append('token', state.token);
            formData.append('page', data.page);
            formData.append('on_page', data.onPage);
            fetch(state.apiUrl + 'streamers/list/pagg',
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
                console.log(jsonResp.data);
                state.streamers.list = jsonResp.data ? jsonResp.data.streamers : [];
                state.streamers.pages = jsonResp.data ? jsonResp.data.pages : 1;
                state.streamers.loaded = true;
            });
        },
        getPromotedList(state) {
            var formData = new FormData();
            state.promotedStreamers.loaded = false;
            formData.append('token', state.token);
            fetch(state.apiUrl + 'streamers/promoted/list',
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
                state.promotedStreamers.list = jsonResp.data ? jsonResp.data.promoted : [];
                state.promotedStreamers.loaded = true;
            });
        },
        addPromoted(state, id) {
            state.promotedStreamers.loaded = false;
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'streamers/promoted/add',
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
        deletePromoted(state, id) {
            state.promotedStreamers.loaded = false;
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'streamers/promoted/delete',
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
        upPromoted(state, id) {
            state.promotedStreamers.loaded = false;
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'streamers/promoted/up',
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
        downPromoted(state, id) {
            state.promotedStreamers.loaded = false;
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'streamers/promoted/down',
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
        // main streamers
        getMainStreamersList(state) {
            var formData = new FormData();
            state.mainStreamers.loaded = false;
            formData.append('token', state.token);
            fetch(state.apiUrl + 'streamers/main/list',
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
                state.mainStreamers.list = jsonResp.data ? jsonResp.data.main_streamers : [];
                state.mainStreamers.loaded = true;
            });
        },
        addMainStreamer(state, item) {
            var formData = new FormData();
            state.mainStreamers.loaded = false;
            formData.append('token', state.token);
            formData.append('promouted_id', item.promouted_id);
            formData.append('promouted_start', item.promouted_start.HH + ':' + item.promouted_start.mm + ':00');
            formData.append('promouted_end', item.promouted_end.HH + ':' + item.promouted_end.mm + ':00');
            fetch(state.apiUrl + 'streamers/main/store',
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
                state.mainStreamers.loaded = true;
            });
        },
        updateMainStreamer(state, item) {
            var formData = new FormData();
            state.mainStreamers.loaded = false;
            formData.append('token', state.token);
            formData.append('id', item.id);
            formData.append('promouted_start', item.promouted_start.HH + ':' + item.promouted_start.mm + ':00');
            formData.append('promouted_end', item.promouted_end.HH + ':' + item.promouted_end.mm + ':00');
            fetch(state.apiUrl + 'streamers/main/update',
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
                state.mainStreamers.loaded = true;
            });
        },
        deleteMainStreamer(state, id) {
            var formData = new FormData();
            state.mainStreamers.loaded = false;
            formData.append('token', state.token);
            formData.append('id', id);
            fetch(state.apiUrl + 'streamers/main/delete',
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
                state.mainStreamers.loaded = true;
            });
        },
        // main content
        getMainContent(state) {
            var formData = new FormData();
            state.mainContent.loaded = false;
            fetch(state.apiUrl + 'content/show',
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
                state.mainContent.list = jsonResp.data ? jsonResp.data : [];
                state.mainContent.loaded = true;
            });
        },
        storeMainContent(state, data) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('content', JSON.stringify(data));
            fetch(state.apiUrl + 'content/store',
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
                // alert 'saved'
                state.alerts.push({
                    message: 'content saved'
                });
            });
        },
        clearAlerts(state) {
            state.alerts = [];
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
        },
        // promoted streamers
        getStreamersListAction(context) {
            context.commit('getStreamersList');
        },
        getPromotedListAction(context) {
            context.commit('getPromotedList');
            context.commit('getStreamersList');
        },
        addPromotedAction(context, id) {
            context.commit('addPromoted', id);
            setTimeout(() => {
                context.commit('getPromotedList');
            }, config.timeOut);
        },
        deletePromotedAction(context, id) {
            context.commit('deletePromoted', id);
            setTimeout(() => {
                context.commit('getPromotedList');
            }, config.timeOut);
        },
        upPromotedAction(context, id) {
            context.commit('upPromoted', id);
            setTimeout(() => {
                context.commit('getPromotedList');
            }, config.timeOut);
        },
        downPromotedAction(context, id) {
            context.commit('downPromoted', id);
            setTimeout(() => {
                context.commit('getPromotedList');
            }, config.timeOut);
        },
        // main streamers
        getMainStreamersListAction(context) {
            context.commit('getPromotedList');
            context.commit('getMainStreamersList');
        },
        addMainStreamerAction(context, item) {
            context.commit('addMainStreamer', item);
            setTimeout(() => {
                context.commit('getMainStreamersList');
            }, config.timeOut);
        },
        updateMainStreamerAction(context, item) {
            context.commit('updateMainStreamer', item);
            setTimeout(() => {
                context.commit('getMainStreamersList');
            }, config.timeOut);
        },
        deleteMainStreamerAction(context, id) {
            context.commit('deleteMainStreamer', id);
            setTimeout(() => {
                context.commit('getMainStreamersList');
            }, config.timeOut);
        },
        // main content
        updateMainContentAction(context, data) {
            context.commit('storeMainContent', data);
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
        sseMessages: state => {
            return state.sseMessages;
        },
        streamers: state => {
            return state.streamers.list;
        },
        streamersPages: state => {
            return state.streamers.pages;
        },
        streamersLoaded: state => {
            return state.streamers.loaded;
        },
        promotedStreamers: state => {
            return state.promotedStreamers.list;
        },
        promotedLoaded: state => {
            return state.promotedStreamers.loaded;
        },
        mainStreamers: state => {
            return state.mainStreamers.list;
        },
        mainStreamersLoaded: state => {
            return state.mainStreamers.loaded;
        },
        mainContent: state => {
            console.log('in state', state.mainContent.list);
            return state.mainContent.list;
        },
        mainContentLoaded: state => {
            return state.mainContent.loaded;
        },
        alerts: state => {
            console.log('alerts in getter', state.alerts);
            return state.alerts;
        }
    }
});

export default AdminStore;