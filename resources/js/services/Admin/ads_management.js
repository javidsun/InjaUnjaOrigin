import axios from 'axios';
import { translate } from '../store/languageStore';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL || '/api';

export const getAds = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/admin/ads`);
    return response.data;
  } catch (error) {
    console.error('Error fetching ads:', error);
    throw new Error(translate('Admin_AdManagement.errors.fetch_ads_failed'));
  }
};

export const createAd = async (adData) => {
  try {
    const response = await axios.post(`${API_BASE_URL}/admin/ads`, adData);
    return response.data;
  } catch (error) {
    console.error('Error creating ad:', error);
    throw new Error(translate('Admin_AdManagement.errors.create_ad_failed'));
  }
};

export const updateAd = async (id, adData) => {
  try {
    const response = await axios.put(`${API_BASE_URL}/admin/ads/${id}`, adData);
    return response.data;
  } catch (error) {
    console.error('Error updating ad:', error);
    throw new Error(translate('Admin_AdManagement.errors.update_ad_failed'));
  }
};

export const approveAd = async (id) => {
  try {
    const response = await axios.patch(`${API_BASE_URL}/admin/ads/${id}/approve`);
    return response.data;
  } catch (error) {
    console.error('Error approving ad:', error);
    throw new Error(translate('Admin_AdManagement.errors.approve_ad_failed'));
  }
};

export const rejectAd = async (id) => {
  try {
    const response = await axios.patch(`${API_BASE_URL}/admin/ads/${id}/reject`);
    return response.data;
  } catch (error) {
    console.error('Error rejecting ad:', error);
    throw new Error(translate('Admin_AdManagement.errors.reject_ad_failed'));
  }
};

export const getAdCategories = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/admin/ads/categories`);
    return response.data;
  } catch (error) {
    console.error('Error fetching categories:', error);
    return ['ویلا', 'آپارتمان', 'سوئیت']; // Fallback to static data
  }
};
