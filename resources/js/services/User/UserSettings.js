import axios from 'axios';

const API_BASE_URL = '/api/user/settings';

export const getUserSettings = async () => {
    try {
        const response = await axios.get(API_BASE_URL);
        return response.data;
    } catch (error) {
        console.error('Error fetching user settings:', error);
        throw error;
    }
};

export const updateUserProfile = async (userData) => {
    try {
        const response = await axios.put(`${API_BASE_URL}/profile`, userData);
        return response.data;
    } catch (error) {
        console.error('Error updating user profile:', error);
        throw error;
    }
};

export const updateUserSettings = async (settingsData) => {
    try {
        const response = await axios.put(`${API_BASE_URL}/preferences`, settingsData);
        return response.data;
    } catch (error) {
        console.error('Error updating user settings:', error);
        throw error;
    }
};
