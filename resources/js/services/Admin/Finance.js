import axios from 'axios';
import { API_BASE_URL } from '@/config';

export const FinanceService = {
  // Get payment statistics
  getPaymentStats() {
    return axios.get(`${API_BASE_URL}/finance/stats`);
  },

  // Get payments list
  getPayments(params) {
    return axios.get(`${API_BASE_URL}/finance/payments`, { params });
  },

  // Get refund requests
  getRefundRequests(params) {
    return axios.get(`${API_BASE_URL}/finance/refunds`, { params });
  },

  // Send message to user
  sendMessage(userId, messageData) {
    return axios.post(`${API_BASE_URL}/finance/message/${userId}`, messageData);
  },

  // Block user
  blockUser(userId, note) {
    return axios.post(`${API_BASE_URL}/finance/block/${userId}`, { note });
  },

  // Approve refund
  approveRefund(requestId, note) {
    return axios.post(`${API_BASE_URL}/finance/refunds/${requestId}/approve`, { note });
  },

  // Reject refund
  rejectRefund(requestId, note) {
    return axios.post(`${API_BASE_URL}/finance/refunds/${requestId}/reject`, { note });
  }
};
