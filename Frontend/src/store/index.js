import apiClient from '@/plugins/axios';
import { createStore } from 'vuex'

const store = createStore({
  state: {
    user: null,
    token: null,
    isAuthenticated: false,
    assets: [],
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
        console.log(response);
        const assets = response.data.assets
        console.log(assets);
        commit('SET_ASSETS', assets)    
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
    }
  },
  modules: {
    // You can add additional modules for modularization
  }
})

export default store;
