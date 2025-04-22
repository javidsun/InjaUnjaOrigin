import axios from 'axios';

const API_BASE_URL = 'https://your-api-base-url.com/api';

export const SupportSystemService = {
  // دریافت لیست پیام‌ها
  getMessages() {
    return axios.get(`${API_BASE_URL}/support-messages`);
  },

  // ارسال پیام جدید
  sendMessage(messageData) {
    return axios.post(`${API_BASE_URL}/support-messages`, messageData);
  },

  // دریافت لیست کاربران
  getUsers() {
    return axios.get(`${API_BASE_URL}/users`);
  },

  // به‌روزرسانی وضعیت پیام
  updateMessageStatus(messageId, status) {
    return axios.patch(`${API_BASE_URL}/support-messages/${messageId}`, { status });
  },

  // حذف پیام
  deleteMessage(messageId) {
    return axios.delete(`${API_BASE_URL}/support-messages/${messageId}`);
  }
};
