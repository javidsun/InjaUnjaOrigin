import axios from 'axios';

const getUserSidebarData = async () => {
    try {
        const response = await axios.get('/api/user-sidebar');
        return response.data;
    } catch (error) {
        console.error('Error fetching user sidebar data:', error);
        throw error;
    }
};

export { getUserSidebarData };
