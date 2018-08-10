export const getters = {
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
        return state.mainContent.list;
    },
    mainContentLoaded: state => {
        return state.mainContent.loaded;
    },
    alerts: state => {
        return state.alerts;
    },
    // users
    users: state => {
        return state.users.list;
    },
    usersPages: state => {
        return state.users.pages;
    },
    usersLoaded: state => {
        return state.users.loaded;
    },
    // userInfo
    userInfo: state => {
        return state.userInfo.data;
    },
    userInfoLoaded: state => {
        return state.userInfo.loaded;
    },
    editUser: state => {
        return state.editUser;
    },
    // subscriptions
    subscriptionPlans: state => {
        return state.subscriptionPlans.list;
    },
    monthPlans: state => {
        return state.monthPlans.list;
    },
    stockPrizes: state => {
        return state.stockPrizes.list;
    },
    stockPrizesLoaded: state => {
        return state.stockPrizes.loaded;
    },
    stockPrizesSaved: state => {
        return state.stockPrizes.saved;
    },
    diamonds: state => {
        return state.diamonds.list;
    },
    diamondsLoaded: state => {
        return state.diamonds.loaded;
    },
    statistic: state => {
        return state.statistic;
    },
}