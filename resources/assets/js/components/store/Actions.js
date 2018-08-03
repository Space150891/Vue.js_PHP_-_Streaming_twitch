export const actions = {
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
    loadMyCardsPage(context) {
        context.commit('cardAchivements');
        context.commit('getMyItems');
        context.commit('getMyCards');
    },
    createCardAction(context, data) {
        context.commit('createCard', data);
        setTimeout(() => {
            context.commit('cardAchivements');
            context.commit('getMyItems');
            context.commit('getMyCards');
        }, 2000);
    },
    deleteCardAction(context, cardId) {
        context.commit('deleteCard', cardId);
        setTimeout(() => {
            context.commit('cardAchivements');
            context.commit('getMyItems');
            context.commit('getMyCards');
        }, 2000);
    },
    setMainCardAction(context, cardId) {
        context.commit('setMainCard', cardId);
        setTimeout(() => {
            context.commit('getMyCards');
        }, 2000);
    },
}