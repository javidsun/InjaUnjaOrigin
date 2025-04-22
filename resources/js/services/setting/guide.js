import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const guideService = {
    createGuide: async (guideData) => {
        try {
            const response = await axios.post(`${API_BASE_URL}/guides`, guideData);
            return response.data;
        } catch (error) {
            console.error('Error creating guide:', error);
            throw error;
        }
    },

    updateGuide: async (guideId, guideData) => {
        try {
            const response = await axios.put(`${API_BASE_URL}/guides/${guideId}`, guideData);
            return response.data;
        } catch (error) {
            console.error('Error updating guide:', error);
            throw error;
        }
    },

    getGuide: async (guideId) => {
        try {
            const response = await axios.get(`${API_BASE_URL}/guides/${guideId}`);
            return response.data;
        } catch (error) {
            console.error('Error getting guide:', error);
            throw error;
        }
    }
};
