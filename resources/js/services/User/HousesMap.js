import axios from 'axios';

const API_BASE_URL = 'https://your-api-endpoint.com/api'; // Replace with actual API base URL

export const HousesMapService = {
    async searchLocations(searchQuery) {
        try {
            const response = await axios.get(`${API_BASE_URL}/houses/search`, {
                params: { query: searchQuery }
            });
            return response.data;
        } catch (error) {
            console.error('Error searching locations:', error);
            throw error;
        }
    },

    async getNearbyApartments(coordinates) {
        try {
            const response = await axios.get(`${API_BASE_URL}/houses/nearby`, {
                params: {
                    lat: coordinates.lat,
                    lng: coordinates.lng,
                    radius: 5 // km radius
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error fetching nearby apartments:', error);
            throw error;
        }
    },

    async getAllApartments() {
        try {
            const response = await axios.get(`${API_BASE_URL}/houses`);
            return response.data;
        } catch (error) {
            console.error('Error fetching all apartments:', error);
            throw error;
        }
    }
};
