import api from '../api';

export const getNotificationsSettings = async () => {
    try {
        const response = await api.get('/notifications/settings');
        return response.data;
    } catch (error) {
        console.error('Error fetching notifications settings:', error);
        throw error;
    }
};

export const updateNotificationsSettings = async (settings) => {
    try {
        const response = await api.put('/notifications/settings', settings);
        return response.data;
    } catch (error) {
        console.error('Error updating notifications settings:', error);
        throw error;
    }
};
