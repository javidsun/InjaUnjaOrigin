import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL;

export const NotificationsService = {
  async sendReservationNotification(data) {
    return axios.post(`${API_BASE_URL}/notifications/reservation`, data);
  },

  async sendSystemAlert(data) {
    return axios.post(`${API_BASE_URL}/notifications/system-alert`, data);
  },

  async saveDraft(data) {
    return axios.post(`${API_BASE_URL}/notifications/drafts`, data);
  },

  async markAsRead(notificationId) {
    return axios.patch(`${API_BASE_URL}/notifications/${notificationId}/read`);
  },

  async deleteNotification(notificationId) {
    return axios.delete(`${API_BASE_URL}/notifications/${notificationId}`);
  },

  async getNotifications(params = {}) {
    return axios.get(`${API_BASE_URL}/notifications`, { params });
  },

  async getDrafts() {
    return axios.get(`${API_BASE_URL}/notifications/drafts`);
  },

  async editDraft(draftId, data) {
    return axios.put(`${API_BASE_URL}/notifications/drafts/${draftId}`, data);
  },

  async sendDraft(draftId) {
    return axios.post(`${API_BASE_URL}/notifications/drafts/${draftId}/send`);
  },

  async deleteDraft(draftId) {
    return axios.delete(`${API_BASE_URL}/notifications/drafts/${draftId}`);
  }
};
