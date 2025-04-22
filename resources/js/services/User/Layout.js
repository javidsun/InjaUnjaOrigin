import axios from 'axios';

const API_BASE_URL = 'https://your-api-url.com/api';

export const layoutService = {
    getLayoutConfig() {
        return axios.get(`${API_BASE_URL}/layout`);
    },
    updateLayoutConfig(config) {
        return axios.put(`${API_BASE_URL}/layout`, config);
    }
};
