import axios from 'axios';

const ReportsService = {
  getReportsData: async () => {
    try {
      const response = await axios.get('/api/reports');
      return response.data;
    } catch (error) {
      console.error('Error fetching reports data:', error);
      throw error;
    }
  },
};

export default ReportsService;
