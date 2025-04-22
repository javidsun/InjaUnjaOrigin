import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:3000/api';

export const SpecialOfferService = {
    async getSpecialOfferData() {
        try {
            const response = await axios.get(`${API_BASE_URL}/special-offer`);
            return response.data;
        } catch (error) {
            console.error('Error fetching special offer data:', error);
            throw error;
        }
    },

    async updateSpecialOffer(newData) {
        try {
            const response = await axios.put(`${API_BASE_URL}/special-offer`, newData);
            return response.data;
        } catch (error) {
            console.error('Error updating special offer:', error);
            throw error;
        }
    }
};
