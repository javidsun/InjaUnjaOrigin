import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const getHouses = async (params = {}) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/houses`, { params });
        return response.data;
    } catch (error) {
        console.error('Error fetching houses:', error);
        throw error;
    }
};



export const createReservation = async (reservationData) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/reservations`, reservationData);
        return response.data;
    } catch (error) {
        console.error('Error creating reservation:', error);
        throw error;
    }
};

export const sendMessage = async (messageData) => {
    try {
        const response = await axios.post(`${API_BASE_URL}/messages`, messageData);
        return response.data;
    } catch (error) {
        console.error('Error sending message:', error);
        throw error;
    }
};

export const getHouseDetails = async (houseId) => {
    try {
        const response = await axios.get(`${API_BASE_URL}/houses/${houseId}`);
        return response.data;
    } catch (error) {
        console.error('Error fetching house details:', error);
        throw error;
    }
};
