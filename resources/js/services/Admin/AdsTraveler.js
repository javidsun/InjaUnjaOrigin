import axios from 'axios';

const API_BASE_URL = 'https://your-api-url.com/api';

export const AdsTravelerService = {
  async getAllAds() {
    try {
      const response = await axios.get(`${API_BASE_URL}/ads`);
      return response.data;
    } catch (error) {
      console.error('Error fetching travel ads:', error);
      throw error;
    }
  },

  async getAdById(id) {
    try {
      const response = await axios.get(`${API_BASE_URL}/ads/${id}`);
      return response.data;
    } catch (error) {
      console.error(`Error fetching ad with id ${id}:`, error);
      throw error;
    }
  },

  async createAd(adData) {
    try {
      const response = await axios.post(`${API_BASE_URL}/ads`, adData);
      return response.data;
    } catch (error) {
      console.error('Error creating ad:', error);
      throw error;
    }
  }
};
