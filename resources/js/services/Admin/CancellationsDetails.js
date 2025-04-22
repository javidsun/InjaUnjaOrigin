import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export const getCancellationDetails = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/admin/cancellations/details`);
    return response.data;
  } catch (error) {
    console.error('Error fetching cancellation details:', error);
    throw error;
  }
};

export const getCancellationsByType = async (type) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/admin/cancellations`, {
      params: { type }
    });
    return response.data;
  } catch (error) {
    console.error(`Error fetching ${type} cancellations:`, error);
    throw error;
  }
};

export const exportCancellations = async (type) => {
  try {
    const response = await axios.get(`${API_BASE_URL}/api/admin/cancellations/export`, {
      params: { type },
      responseType: 'blob'
    });
    return response.data;
  } catch (error) {
    console.error(`Error exporting ${type} cancellations:`, error);
    throw error;
  }
};
