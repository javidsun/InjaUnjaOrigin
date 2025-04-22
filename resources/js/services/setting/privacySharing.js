import axios from 'axios';

export const privacySharingService = {
    async downloadUserData() {
        try {
            const response = await axios.get('/api/user/data');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async deleteAccount(confirmation) {
        try {
            const response = await axios.delete('/api/user/account', {
                data: { confirmation }
            });
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async saveThirdPartySettings(settings) {
        try {
            const response = await axios.post('/api/user/privacy/third-party', settings);
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async saveProfileVisibility(visibility) {
        try {
            const response = await axios.post('/api/user/privacy/visibility', { visibility });
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async getConnectedServices() {
        try {
            const response = await axios.get('/api/user/connected-services');
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    },

    async toggleServiceConnection(serviceId, connected) {
        try {
            const response = await axios.post(`/api/user/connected-services/${serviceId}`, { connected });
            return response.data;
        } catch (error) {
            throw error.response.data;
        }
    }
};
