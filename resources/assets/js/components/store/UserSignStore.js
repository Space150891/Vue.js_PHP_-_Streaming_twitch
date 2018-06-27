STORE
import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const UserSignStore = new Vuex.Store({
    state: {
        token: false,
        
    },
    mutations: {
        signVal() {
            let tokenData = new FormData();
            tokenData.append('token', localStorage.userToken);
            fetch("http://127.0.0.1:8000/api/auth/me",
                {
                    method: "POST",
                    credentials: 'omit',
                    mode: 'cors',
                    body: tokenData,
                })
                .then(function(res){
                    if (res.status === 401) {
                        delete localStorage["userToken"];
                    }

                    return res.json();
                })
                .then(function(data){
                    console.log('data=', data);
                }
            );
        } 
    },
    actions: {
        
    },
    getters : {
        checkToken: state => {
            return state.token ? true : false;
        },
    }
});

export default UserSignStore;