import axios from 'axios';

export const getWarningData = async () => {
  try {
    const response = await axios.get('/api/warning');
    return response.data;
  } catch (error) {
    console.error('Error fetching warning data:', error);
    throw error;
  }
};
