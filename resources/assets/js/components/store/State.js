export const state = {
    token: false,
    currentViewer: {
        diamonds: 0,
        points: 0,
        level: 0,
        name: '',
        messages : [],
    },
    currentStreamer: {
        id: 0,
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
}