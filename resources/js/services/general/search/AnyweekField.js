import axios from 'axios';

export default {
    methods: {
        sendDataToBackend(email, password, remember, selectedDates) {
            const data = {
                email: email,
                password: password,
                remember: remember,
                selected_dates: selectedDates
            };

            axios.post('/api/anyweek', data)
                .then(response => {
                    console.log('Data sent successfully:', response.data);
                })
                .catch(error => {
                    console.error('Error sending data:', error);
                });
        }
    }
};
