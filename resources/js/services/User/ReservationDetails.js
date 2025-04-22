import reservationData from '../../../docs/User/ReservationDetails.json';

export const getReservationDetails = (id) => {
    // return axios.get(`/api/reservations/${id}`);

    return Promise.resolve(reservationData);
};
