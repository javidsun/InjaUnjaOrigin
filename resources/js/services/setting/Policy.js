import axios from 'axios';

const POLICY_API = '/api/policy';

export const getPolicyData = async () => {
    try {
        const response = await axios.get(POLICY_API);
        return response.data;
    } catch (error) {
        console.error('Error fetching policy data:', error);
        throw error;
    }
};

