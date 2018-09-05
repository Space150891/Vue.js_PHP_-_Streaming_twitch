export const getters = {
    checkToken: state => {
        return state.token ? true : false;
    },
    profileData: state => {
        return state.profileData;
    },
    promotedStreamers: state => {
        return state.promotedStreamers.list;
    },
    promotedLoaded: state => {
        return state.promotedStreamers.loaded;
    },
    currentViewer: state => {
        return state.currentViewer;
    },
    subscriptionPlans: state => {
        return state.subscriptionPlans.list;
    },
    monthPlans: state => {
        return state.monthPlans.list;
    },
    currentStreamer: state => {
        return state.currentStreamer;
    },
    myStreamers: state => {
        return state.myStreamers.list;
    },
    myViewers: state => {
        return state.myViewers.list;
    },
    afiliates: state => {
        return state.afiliates;
    },
    afiliateLink: state => {
        return state.afiliateLink;
    },
    games: state => {
        return state.games.list;
    },
    streamers: state => {
        return state.streamers.list;
    },
    streamersLoaded: state => {
        return state.streamers.loaded;
    },
    notifications: state => {
        return state.notifications.list;
    },
    achivements: state => {
        return state.achivements.list;
    },
    streamerFullData: state => {
        return state.streamerFullData;
    },
    mainContent: state => {
        return state.mainContent.list;
    },
    mainContentLoaded: state => {
        return state.mainContent.loaded;
    },
    mainChannel: state => {
        return state.mainChannel;
    },
    wachingStreamers: state => {
        return state.wachingStreamers;
    },
    menuMessages: state => {
        return state.menuMessages;
    },
    myItems: state => {
        return state.myItems.list;
    },
    myItemsLoades: state => {
        return state.myItems.loaded;
    },
    myCards: state => {
        return state.myCards.list;
    },
    myCardsLoades: state => {
        return state.myCards.loaded;
    },
    checkedCode: state => {
        return state.checkedCode;
    },
    rouletteChannelsCount: state => {
        return state.roulette.channelsCount;
    },
    rouletteChannels: state => {
        return state.roulette.channels;
    },
    diamonds: state => {
        return state.diamonds.list;
    },
    diamondsLoaded: state => {
        return state.diamonds.loaded;
    },
    caseTypes: state => {
        return state.caseTypes.list;
    },
    caseTypesLoaded: state => {
        return state.caseTypes.loaded;
    },
    winItems: state => {
        return state.win.win;
    },
    winedItems: state => {
        return state.win.items;
    },
    winedPrizes: state => {
        return state.win.prizes;
    },
    lastPrizes: state => {
        return state.lastPrizes;
    },
    alerts: state => {
        return state.alerts;
    },
    customAchievements: state => {
        return state.customAchievements.list;
    },
    customAchievementsLoaded: state => {
        return state.customAchievements.loaded;
    },
    viewerCustomAchievements: state => {
        return state.viewerCustomAchievements.list;
    },
    jwt: state => {
        return state.token;
    },
    payments: state => {
        return state.payments;
    },
    checkMultistream: state => {
        return state.multistream;
    },
}