import axios from 'axios';

const API_BASE_URL = 'https://your-api-url.com/api';

export const getReportModalData = async () => {
    try {
        const response = await axios.get(`${API_BASE_URL}/report-modal`);
        return response.data;
    } catch (error) {
        console.error('Error fetching report modal data:', error);
        throw error;
    }
};

export const submitReport = async (reportData) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/reports`, reportData, {
            headers: {
                'Content-Type': 'application/json'
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error submitting report:', error);
        throw error;
    }
};
