import apiClient from "@/plugins/axios";
import store from "@/store";
import Cookies from 'js-cookie';

const methods = {

    async deleteAsset(id) {
        const isConfirmed = window.confirm("Are you sure you want to delete this asset?");

        if (isConfirmed) {     
            try {
                await apiClient.delete(`/assets/${id}`);
                window.location.reload();
            } catch (error) {
                this.handleUnauthorizedError(error, 'Failed to deleting asset.');
            }
        }
    },

    async deleteAssetList(list) {  
        if (list.length === 0) {
            alert("Please select assets to delete.");
            return;
        }
        const isConfirmed = window.confirm("Are you sure you want to delete this asset?");

        if (isConfirmed) {     
            try {
                await apiClient.delete('/assets', { data: { ids: list }});
                window.location.reload();
            } catch (error) {
                this.handleUnauthorizedError(error, 'Failed to deleting asset.');
            }
        }
    },

    async getEventCategoryCounts() {
        try {
            await store.dispatch('fetchEvents', {type: 'All'});
            await store.dispatch('fetchCategories', { type: "event" });
            
            const events = store.getters.getEvents('All');
            const categories = store.getters.getCategories('event');

            const result = {
            categoryName: [],
            counts: []
            };
            
            const countMap = {};
        
            events.forEach(event => {
            if (countMap[event.category_id]) {
                countMap[event.category_id]++;
            } else {
                countMap[event.category_id] = 1;
            }
            });
        
            categories.forEach(category => {
                result.categoryName.push(category.name);
                result.counts.push(countMap[category.id] || 0);
            });
            return result;
        } catch (error) {
            this.handleUnauthorizedError(error, 'Failed to get Event Category counts.');
        }
    },
      
    handleUnauthorizedError(error, errorMessage) {
        console.log('handleUnauthorizedError Error', error, errorMessage);
        if (error.response && error.status === 401) {
            Cookies.remove('auth_token', { path: '/' })
        } else {
            console.error(`${errorMessage}: `, error);
        }
    },

};

export default methods;