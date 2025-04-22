
/**
 * This is a static component and doesn't require backend API calls.
 * The data is managed locally within the component.
 *
 * For reference, the expected data structure is documented in:
 * docs/HowItWorksModal.json
 */

export const getHowItWorksData = () => {
    // In a dynamic implementation, this would fetch from backend
    // return axios.get('/api/how-it-works');
    console.log('HowItWorksModal is a static component - no API calls needed');
    return null;
};

export default {
    getHowItWorksData
};
