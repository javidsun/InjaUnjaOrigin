import axios from 'axios';

const WarningUserService = {
    getWarningUserData: async () => {
        try {
            const response = await axios.get('/api/warning-user');
            return response.data;
        } catch (error) {
            console.error('Error fetching warning user data:', error);
            throw error;
        }
    }
};

export default WarningUserService;
