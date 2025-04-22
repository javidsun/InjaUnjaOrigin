import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export default {
    async getAdById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/ads/${id}`);
            return response;
        } catch (error) {
            console.error('Error fetching ad:', error);
            throw error;
        }
    },

};
