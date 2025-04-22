import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com/v1/ads/house';

export const AdsHouseService = {
  async createHouseAd(adData) {
    try {
      const response = await axios.post(`${API_BASE_URL}`, adData);
      return response.data;
    } catch (error) {
      console.error('Error creating house ad:', error);
      throw error;
    }
  },

  async getHouseAd(id) {
    try {
      const response = await axios.get(`${API_BASE_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error fetching house ad:', error);
      throw error;
    }
  },

  async updateHouseAd(id, adData) {
    try {
      const response = await axios.put(`${API_BASE_URL}/${id}`, adData);
      return response.data;
    } catch (error) {
      console.error('Error updating house ad:', error);
      throw error;
    }
  },

  async deleteHouseAd(id) {
    try {
      const response = await axios.delete(`${API_BASE_URL}/${id}`);
      return response.data;
    } catch (error) {
      console.error('Error deleting house ad:', error);
      throw error;
    }
  },

  async getAllHouseAds(params = {}) {
    try {
      const response = await axios.get(`${API_BASE_URL}`, { params });
      return response.data;
    } catch (error) {
      console.error('Error fetching all house ads:', error);
      throw error;
    }
  }
};
