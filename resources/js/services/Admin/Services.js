import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const getServices = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/services`);
    return response.data.services;
  } catch (error) {
    console.error('Error fetching services:', error);
    throw error;
  }
};

export const updateServiceCount = async (serviceId, newCount) => {
  try {
    const response = await axios.put(`${API_BASE_URL}/services/${serviceId}`, {
      count: newCount
    });
    return response.data;
  } catch (error) {
    console.error('Error updating service count:', error);
    throw error;
  }
};
