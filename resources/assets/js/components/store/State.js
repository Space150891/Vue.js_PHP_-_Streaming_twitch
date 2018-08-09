export const state = {
    token: false,
    currentViewer: {
        diamonds: 0,
        points: 0,
        level: 0,
        name: '',
        messages : [],
        user_id: 0,
    },
    currentStreamer: {
        id: 0,
        paypal: null,
        donate_front: null,
        donate_back: null,
        donate_text: null,
        avatar : null,
    },
    message: "",
    profileData: {
        avatar : null,
        username: null,
        nickname: null,
        email: null,
        bio: null,
        paypal: null,
    },
    promotedStreamers: {
        list: [],
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
    myStreamers: {
        list: [],
        loaded: false,
    },
    myViewers: {
        list: [],
        loaded: false,
    },
    afiliates: {
        visited: 0,
        registered: 0,
        total: 0,
    },
    games: {
        list: [],
        loaded: false,
    },
    streamers: {
        list: [],
        loaded: false,
    },
    notifications: {
        list: [],
        loaded: false,
    },
    afiliateLink: '',
    achivements: {
        list: [],
        loaded: false,
    },
    mainContent: {
        list: [],
        loaded: false,
    },
    streamerFullData : {},
    mainChannel : 'twitchpresents',
    wachingStreamers : [],
    menuMessages : [],
    myItems : {
        list: [],
        loaded: false,
    },
    myCards : {
        list: [],
        loaded: false,
    },
    checkedCode : 'none',
    roulette: {
        channels: [],
        channelsCount: 0,
    },
    diamonds: {
        list: [],
        loaded: false,
    },
    caseTypes: {
        list: [],
        loaded: false,
    },
    win: {
        win: false,
        items: [],
        prizes: [],
    },
    lastPrizes: [],
}