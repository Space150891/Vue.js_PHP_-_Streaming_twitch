import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const AdminStore = new Vuex.Store({
    state: {
        logged: false,
        token: false,
        apiUrl : 'http://localhost:8000/api/',
    },
    mutations: {
        authWithToken(state, data) {
            var formData = new FormData();

            formData.append('email', data.email);
            formData.append('password', data.password);

            fetch(state.apiUrl + 'auth/login',
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
                state.token = jsonResp.access_token ? jsonResp.access_token : false;
            });
        },
    },
    actions: {
        
    },
    getters : {
        checkToken: state => {
            return state.token ? true : false;
        },
    }
});

export default AdminStore;