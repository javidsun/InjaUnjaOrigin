import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export const FeedbackService = {
    async submitFeedback(feedbackData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/feedback`, feedbackData);
            return response.data;
        } catch (error) {
            console.error('Error submitting feedback:', error);
            throw error;
        }
    },

    async contactSupport(contactData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/support`, contactData);
            return response.data;
        } catch (error) {
            console.error('Error contacting support:', error);
            throw error;
        }
    }
};
