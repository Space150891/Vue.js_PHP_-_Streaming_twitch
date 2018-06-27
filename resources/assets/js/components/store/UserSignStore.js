import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const UserSignStore = new Vuex.Store({
    state: {
        token: false,
        
    },
    mutations: {
        signVal() {
            let tokenData = localStorage.userToken;
            console.log(tokenData)
            state.token = tokenData;
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