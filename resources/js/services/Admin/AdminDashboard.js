import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL || 'http://localhost:3000/api';

export default {
  /**
   * Fetches dashboard configuration from backend
   * @returns {Promise<Object>} Dashboard configuration
   */
  async getDashboardConfig() {
    try {
      const response = await axios.get(`${API_BASE_URL}/dashboard/config`);
      return response.data;
    } catch (error) {
      console.error('Error fetching dashboard config:', error);
      throw error;
    }
  },

  /**
   * Updates dashboard configuration
   * @param {Object} config - New configuration
   * @returns {Promise<Object>} Updated configuration
   */
  async updateDashboardConfig(config) {
    try {
      const response = await axios.put(`${API_BASE_URL}/dashboard/config`, config);
      return response.data;
    } catch (error) {
      console.error('Error updating dashboard config:', error);
      throw error;
    }
  },

  /**
   * Fetches dashboard statistics
   * @returns {Promise<Object>} Statistics data
   */
  async getDashboardStatistics() {
    try {
      const response = await axios.get(`${API_BASE_URL}/dashboard/statistics`);
      return response.data;
    } catch (error) {
      console.error('Error fetching dashboard statistics:', error);
      throw error;
    }
  }
};
