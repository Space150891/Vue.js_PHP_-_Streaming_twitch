import Vue from 'vue';
import Vuex from 'vuex';

import { state } from './State.js';
import { mutations } from './Mutations.js';
import { actions } from './Actions.js';
import { getters } from "./Getters.js";

Vue.use(Vuex);

const UserSignStore = new Vuex.Store({
    state,
    mutations,
    actions,
    getters,

});

export default UserSignStore;