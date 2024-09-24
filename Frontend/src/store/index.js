import apiClient from '@/plugins/axios';
import { createStore } from 'vuex'
import Cookies from 'js-cookie';

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
      try {
        const response = await apiClient.post('/logout');

        commit('SET_USER', null);
        commit('SET_TOKEN', null);
        return response;
      } catch (error) {
        this.handleError(error, 'Error while logging out');
      }
    },

    async fetchAssets({ commit }) {
      try {
          const response = await apiClient.get('/assets');
          const assets = response.data.data;
          commit('SET_ASSETS', assets);  
        } catch (error) {
          this.handleError(error, 'Error fetching assets');
      }
    },

    async fetchEvents({ commit }) {
      try {
        const response = await apiClient.get('/events');
        const events = response.data.data;
        commit('SET_EVENTS', events);   
      } catch (error) {
        this.handleError(error, 'Error fetching events');
      } 
    },

    async fetchCategories({ commit }, { type }) {
      try {
        const response = await apiClient.get('/categories', { params: { type: type } });
        const categories = response.data.data;
        commit('SET_CATEGORIES', {type, categories}); 
      } catch (error) {
        this.handleError(error, 'Error fetching categories');
      }   
    },

    handleError({error, errorMessage}) {
      if (error.response && error.response.status === 401) {
        Cookies.remove('auth_token', { path: '/' })
      } else {
          console.error(`${errorMessage}: `, error);
      }
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
    getAsset: (state) => (id) =>  {
      return state.assets.find(asset => asset.id === id);
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
