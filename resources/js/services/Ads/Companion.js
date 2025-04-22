import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export default {
    /**
     * Create a new travel companion listing
     * @param {Object} listingData - The companion listing data
     * @returns {Promise} Axios response
     */
    createCompanionListing(listingData) {
        return axios.post(`${API_BASE_URL}/companions`, listingData);
    },

    /**
     * Update an existing travel companion listing
     * @param {String} id - The listing ID
     * @param {Object} listingData - The updated companion listing data
     * @returns {Promise} Axios response
     */
    updateCompanionListing(id, listingData) {
        return axios.put(`${API_BASE_URL}/companions/${id}`, listingData);
    },

    /**
     * Get a specific travel companion listing
     * @param {String} id - The listing ID
     * @returns {Promise} Axios response
     */
    getCompanionListing(id) {
        return axios.get(`${API_BASE_URL}/companions/${id}`);
    },

    /**
     * Delete a travel companion listing
     * @param {String} id - The listing ID
     * @returns {Promise} Axios response
     */
    deleteCompanionListing(id) {
        return axios.delete(`${API_BASE_URL}/companions/${id}`);
    },

    /**
     * Search for travel companion listings
     * @param {Object} filters - Search filters
     * @returns {Promise} Axios response
     */
    searchCompanionListings(filters = {}) {
        return axios.get(`${API_BASE_URL}/companions`, { params: filters });
    },

    /**
     * Upload photos for a companion listing
     * @param {String} id - The listing ID
     * @param {FormData} formData - FormData containing the photos
     * @returns {Promise} Axios response
     */
    uploadListingPhotos(id, formData) {
        return axios.post(`${API_BASE_URL}/companions/${id}/photos`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    },

    /**
     * Delete a photo from a companion listing
     * @param {String} id - The listing ID
     * @param {String} photoId - The photo ID
     * @returns {Promise} Axios response
     */
    deleteListingPhoto(id, photoId) {
        return axios.delete(`${API_BASE_URL}/companions/${id}/photos/${photoId}`);
    }
};
