import axios from 'axios';

export const uploadAvatar = async (avatarData) => {
    try {
        const response = await axios.post('/api/upload-avatar', avatarData, {
            headers: {
                'Content-Type': 'application/json',
            },
        });
        return response.data;
    } catch (error) {
        console.error('Error uploading avatar:', error);
        throw error;
    }
};
