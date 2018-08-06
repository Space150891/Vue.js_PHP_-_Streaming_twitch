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
    }
}