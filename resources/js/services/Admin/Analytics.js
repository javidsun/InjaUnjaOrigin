import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL || 'https://api.yourdomain.com';

export const AnalyticsService = {
  async getAnalyticsData() {
    try {
      const response = await axios.get(`${API_BASE_URL}/analytics`);
      return response.data;
    } catch (error) {
      console.error('Error fetching analytics data:', error);
      throw error;
    }
  },

  async getConversionRate() {
    try {
      const response = await axios.get(`${API_BASE_URL}/analytics/conversion-rate`);
      return response.data;
    } catch (error) {
      console.error('Error fetching conversion rate:', error);
      throw error;
    }
  },

  async getRevenueByCategory() {
    try {
      const response = await axios.get(`${API_BASE_URL}/analytics/revenue-by-category`);
      return response.data;
    } catch (error) {
      console.error('Error fetching revenue by category:', error);
      throw error;
    }
  }
};
