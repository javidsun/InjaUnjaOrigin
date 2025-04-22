import axios from 'axios';

const API_BASE_URL = 'https://your-api-endpoint.com/api';

export const ReservationService = {
  async getReservationDetails() {
    try {
      const response = await axios.get(`${API_BASE_URL}/reservations/details`);
      return response.data;
    } catch (error) {
      console.error('Error fetching reservation details:', error);
      throw error;
    }
  },

  async getReservationsList() {
    try {
      const response = await axios.get(`${API_BASE_URL}/reservations`);
      return response.data;
    } catch (error) {
      console.error('Error fetching reservations list:', error);
      throw error;
    }
  },

  async exportReservationsToExcel(type) {
    try {
      const response = await axios.get(`${API_BASE_URL}/reservations/export`, {
        params: { type },
        responseType: 'blob'
      });
      return response.data;
    } catch (error) {
      console.error('Error exporting reservations:', error);
      throw error;
    }
  }
};
