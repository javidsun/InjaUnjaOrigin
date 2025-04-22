import axios from 'axios';

export const sendGuestData = async (guestData) => {
    try {
        const response = await axios.post('/api/guests', {
            adults: guestData.adults,
            children: guestData.children,
            infants: guestData.infants,
            pets: guestData.pets,
        });
        return response.data;
    } catch (error) {
        console.error('Error sending guest data:', error);
        throw error;
    }
};
