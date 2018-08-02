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
}