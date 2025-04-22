import axios from 'axios';

const API_BASE_URL = 'https://api.yourdomain.com';

export const getUserDashboardData = async () => {
    try {
        const response = await axios.get(`${API_BASE_URL}/user/dashboard`, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error fetching user dashboard data:', error);
        throw error;
    }
};

export const updateUserPreferences = async (preferences) => {
    try {
        const response = await axios.put(`${API_BASE_URL}/user/preferences`, preferences, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error updating user preferences:', error);
        throw error;
    }
};

export const completeTutorial = async () => {
    try {
        const response = await axios.post(`${API_BASE_URL}/user/tutorial/complete`, {}, {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        });
        return response.data;
    } catch (error) {
        console.error('Error marking tutorial as complete:', error);
        throw error;
    }
};
