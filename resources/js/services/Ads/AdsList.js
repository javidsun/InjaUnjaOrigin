import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export default {
    async getAds() {
        try {
            const response = await axios.get(`${API_BASE_URL}/ads`);
            return response;
        } catch (error) {
            console.error('Error fetching ads:', error);
            throw error;
        }
    },

    async getAdById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/ads/${id}`);
            return response;
        } catch (error) {
            console.error('Error fetching ad:', error);
            throw error;
        }
    },

    async filterAdsByCategory(categoryId) {
        try {
            const response = await axios.get(`${API_BASE_URL}/ads?category=${categoryId}`);
            return response;
        } catch (error) {
            console.error('Error filtering ads:', error);
            throw error;
        }
    }
};
