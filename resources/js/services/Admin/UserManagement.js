import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export default {
  // Get all users
  getUsers() {
    return axios.get(`${API_BASE_URL}/users`);
  },

  // Create a new user
  createUser(userData) {
    return axios.post(`${API_BASE_URL}/users`, userData);
  },

  // Update a user
  updateUser(userId, userData) {
    return axios.put(`${API_BASE_URL}/users/${userId}`, userData);
  },

  // Toggle user status
  toggleUserStatus(userId, status) {
    return axios.patch(`${API_BASE_URL}/users/${userId}/status`, { active: status });
  },

  // Get user activity history
  getUserActivities(userId) {
    return axios.get(`${API_BASE_URL}/users/${userId}/activities`);
  },

  // Get available roles
  getRoles() {
    return axios.get(`${API_BASE_URL}/roles`);
  }
};
