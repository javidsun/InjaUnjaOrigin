import axios from 'axios';

const API_BASE_URL = '/api/access';

export const updateZoom = async (zoomLevel) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/zoom`, { zoomLevel });
        return response.data;
    } catch (error) {
        console.error('Error updating zoom level:', error);
        throw error;
    }
};

export const updatePan = async (panDirection) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/pan`, { panDirection });
        return response.data;
    } catch (error) {
        console.error('Error updating pan direction:', error);
        throw error;
    }
};
