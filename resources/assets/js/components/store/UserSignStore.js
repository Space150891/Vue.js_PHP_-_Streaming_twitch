import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const UserSignStore = new Vuex.Store({
    state: {
        token: false,
        message: ""
        
    },
    mutations: {
        signUp(state) {
            state.token = localStorage.getItem("userToken");
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
                console.log(jsonResp.message);
                state.message = jsonResp.message;
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

export default UserSignStore;