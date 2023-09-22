import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        token: localStorage.getItem('auth_token') || null,
    },
    mutations: {
        setToken(state, token) {
            state.token = token;
            localStorage.setItem('auth_token', token);
        },
        clearToken(state) {
            state.token = null;
            localStorage.removeItem('auth_token');
        },
    },
});
