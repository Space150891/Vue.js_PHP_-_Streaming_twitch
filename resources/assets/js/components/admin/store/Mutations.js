export const mutations = {
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
    // subscription planes
    getSubscriptionPlansList(state) {
        var formData = new FormData();
        state.subscriptionPlans.loaded = false;
        formData.append('token', state.token);
        fetch(state.apiUrl + 'subscriptionplans/list',
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
        fetch(state.apiUrl + 'monthplans/list',
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
    // users
    getPaggUsersList(state, data) {
        var formData = new FormData();
        state.users.loaded = false;
        formData.append('token', state.token);
        formData.append('page', data.page);
        formData.append('on_page', data.onPage);
        fetch(state.apiUrl + 'users/list',
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
            state.users.list = jsonResp.data ? jsonResp.data.users : [];
            state.users.pages = jsonResp.data ? jsonResp.data.pages : 1;
            state.users.loaded = true;
        });
    },
    getUserInfo(state, id) {
        var formData = new FormData();
        state.userInfo.loaded = false;
        formData.append('token', state.token);
        formData.append('id', id);
        fetch(state.apiUrl + 'users/show',
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
            state.userInfo.data = jsonResp.data ? jsonResp.data : [];
            state.userInfo.loaded = true;
        });
    },
    getEditUser(state, id) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch(state.apiUrl + 'users/get',
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
            state.editUser = jsonResp.data ? jsonResp.data : {};
        });
    },
    subscribeUser(state, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('subscription_plan_id', data.subscriptionPlan);
        formData.append('month_plan_id', data.monthPlan);
        formData.append('user_id', data.userId);
        fetch(state.apiUrl + 'streamers/subscribe/admin',
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
            console.log('from API', jsonResp);
        });
    },
    // Stock Prizes
    getStockPrizesList(state) {
        var formData = new FormData();
        state.stockPrizes.loaded = false;
        formData.append('token', state.token);
        fetch(state.apiUrl + 'store/prizes/list',
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
            state.stockPrizes.list = jsonResp.data ? jsonResp.data.prizes : [];
            state.stockPrizes.loaded = true;
        });
    },
    // Diamonds
    getDiamondsList(state) {
        var formData = new FormData();
        state.diamonds.loaded = false;
        formData.append('token', state.token);
        fetch(state.apiUrl + 'diamonds/list',
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
            state.diamonds.list = jsonResp.data ? jsonResp.data.diamonds : [];
            state.diamonds.loaded = true;
        });
    },
    loadStatistic(state, data) {
        console.log('mutation loading table');
        var formData = new FormData();
        state.statistic.loaded = false;
        formData.append('token', state.token);
        formData.append('page', data.page);
        formData.append('on_page', data.on_page);
        formData.append('table', data.table);
        formData.append('period', data.period);
        fetch(state.apiUrl + 'statistic/get',
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
            if (jsonResp.data) {
                state.statistic.page = jsonResp.data.page;
                state.statistic.pages = jsonResp.data.pages;
                state.statistic.fields = jsonResp.data.fields;
                state.statistic.values = jsonResp.data.values;
            } else {
                state.statistic.page = 0;
                state.statistic.pages = 0;
                state.statistic.fields = [];
                state.statistic.values = [];
            }
            state.statistic.loaded = true;
        });
    },
    //custom achivements
    loadAllCustomAchivements(state) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/achivements/custom/all',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.customAchievements.list = jsonResp.data ? jsonResp.data.achievements : [];
            state.customAchievements.loaded = true;
            
        });
    },
    // subscription bonus points
    loadSubscriptionBonusPoints(state, id) {
        state.subscriptionBonusPoints.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('subscription_plan_id', id);
        fetch('api/subscription/points/get',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.subscriptionBonusPoints.list = jsonResp.data ? jsonResp.data.points : [];
            state.subscriptionBonusPoints.loaded = true;
        });
    },
    loadRarityClasses(state) {
        state.rarityClasses.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/rarity/class/get',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.rarityClasses.list = jsonResp.data ? jsonResp.data.rarity_classes : [];
            state.rarityClasses.loaded = true;
        });
    },
    loadAllRarityClasses(state) {
        state.rarityClasses.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/rarity/class/all',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.rarityClasses.list = jsonResp.data ? jsonResp.data.rarity_classes : [];
            state.rarityClasses.loaded = true;
        });
    },
    loadAchievements(state) {
        state.achievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/achivements/admin/list',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.achievements.list = jsonResp.data ? jsonResp.data.achievements : [];
            state.achievements.loaded = true;
        });
    },
    getPaggSubscribeList(state, data) {
        state.subscriptions.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('page', data.page);
        formData.append('on_page', data.onPage);
        formData.append('period', data.period);
        fetch('api/subscribed/pagglist',
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
            if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                state.token = false;
            }
            if (jsonResp.errors) {
                // state.alerts = state.alerts.concat(jsonResp.message);
            }
            state.subscriptions.list = jsonResp.data ? jsonResp.data.subscriptions : [];
            state.subscriptions.loaded = true;
        });
    },
    getPrizeTypes(state) {
        state.prizeTypes.loaded = false;
        fetch('api/prize/types',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            state.prizeTypes.list = jsonResp.data ? jsonResp.data.prize_types : [];
            state.prizeTypes.loaded = true;
        });
    }
}