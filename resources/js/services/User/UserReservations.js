import axios from 'axios';

const getReservations = async () => {
    try {
        const response = await axios.get('/api/user/reservations');
        return response.data.reservations;
    } catch (error) {
        console.error('Error fetching reservations:', error);
        return [];
    }
};

const createReservation = async (reservationData) => {
    try {
        const response = await axios.post('/api/user/reservations', reservationData);
        return response.data;
    } catch (error) {
        console.error('Error creating reservation:', error);
        throw error;
    }
};

export default {
    getReservations,
    createReservation
};
