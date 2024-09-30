import apiClient from '@/plugins/axios';
import { createStore } from 'vuex'
import Cookies from 'js-cookie';
import methods from '@/components/methods';

const store = createStore({
  state: {
    user: null,
    token: null,
    isAuthenticated: false,
    assets: [],
    events: {},
    categories: {},
    assetId: null,
    drawer: {
      asset: {
        isOpen: false,
        id: null,
      },
      event: {
        isOpen: false,
        id: null,
        asset_id: null,
        category_id: null,
      }
    },
    notes: {},
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
    SET_ASSET_DETAILS(state, {id, asset}) {
      const index = state.assets.findIndex(a => a.id === id);
      if (index !== -1) {
          state.assets.splice(index, 1, asset);
      } else {
          state.assets.push(asset);
      }
    },
    SET_EVENTS(state, { type, events }) {
      state.events[type] = events;
    },
    SET_CATEGORIES(state, { type, categories }) {
      state.categories[type] = categories;
    },
    toggleDrawer(state) {
      state.drawer.asset.isOpen = !state.drawer.asset.isOpen; 
    },
    openDrawer(state) {
      state.drawer.asset.isOpen = true; 
    },
    closeDrawer(state) {
      state.drawer.asset.isOpen = false;
    },
    openEventDrawer(state) {
      state.drawer.event.isOpen = true; 
    },
    closeEventDrawer(state) {
      this.commit('SET_DRAWER_EVENT', { isOpen: false});
    },
    SET_DRAWER_ASSET_ID(state, id) {
      state.assetId = id; 
    },
    SET_DRAWER_EVENT_ID(state, id) {
      state.drawer.event.id = id; 
    },
    SET_DRAWER_EVENT(state, {isOpen, id, assetId, categoryId}) {
      state.drawer.event.isOpen = isOpen;
      state.drawer.event.id = id;
      state.drawer.event.assetId = assetId;
      state.drawer.event.categoryId = categoryId;
    },
    SET_NOTES(state, { assetId, notes }) {
        state.notes[assetId] = notes;
    },
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
        methods.handleUnauthorizedError(error, 'Error while logging out');
      }
    },

    async fetchAssets({ commit }) {
      try {
          const response = await apiClient.get('/assets');
          const assets = response.data.data;
          commit('SET_ASSETS', assets);  
        } catch (error) {
          methods.handleUnauthorizedError(error, 'Error fetching assets');
      }
    },

    async fetchAssetDetails({ commit }, { id }) {
      try {
          const response = await apiClient.get(`/assets/${id}`);
          const asset = response.data.data;
          commit('SET_ASSET_DETAILS', { id, asset });  
        } catch (error) {
          methods.handleUnauthorizedError(error, 'Error fetching assets');
      }
    },

    async fetchEvents({ commit }, { type }) {
      console.log('store fetchEvents');
      try {
        var response = {};
        if (type == 'All') {
          response = await apiClient.get('/events');
        } else {
          response = await apiClient.get('/events', { params: { active: type == 'Live' ? 1 : 0 } });
          console.log('store fetchEvents', response);
        }
        const events = response.data.data;
        commit('SET_EVENTS', { type, events });   
      } catch (error) {
        methods.handleUnauthorizedError(error, 'Error fetching events');
      } 
    },

    async fetchCategories({ commit }, { type }) {
      try {
        const response = await apiClient.get('/categories', { params: { type: type } });
        const categories = response.data.data;
        commit('SET_CATEGORIES', {type, categories}); 
      } catch (error) {
        methods.handleUnauthorizedError(error, 'Error fetching categories');
      }   
    },

    async fetchNotes({ commit }, { assetId }) {
      try {
        const response = await apiClient.get(`/assets/${assetId}/notes`, { params: { assetId: assetId } });
        const notes = response.data.data;
        commit('SET_CATEGORIES', {assetId, notes}); 
      } catch (error) {
        methods.handleUnauthorizedError(error, 'Error fetching notes');
      }   
    },
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
    getAssetDetails: (state) => (id) =>  {
      return state.assets.find(asset => asset.id === id);
    },
    getEvents: (state) => (type) => {
      return state.events[type] || [];
    },
    getCategories: (state)  => (type) => {
      return state.categories[type] || [];
    },
    getNotes: (state) => (assetId) => {
      return state.notes[assetId] || [];
    },
    isAssetDrawerOpen: (state) => state.drawer.asset.isOpen,
    assetDrawerId: (state) => state.assetId,

    eventDrawerIsOpen: (state) => state.drawer.event.isOpen,
    eventDrawerEventId: (state) => state.drawer.event.id,
    eventDrawerCategoryId: (state) => state.drawer.event.categoryId,
    eventDrawerAssetId: (state) => state.drawer.event.assetId,
  },
  modules: {
    //
  }
})

export default store;
