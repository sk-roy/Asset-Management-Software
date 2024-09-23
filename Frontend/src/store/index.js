import apiClient from '@/plugins/axios';
import { createStore } from 'vuex'

const store = createStore({
  state: {
    user: null,
    token: null,
    isAuthenticated: false,
    assets: [],
    events: [],
    categories: {},
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
    SET_TOKEN(state, token) {
      state.token = token;
      state.isAuthenticated = !!token;
    },
    SET_ASSETS(state, assets) {
        state.assets = assets;
    },
    SET_EVENTS(state, events) {
        state.events = events;
    },
    SET_CATEGORIES(state, { type, categories }) {
        state.categories[type] = categories;
    }
  },
  actions: {
    async login({ commit }, { email, password }) {
        const response = await apiClient.post('/login', { email, password });
        const token = response.data.token;
        const user = response.data.user;

        commit('SET_TOKEN', token);
        commit('SET_USER', user);

        return response;
    },

    async logout({ commit }) {
        const response = await apiClient.post('/logout');

        commit('SET_USER', null);
        commit('SET_TOKEN', null);
        return response;
    },

    async fetchAssets({ commit }) {
        const response = await apiClient.get('/assets');
        const assets = response.data.data;
        commit('SET_ASSETS', assets);  
    },

    async fetchEvents({ commit }) {
        const response = await apiClient.get('/events');
        const events = response.data.data;
        commit('SET_EVENTS', events);    
    },

    async fetchCategories({ commit }, { type }) {
        const response = await apiClient.get('/categories', { params: { type: type } });
        const categories = response.data.data;
        commit('SET_CATEGORIES', {type, categories});    
    }
  },
  getters: {
    isAuthenticated(state) {
      return state.isAuthenticated;
    },
    getUser(state) {
      return state.user;
    },
    getToken(state) {
      return state.token;
    },
    getAssets(state) {
      return state.assets;
    },
    getEvents(state) {
      return state.events;
    },
    getCategories: (state)  => (type) => {
      return state.categories[type] || [];
    }
  },
  modules: {
    //
  }
})

export default store;
