import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export default {
    async getCompanions() {
        try {
            const response = await axios.get(`${API_BASE_URL}/companions`);
            return response.data.companions;
        } catch (error) {
            console.error('Error fetching companions:', error);
            throw error;
        }
    },

    async getCompanionById(id) {
        try {
            const response = await axios.get(`${API_BASE_URL}/companions/${id}`);
            return response.data;
        } catch (error) {
            console.error(`Error fetching companion with id ${id}:`, error);
            throw error;
        }
    }
};
