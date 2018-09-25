export const mutations = {
    signUp(state) {
        state.token = localStorage.getItem("userToken");
        state.twitchRefresh = localStorage.getItem("twitchRefresh");
        document.cookie = "token=" + state.token;
    },
    loadCurrentViewer(state) {
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/viewers/current',
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
                    } else {
                        state.currentViewer.name = jsonResp.data.name;
                        state.currentViewer.points = jsonResp.data.points;
                        state.currentViewer.diamonds = jsonResp.data.diamonds;
                        state.currentViewer.level = jsonResp.data.level;
                        state.currentViewer.user_id = jsonResp.data.user_id;
                        state.currentViewer.contacts = jsonResp.data.contacts;
                        state.menuMessages = state.menuMessages.concat(jsonResp.data.messages);
                    }
                });
        }
    },
    signOut(state) {
        var formData = new FormData();
        formData.append('token', state.token);

        fetch('api/auth/logout',
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
                delete localStorage["userToken"];
                state.token = false;
                state.message = jsonResp.message;
            });
    },
    loadProfile(state, name = '') {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        var url = 'api/profile/current';
        if (name != '') {
            formData.append('name', name);
            url = 'api/profile/get';
        } else {
            formData.append('token', state.token);
        }
        fetch(url,
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
                } else {
                    state.profileData = jsonResp.data;
                    state.customAchievements.loaded = true;
                }
            });
    },
    loadStreamerFullData(state, name) {
        var formData = new FormData();
        formData.append('name', name);
        formData.append('token', state.token);
        fetch('api/streamers/get',
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
                } else {
                    state.streamerFullData = jsonResp.data;
                }
            });
    },
    getPromotedList(state) {
        var formData = new FormData();
        state.promotedStreamers.loaded = false;
        formData.append('token', state.token);
        fetch('api/streamers/promoted/list',
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
                state.promotedStreamers.list = jsonResp.data ? jsonResp.data.promoted : [];
                state.promotedStreamers.loaded = true;
            });
    },
    getSubscriptionPlansList(state) {
        var formData = new FormData();
        state.subscriptionPlans.loaded = false;
        formData.append('token', state.token);
        fetch('api/subscriptionplans/list',
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
        fetch('api/monthplans/list',
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
    loadCurrentStreamer(state) {
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/streamers/current',
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
                    } else {
                        state.currentStreamer = jsonResp.data;
                    }
                });
        }
    },
    loadMyStreamers(state){
        state.myStreamers.list = [];
        state.myStreamers.loaded = false;
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/signedviewers/mystreamers/list',
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
                    } else {
                        state.myStreamers.list = jsonResp.data.streamers;
                        state.myStreamers.loaded = true;
                    }
                });
        }
    },
    loadMyViewers(state){
        state.myViewers.list = [];
        state.myViewers.loaded = false;
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/signedviewers/myviewers/list',
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
                    } else {
                        state.myViewers.list = jsonResp.data.viewers;
                        state.myViewers.loaded = true;
                    }
                });
        }
    },
    getAfiliatedList(state){
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/afiliates/mylist',
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
                    } else {
                        state.afiliates = jsonResp.data;
                    }
                });
        }
    },
    getAfiliatedLink(state){
        state.afiliateLink = '';
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            fetch('api/afiliates/mylink',
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
                    } else {
                        state.afiliateLink = jsonResp.data;
                    }
                });
        }
    },
    loadGames(state){
        state.games.loaded = false;
        fetch('api/games/list',
            {
                method: "POST",
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                if (!jsonResp.errors) {
                    state.games.loaded = true;
                    state.games.list = jsonResp.data.games;
                }
            });
    },
    loadNotifications(state){
        state.notifications.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/notifications/list',
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
                if (!jsonResp.errors) {
                    state.notifications.loaded = true;
                    state.notifications.list = jsonResp.data.notifications;
                }
            });
    },
    loadStreamersByGame(state, gameGame) {
        state.streamers.loaded = false;
        var formData = new FormData();
        formData.append('game_name', gameGame);
        fetch('api/streamers/bygamename',
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
                if (!jsonResp.errors) {
                    state.streamers.loaded = true;
                    state.streamers.list = jsonResp.data.streamers;
                }
            });
    },
    loadAchivements(state){
        state.achivements.loaded = false;
        state.viewerCustomAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/achivements/list',
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
                if (!jsonResp.errors) {
                    state.achivements.loaded = true;
                    state.viewerCustomAchievements.loaded = true;
                    state.achivements.list = jsonResp.data.achivements;
                    state.viewerCustomAchievements.list = jsonResp.data.customs;
                }
            });
    },
    cardAchivements(state){
        state.achivements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/achivements/card',
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
                if (!jsonResp.errors) {
                    state.achivements.loaded = true;
                    state.achivements.list = jsonResp.data.achivements;
                }
            });
    },
    flashStreamers(state) {
        state.streamers.loaded = false;
        state.streamers.list = [];
    },
    pushAchivement(state, data) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('achivement_name', data.name);
        var points = data.points ? data.points : 1;
        formData.append('points', points);
        fetch('api/achivements/add',
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
    // main content
    getMainContent(state) {
        var formData = new FormData();
        state.mainContent.loaded = false;
        fetch('api/content/show',
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
            state.multistream = jsonResp.data.multistream ? true : false;
        });
    },
    getMainChannel(state) {
        fetch('api/streamers/main/show',
            {
                method: "POST",
                credentials: 'omit',
                mode: 'cors',
            })
            .then(function(res){
                return res.json();
            })
            .then(function(jsonResp){
                state.mainChannel = jsonResp.data;
            });
    },
    setWatchingStreams(state, data) {
        state.wachingStreamers = data;
    },
    clearWatchingStreams(state) {
        state.wachingStreamers = [];
    },
    viewingChannel(state, channel) { // delete later
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('channel', channel);
        fetch('api/activity/update',
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
                if (jsonResp.data) {
                    state.currentViewer.points = jsonResp.data.points;
                    state.currentViewer.diamonds = jsonResp.data.diamonds;
                    state.currentViewer.level = jsonResp.data.level;
                    state.menuMessages = state.menuMessages.concat(jsonResp.data.messages);
                }
            });
    },
    clearMenuMessages(state) {
        state.menuMessages = [];
    },
    addFollow(state, streamName){
        if (state.token) {
            var formData = new FormData();
            formData.append('token', state.token);
            formData.append('name', streamName);
            fetch('api/signedviewers/add',
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
        }
    },
    // cards page
    getMyItems(state){
        state.myItems.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/viewer/items/list',
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
                if (!jsonResp.errors) {
                    state.myItems.loaded = true;
                    state.myItems.list = jsonResp.data.items;
                }
            });
    },
    getMyCards(state){
        state.myCards.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/cards/list',
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
                if (!jsonResp.errors) {
                    state.myCards.loaded = true;
                    state.myCards.list = jsonResp.data.cards;
                }
            });
    },
    // SMS
    sendSMS(state, phone) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('phone', phone);
        fetch('api/sms/code/get',
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
    checkCode(state, code) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('code', code);
        state.checkedCode = 'waiting';
        fetch('api/sms/code/check',
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
                } else {
                    if (jsonResp.message) {
                        state.checkedCode = 'true';
                    } else {
                        state.checkedCode = 'false';
                    }
                }
            });
    },
    getRandomChannels(state, totalChannels) {
        var formData = new FormData();
        formData.append('token', state.token);
        formData.append('total', totalChannels);
        fetch('api/roulette/channels/get',
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
                } else {
                    if (jsonResp.data) {
                        state.roulette.channels = jsonResp.data.channels;
                    }
                }
            });
    },
    // Diamonds
    getDiamondsList(state) {
        state.diamonds.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/diamonds/list',
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
    // cases
    getCaseTypesList(state) {
        state.caseTypes.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/cases/types/list',
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
    // last prizes
    getLastPrizes(state) {
        fetch('api/prizes/last',
            {
                method: "POST",
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
                state.lastPrizes = jsonResp.data ? jsonResp.data.prizes : [];
            });
    },
    clearAlerts(state) {
        state.alerts = [];
    },
    //custom achivements
    loadCustomAchivements(state) {
        state.customAchievements.loaded = false;
        var formData = new FormData();
        formData.append('token', state.token);
        fetch('api/achivements/custom/list',
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
                    state.alerts = state.alerts.concat(jsonResp.message);
                }
                state.customAchievements.list = jsonResp.data ? jsonResp.data.achievements : [];
                state.customAchievements.loaded = true;

            });
    },
    getLiqForm(state, data) {
        var formData = new FormData();
        // formData.append('_token', state.token);
        formData.append('subscription_plan_id', data.subscriptionPlan);
        formData.append('month_plan_id', data.monthPlan);
        formData.append('amount', data.amount);
        formData.append('user_id', data.user_id);
        fetch('liqpay/getform',
            {
                method: "POST",
                credentials: 'omit',
                mode: 'cors',
                body: formData,
            })
            .then(res =>{return res.json()})
            .then(function(jsonResp){
                if (jsonResp.errors && jsonResp.errors[0] == 'Unauthenticated.') {
                    state.token = false;
                }
                if (jsonResp.errors) {
                    state.alerts = state.alerts.concat(jsonResp.message);
                } else {
                    state.payments.liqForm = jsonResp.data.form;
                }

            })
            .catch(err => err);

    },
    getMultistreamCheck(state) {
        fetch('api/multistream/check',
        {
            method: "POST",
            credentials: 'omit',
            mode: 'cors',
        })
        .then(function(res){
            return res.json();
        })
        .then(function(jsonResp){
            if (jsonResp.errors) {
                state.alerts = state.alerts.concat(jsonResp.message);
            } else {
                state.multistream = jsonResp.data.multistream ? true : false;
                console.log('MULTISTREAM=', state.multistream);
            }
        });
    }
}
