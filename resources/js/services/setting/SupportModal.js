import axios from 'axios';

const supportService = {
    getSupportQuestions: async () => {
        try {
            // آدرس واقعی API جایگزین شود
            const response = await axios.get('/api/support/questions');
            return response.data;
        } catch (error) {
            console.error('Error fetching support questions:', error);
            throw error;
        }
    },

    contactSupport: async (message) => {
        try {
            //  آدرس واقعی API جایگزین شود
            const response = await axios.post('/api/support/contact', {
                message: message
            });
            return response.data;
        } catch (error) {
            console.error('Error contacting support:', error);
            throw error;
        }
    }
};

export default supportService;
