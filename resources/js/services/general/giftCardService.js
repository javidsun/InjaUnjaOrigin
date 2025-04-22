import axios from 'axios';

export const purchaseGiftCard = async ({ amount, recipient, message }) => {
    try {
        const response = await axios.post('/api/giftcard/purchase', {
            amount,
            recipient,
            message,
        });
        return response.data;
    } catch (error) {
        if (error.response) {
            console.error('Error purchasing gift card:', error.response.data);
            throw error.response.data;
        } else if (error.request) {
            console.error('No response received:', error.request);
            throw { message: 'No response from server' };
        } else {
            console.error('Unexpected error:', error.message);
            throw { message: error.message };
        }
    }
};
