import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const SecurityModalService = {
    async changePassword(passwordData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/security/change-password`, passwordData);
            return response.data;
        } catch (error) {
            console.error('Error changing password:', error);
            throw error;
        }
    },

    async toggleAccountStatus(accountStatus) {
        try {
            const response = await axios.post(`${API_BASE_URL}/security/toggle-account`, accountStatus);
            return response.data;
        } catch (error) {
            console.error('Error toggling account status:', error);
            throw error;
        }
    }
};
