import axios from 'axios';

export const getBasicStatistics = async () => {
    try {
        const response = await axios.get('/api/basic-statistics');
        return response.data;
    } catch (error) {
        console.error('Error fetching basic statistics:', error);
        throw error;
    }
};
