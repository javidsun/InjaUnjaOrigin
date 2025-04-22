import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com';

export const MyAdsService = {
    async getAds() {
        try {
            const response = await axios.get(`${API_BASE_URL}/ads`);
            return response.data;
        } catch (error) {
            console.error('Error fetching ads:', error);
            throw error;
        }
    },

    async updateAd(adId, updatedData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/ads/${adId}`, updatedData);
            return response.data;
        } catch (error) {
            console.error('Error updating ad:', error);
            throw error;
        }
    },

    async deleteAd(adId) {
        try {
            const response = await axios.delete(`${API_BASE_URL}/ads/${adId}`);
            return response.data;
        } catch (error) {
            console.error('Error deleting ad:', error);
            throw error;
        }
    },

    async uploadAdImages(adId, images) {
        try {
            const formData = new FormData();
            images.forEach((image) => {
                formData.append('images', image);
            });

            const response = await axios.post(`${API_BASE_URL}/ads/${adId}/images`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            return response.data;
        } catch (error) {
            console.error('Error uploading images:', error);
            throw error;
        }
    }
};
