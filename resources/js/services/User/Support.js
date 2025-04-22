import axios from 'axios';

const SupportService = {
    getSupportData: async () => {
        try {
            const response = await axios.get('/api/support');
            return response.data;
        } catch (error) {
            console.error('Error fetching support data:', error);
            throw error;
        }
    },

    contactSupport: async (message) => {
        try {
            const response = await axios.post('/api/support/contact', { message });
            return response.data;
        } catch (error) {
            console.error('Error contacting support:', error);
            throw error;
        }
    }
};

export default SupportService;
