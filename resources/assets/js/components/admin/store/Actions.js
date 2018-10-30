var config = require('../../config/config.json');

export const actions = {
    getItemTypesListAction(context) {
        context.commit('getItemTypesList');
    },
    createItemTypeAction({commit, state}, data) {
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
            commit('getItemTypesList');
        });
    },
    ItemTypeDeleteAction({commit, state}, id) {
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
            commit('getItemTypesList');
        });
    },
    ItemTypeSaveAction({commit, state}, data) {
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
            commit('getItemTypesList');
        });
    },
    // rarities
    getRaritiesListAction(context) {
        context.commit('getRaritiesList');
    },
    createRarityAction({commit, state}, data) {
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
            commit('getRaritiesList');
        });
    },
    RarityDeleteAction({commit, state}, id) {
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
            commit('getRaritiesList');
        });
    },
    RaritySaveAction({commit, state}, data) {
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
            commit('getRaritiesList');
        });
    },
    // items
    getItemsListAction(context) {
        context.commit('getItemsList');
        context.commit('getItemTypesList');
        context.commit('loadRarityClasses');
    },
    createItemAction({commit, state}, data) {
        var formData = new FormData();
        state.items.saved = false;
        state.items.loaded = false;
        formData.append('token', state.token);
        formData.append('title', data.title);
        formData.append('item_type_id', data.item_type_id);
        formData.append('rarity_class_id', data.rarity_class_id);
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
            commit('getItemsList');
        });
    },
    ItemDeleteAction({commit, state}, id) {
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
            commit('getItemsList');
        });
    },
    ItemSaveAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('title', data.title);
        formData.append('item_type_id', data.item_type_id);
        formData.append('rarity_class_id', data.rarity_class_id);
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
            commit('getItemsList');
        });
    },
    // case types
    getCaseTypesListAction(context) {
        context.commit('getCaseTypesList');
        context.commit('loadRarityClasses');
    },
    createCaseTypeAction({commit, state}, data) {
        var formData = new FormData();
        state.caseTypes.saved = false;
        state.caseTypes.loaded = false;
        formData.append('token', state.token);
        formData.append('description', data.description);
        formData.append('price', data.price);
        formData.append('diamonds', data.diamonds);
        formData.append('rarity_class_id', data.rarity_class_id);
        
        formData.append('hero_rarity_id', data.hero_rarity_id);
        formData.append('frame_rarity_id', data.frame_rarity_id);
        formData.append('prize_cost', data.prize_cost);
        formData.append('points_count', data.points_count);
        formData.append('diamonds_count', data.diamonds_count);
        formData.append('hero_percent', data.hero_percent);
        formData.append('frame_percent', data.frame_percent);
        formData.append('prize_percent', data.prize_percent);
        formData.append('points_percent', data.points_percent);
        formData.append('diamonds_percent', data.diamonds_percent);
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
            commit('getCaseTypesList');
        });
    },
    CaseTypeDeleteAction({commit, state}, id) {
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
            commit('getCaseTypesList');
        });
    },
    CaseTypeSaveAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('description', data.description);
        formData.append('price', data.price);
        formData.append('diamonds', data.diamonds);
        formData.append('rarity_class_id', data.rarity_class_id);
        formData.append('hero_rarity_id', data.hero_rarity_id);
        formData.append('frame_rarity_id', data.frame_rarity_id);
        formData.append('prize_cost', data.prize_cost);
        formData.append('points_count', data.points_count);
        formData.append('diamonds_count', data.diamonds_count);
        formData.append('hero_percent', data.hero_percent);
        formData.append('frame_percent', data.frame_percent);
        formData.append('prize_percent', data.prize_percent);
        formData.append('points_percent', data.points_percent);
        formData.append('diamonds_percent', data.diamonds_percent);
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
            commit('getCaseTypesList');
        });
    },
    // cases
    CasesListAction(context) {
        context.commit('getCases');
        context.commit('getCaseTypesList');
    },
    CaseCreateAction({commit, state}, data) {
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
            commit('getCases');
        });
    },
    CaseDeleteAction({commit, state}, id) {
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
            commit('getCases');
        });
    },
    CaseSaveAction({commit, state}, data) {
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
            commit('getCases');
        });
    },
    // case items
    CaseItemsListAction(context, id) {
        context.commit('getItemsList');
        context.commit('getRaritiesList');
        context.commit('getCaseItems', id); //
    },
    CaseItemCreateAction({commit, state}, data) {
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
            commit('getCaseItems', data.case_id);
        });
    },
    CaseItemDeleteAction({commit, state}, id) {
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
            commit('getCaseItems', id);
        });
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
    addPromotedAction({commit, state}, data) {
        state.promotedStreamers.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.streamer_id);
        formData.append('points', data.points);
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
            commit('getPromotedList');
        });
    },
    updatePromotedAction({commit, state}, data) {
        state.promotedStreamers.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('streamer_id', data.streamer_id);
        formData.append('points', data.points);
        fetch(state.apiUrl + 'streamers/promoted/update',
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
            commit('getPromotedList');
        });
    },
    deletePromotedAction({commit, state}, id) {
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
            commit('getPromotedList');
        });
    },
    upPromotedAction({commit, state}, id) {
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
            commit('getPromotedList');
        });
    },
    downPromotedAction({commit, state}, id) {
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
            commit('getPromotedList');
        });
    },
    // main streamers
    getMainStreamersListAction(context) {
        context.commit('getPromotedList');
        context.commit('getMainStreamersList');
    },
    addMainStreamerAction({commit, state}, item) {
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
            commit('getMainStreamersList');
        });
    },
    updateMainStreamerAction({commit, state}, item) {
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
            commit('getMainStreamersList');
        });
    },
    deleteMainStreamerAction({commit, state}, id) {
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
            commit('getMainStreamersList');
        });
    },
    // main content
    updateMainContentAction(context, data) {
        context.commit('storeMainContent', data);
    },
    getSubscribeData(context) {
        context.commit('getSubscriptionPlansList');
        context.commit('getMonthPlansList');
    },
    // Stock Prizes
    StockPrizeListAction(context) {
        context.commit('getStockPrizesList');
        context.commit('loadRarityClasses');
        context.commit('getPrizeTypes');
    },
    StockPrizeCreateAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('name', data.name);
        formData.append('description', data.description);
        formData.append('cost', data.cost);
        formData.append('amount', data.amount);
        formData.append('rarity_class_id', data.rarity_class_id);
        formData.append('website_url', data.website_url);
        formData.append('video_url', data.video_url);
        formData.append('manufacturer', data.manufacturer);
        formData.append('store_url', data.store_url);
        formData.append('prize_type_id', data.prize_type_id);
        if (data.image) {
            formData.append('image', data.image);
        }
        fetch(state.apiUrl + 'store/prizes/store',
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
            commit('getStockPrizesList');
        });
    },
    StockPrizeUpdateAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('name', data.name);
        formData.append('description', data.description);
        formData.append('cost', data.cost);
        formData.append('amount', data.amount);
        formData.append('rarity_class_id', data.rarity_class_id);
        formData.append('website_url', data.website_url);
        formData.append('video_url', data.video_url);
        formData.append('manufacturer', data.manufacturer);
        formData.append('store_url', data.store_url);
        formData.append('prize_type_id', data.prize_type_id);
        if (data.image) {
            formData.append('image', data.image);
        }
        fetch(state.apiUrl + 'store/prizes/update',
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
            commit('getStockPrizesList');
        });
    },
    StockPrizeDeleteAction({commit, state}, id) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch(state.apiUrl + 'store/prizes/delete',
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
            commit('getStockPrizesList');
        });
    },
    // Diamonds
    getDiamondsListAction(context) {
        context.commit('getDiamondsList');
    },
    DiamondsCreateAction({commit, state}, data) {
        state.diamonds.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('name', data.name);
        formData.append('description', data.description);
        formData.append('cost', data.cost);
        formData.append('amount', data.amount);
        fetch(state.apiUrl + 'diamonds/store',
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
            commit('getDiamondsList');
        });
    },
    DiamondsSaveAction({commit, state}, data) {
        state.diamonds.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('cost', data.cost);
        formData.append('amount', data.amount);
        formData.append('name', data.name);
        formData.append('description', data.description);
        fetch(state.apiUrl + 'diamonds/update',
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
            commit('getDiamondsList');
        });
    },
    DiamondsDeleteAction({commit, state}, id) {
        state.diamonds.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch(state.apiUrl + 'diamonds/delete',
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
            commit('getDiamondsList');
        });
    },
    loadStatisticAction({commit, state}, data) {
        console.log('Action loading table');
        commit('loadStatistic', data);
    },
    deleteCustomAchivementAction({commit, state}, id) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch('api/achivements/custom/delete',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                // state.alerts.push(jsonResp.message);
            }
            commit('loadAllCustomAchivements');
        });
    },
    setOkCustomAchivementAction({commit, state}, id) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch('api/achivements/custom/ok',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                // state.alerts.push(jsonResp.message);
            }
            commit('loadAllCustomAchivements');
        });
    },
    setBlockCustomAchivementAction({commit, state}, id) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch('api/achivements/custom/block',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                // state.alerts.push(jsonResp.message);
            }
            commit('loadAllCustomAchivements');
        });
    },
    updateSubscriptionPointsAction({commit, state}, data) {
        state.subscriptionPlans.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('points', data.points);
        formData.append('subscription_plan_id', data.id);
        console.log('in action', data.id);
        fetch(state.apiUrl + 'subscription/update',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                // state.alerts.push(jsonResp.message);
            }
            commit('getSubscriptionPlansList');
        });
    },
    // subscription bonus points
    createSubscriptionBonusPointsAction({commit, state}, data) {
        state.subscriptionBonusPoints.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('subscription_plan_id', data.selectedPlan);
        formData.append('from_viewers', data.from_viewers);
        formData.append('to_viewers', data.to_viewers);
        formData.append('points', data.points);
        fetch(state.apiUrl + 'subscription/points/create',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
            }
            if (jsonResp.message) {
            }
            commit('loadSubscriptionBonusPoints', data.selectedPlan);
        });
    },
    updateSubscriptionBonusPointsAction({commit, state}, data) {
        state.subscriptionBonusPoints.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        console.log('in action', data.id);
        formData.append('subscription_point_id', data.id);
        formData.append('from_viewers', data.from_viewers);
        formData.append('to_viewers', data.to_viewers);
        formData.append('points', data.points);
        fetch(state.apiUrl + 'subscription/points/update',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
            }
            if (jsonResp.message) {
            }
            commit('loadSubscriptionBonusPoints', data.selectedPlan);
        });
    },
    deleteSubscriptionBonusPointsAction({commit, state}, data) {
        state.subscriptionBonusPoints.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('subscription_point_id', data.deleteId);
        fetch(state.apiUrl + 'subscription/points/delete',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
            }
            if (jsonResp.message) {
            }
            commit('loadSubscriptionBonusPoints', data.selectedPlan);
        });
    },
    getAchievements(context) {
        context.commit('loadAchievements');
        context.commit('loadAllRarityClasses');
    },
    achievementSaveAction({commit, state}, data) {
        state.achievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('name', data.name);
        formData.append('description', data.description);
        formData.append('steps', data.steps);
        formData.append('level_points', data.level_points);
        formData.append('diamonds', data.diamonds);
        formData.append('case_rarity_id', data.case_rarity_id);
        formData.append('card_rarity_id', data.card_rarity_id);
        formData.append('frame_rarity_id', data.frame_rarity_id);
        formData.append('hero_rarity_id', data.hero_rarity_id);
        if (data.image) {
            formData.append('image', data.image);
        }
        fetch(state.apiUrl + 'achivements/admin/save',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
            body: formData,
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
            }
            if (jsonResp.message) {
            }
            commit('loadAchievements');
        });
    },
}