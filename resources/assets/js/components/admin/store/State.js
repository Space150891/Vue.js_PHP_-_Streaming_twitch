var config = require('../../config/config.json');

export const state = {
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
    users: {
        list: [],
        loaded: false,
        saved : true,
        pages: 1,
    },
    userInfo: {
        data : {},
        loaded: false,
    },
    subscriptionPlans: {
        list: [],
        loaded: false,
    },
    monthPlans: {
        list: [],
        loaded: false,
    },
    editUser :{},
    stockPrizes: {
        list: [],
        loaded: false,
        saved : true,
    },
    diamonds: {
        list: [],
        loaded: false,
    },
}
