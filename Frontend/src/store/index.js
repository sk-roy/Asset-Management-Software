import apiClient from '@/plugins/axios';
import { createStore } from 'vuex'

const store = createStore({
  state: {
    user: null,
    token: null,
    isAuthenticated: false,
    assets: [],
    events: [],
    categories: [],
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
    SET_CATEGORIES(state, categories) {
        state.categories = categories;
    }
  },
  actions: {
    async login({ commit }, { email, password }) {
        const response = await apiClient.post('/login', { email, password })
        const token = response.data.token
        const user = response.data.user

        commit('SET_TOKEN', token)
        commit('SET_USER', user)

        return response;
    },

    async logout({ commit }) {
        const response = await apiClient.post('/logout')

        commit('SET_USER', null);
        commit('SET_TOKEN', null);
        return response;
    },

    async fetchAssets({ commit }) {
        const response = await apiClient.get('/assets')
        const assets = response.data.assets
        commit('SET_ASSETS', assets)    
    },

    async fetchEvents({ commit }) {
        const response = await apiClient.get('/events')
        const events = response.data.events
        commit('SET_EVENTS', events)    
    },

    async fetchCategories({ commit }) {
        const response = await apiClient.get('/categories')
        const categories = response.data.categories
        commit('SET_CATEGORIES', categories)    
    }
  },
  getters: {
    // Getters to access state
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
    getCategories(state) {
      return state.categories;
    }
  },
  modules: {
    // You can add additional modules for modularization
  }
})

export default store;
