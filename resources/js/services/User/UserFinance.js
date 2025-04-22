import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export const FinanceService = {
    async getPayments() {
        try {
            const response = await axios.get(`${API_BASE_URL}/api/user/finance`);
            return response.data;
        } catch (error) {
            console.error('Error fetching payments:', error);
            throw error;
        }
    },

    async getPaymentDetails(paymentId) {
        try {
            const response = await axios.get(`${API_BASE_URL}/api/user/finance/${paymentId}`);
            return response.data;
        } catch (error) {
            console.error('Error fetching payment details:', error);
            throw error;
        }
    },

    async updatePaymentStatus(paymentId, status) {
        try {
            const response = await axios.put(`${API_BASE_URL}/api/user/finance/${paymentId}/status`, {
                status: status
            });
            return response.data;
        } catch (error) {
            console.error('Error updating payment status:', error);
            throw error;
        }
    }
};
