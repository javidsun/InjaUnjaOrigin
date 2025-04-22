import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const UserProfileService = {
    // دریافت اطلاعات پروفایل کاربر
    getUserProfile: async () => {
        try {
            const response = await axios.get(`${API_BASE_URL}/user/profile`);
            return response.data;
        } catch (error) {
            console.error('Error fetching user profile:', error);
            throw error;
        }
    },

    // آپدیت اطلاعات پروفایل کاربر
    updateUserProfile: async (profileData) => {
        try {
            const response = await axios.put(`${API_BASE_URL}/user/profile`, profileData, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error updating user profile:', error);
            throw error;
        }
    },

    // آپلود پاسپورت
    uploadPassport: async (file) => {
        try {
            const formData = new FormData();
            formData.append('passport', file);

            const response = await axios.post(`${API_BASE_URL}/user/passport`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            return response.data;
        } catch (error) {
            console.error('Error uploading passport:', error);
            throw error;
        }
    }
};
