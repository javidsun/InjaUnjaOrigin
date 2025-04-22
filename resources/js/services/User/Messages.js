import axios from 'axios';

const API_BASE_URL = 'http://127.0.0.1:8003/api';

export default {
    async getMessages() {
        try {
            const response = await axios.get(`${API_BASE_URL}/messages`);
            return response.data;
        } catch (error) {
            console.error('Error fetching messages:', error);
            throw error;
        }
    },

    async sendMessage(messageData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/messages`, messageData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error sending message:', error);
            throw error;
        }
    },

    async sendReply(messageId, replyData) {
        try {
            const response = await axios.post(`${API_BASE_URL}/messages/${messageId}/replies`, replyData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error sending reply:', error);
            throw error;
        }
    },

    async closeMessage(messageId) {
        try {
            const response = await axios.put(`${API_BASE_URL}/messages/${messageId}/close`);
            return response.data;
        } catch (error) {
            console.error('Error closing message:', error);
            throw error;
        }
    }
};
