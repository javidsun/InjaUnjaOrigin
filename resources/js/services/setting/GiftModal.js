import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const GiftModalService = {
    async purchaseGiftCard(giftCardData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/gift-cards`, giftCardData);
            return response.data;
        } catch (error) {
            console.error('Error purchasing gift card:', error);
            throw error;
        }
    },

    async getGiftCardHistory() {
        try {
            const response = await axios.get(`${API_BASE_URL}/gift-cards/history`);
            return response.data;
        } catch (error) {
            console.error('Error fetching gift card history:', error);
            throw error;
        }
    }
};
