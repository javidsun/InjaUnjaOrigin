import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const getUserSettings = async () => {
    try {
        const response = await axios.get(`${API_BASE_URL}/user/settings`);
        return response.data;
    } catch (error) {
        console.error('Error fetching user settings:', error);
        throw error;
    }
};

export const updateUserSettings = async (settingsData) => {
    try {
        const response = await axios.put(`${API_BASE_URL}/user/settings`, settingsData);
        return response.data;
    } catch (error) {
        console.error('Error updating user settings:', error);
        throw error;
    }
};
