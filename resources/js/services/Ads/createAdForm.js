import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL;

export const createAdService = {
    async createAccommodationAd(adData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/ads/accommodation`, adData);
            return response.data;
        } catch (error) {
            console.error('Error creating accommodation ad:', error);
            throw error;
        }
    },

    async createCompanionAd(adData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/ads/companion`, adData);
            return response.data;
        } catch (error) {
            console.error('Error creating companion ad:', error);
            throw error;
        }
    },

    async createVehicleAd(adData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/ads/vehicle`, adData);
            return response.data;
        } catch (error) {
            console.error('Error creating vehicle ad:', error);
            throw error;
        }
    }
};
