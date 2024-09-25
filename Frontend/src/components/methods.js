import apiClient from "@/plugins/axios";

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
    }

};

export default methods;