export const actions = {
    getSubscribeData(context) {
        context.commit('loadCurrentStreamer');
        context.commit('getSubscriptionPlansList');
        context.commit('getMonthPlansList');
    },
    removeMyStreamerAction({commit, state}, id) {
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
            commit('loadMyStreamers');
        }
    },
    loadAfiliated(context) {
        context.commit('getAfiliatedList');
        context.commit('loadProfile');
    },
    loadMyCardsPage(context) {
        context.commit('cardAchivements');
        context.commit('getMyItems');
        context.commit('getMyCards');
    },
    createCardAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('frame_id', data.frame_id);
        formData.append('hero_id', data.hero_id);
        formData.append('achivement_id', data.achivement_id);
        fetch('api/cards/add',
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
            commit('cardAchivements');
            commit('getMyItems');
            commit('getMyCards');
        });
    },
    deleteCardAction({commit, state}, cardId) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('card_id', cardId);
        fetch('api/cards/delete',
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
            commit('cardAchivements');
            commit('getMyItems');
            commit('getMyCards');
        });
    },
    setMainCardAction({commit, state}, cardId) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('card_id', cardId);
        fetch('api/cards/main',
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
            commit('getMyCards');
        });
    },
    checkCodeAction(context, code) {
        context.commit('checkCode', code);
    },
    startWatchingRouletteAction({commit, state}, totalChannels) {
        if (state.currentViewer.points >= 10) {
            state.roulette.channelsCount = totalChannels;
            commit('getRandomChannels', totalChannels);
        }
    },
    nextRouletteAction({commit, state}) {
        commit('getRandomChannels', state.roulette.channelsCount);
    },
    redeemRouletteAction({commit, state}, captcha) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('captcha', captcha);
        fetch('api/viewer/redeem',
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
            commit('loadCurrentViewer');
        });
    },
    // shop page
    buyCaseAction({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', data.id);
        formData.append('valute', data.valute);
        fetch('api/cases/buy',
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
            state.win.win = true;
            state.win.items = jsonResp.items;
            state.win.prizes = jsonResp.prizes;
            commit('loadCurrentViewer');
        });
    },
    flashWinItems({state}) {
        state.win.win = false;
    },
    updateViewerContacts({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('country', data.country);
        formData.append('city', data.city);
        formData.append('zip_code', data.zip_code);
        formData.append('local_address', data.local_address);
        fetch('api/viewer/contacts/update',
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
            commit('loadCurrentViewer');
        });
    },
    //
    getCurrentStreamer(context) {
        context.commit('loadCurrentStreamer');
    },
    saveCurrentStreamer({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('donate_text', data.donate_text);
        formData.append('paypal', data.paypal);
        fetch('api/streamers/custom/donate/save',
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
            
        });
    },
    uploadDonationImage({commit, state}, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('type', data.type);
        formData.append('image', data.file);
        fetch('api/streamers/custom/donate/upload',
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
            if (data.type == 'back') {
                state.currentStreamer.donate_back = jsonResp.data.file;
            }
            if (data.type == 'front') {
                state.currentStreamer.donate_front = jsonResp.data.file;
            }
        });
    },
    getLastPrizesAction({commit, state}) {
        commit('getLastPrizes');
    },
    // cabinet
    hideProfileFieldAction({commit, state}, data) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('field', data);
        fetch('api/profile/field/hide',
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
            commit('loadProfile');
        });
    },
    showProfileFieldAction({commit, state}, data) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('field', data);
        fetch('api/profile/field/show',
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
            commit('loadProfile');
        });
    },
    createNewAchivementAction({commit, state}, text) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('text', text);
        fetch('api/achivements/custom/store',
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
                state.alerts = state.alerts.concat(jsonResp.message);
            }
            if (jsonResp.message) {
                state.alerts.push(jsonResp.message);
            }
            commit('loadCustomAchivements');
        });
    },
    deleteCustomAchivementAction({commit, state}, id) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch('api/achivements/custom/deletemy',
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
                state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                state.alerts.push(jsonResp.message);
            }
            commit('loadCustomAchivements');
        });
    },
    setMainCustomAchivementAction({commit, state}, id) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('id', id);
        fetch('api/achivements/custom/main',
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
                state.alerts = state.alerts.concat(jsonResp.errors);
            }
            if (jsonResp.message) {
                state.alerts.push(jsonResp.message);
            }
            commit('loadCustomAchivements');
        });
    },
    savePrizeAlertAction({commit, state}, prizeAlert) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('prize_alert', prizeAlert);
        fetch('api/profile/prize-alert/save',
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
                state.alerts = state.alerts.concat(jsonResp.errors);
            }
        });
    },
    getLiqFormAction({commit, state}, data) {
        commit('getLiqForm', data);
    }
}