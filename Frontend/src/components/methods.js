import apiClient from "@/plugins/axios";
import Cookies from 'js-cookie';

const methods = {

    async deleteAsset(id) {
        const isConfirmed = window.confirm("Are you sure you want to delete this asset?");

        if (isConfirmed) {     
            try {
                await apiClient.delete(`/assets/${id}`);
                window.location.reload();
            } catch (error) {
                console.error("Failed to deleting asset:", error);
                alert("Failed to deleting asset.");
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
                console.error("Failed to deleting asset:", error);
                alert("Failed to deleting asset.");
            }
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