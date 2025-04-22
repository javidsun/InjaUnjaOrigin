import axios from 'axios';

const API_BASE_URL = process.env.VUE_APP_API_BASE_URL;

export const getSidebarItems = async () => {
  try {
    const response = await axios.get(`${API_BASE_URL}/sidebar`);
    return response.data.menuItems;
  } catch (error) {
    console.error('Error fetching sidebar items:', error);
    throw error;
  }
};

export const updateSidebarItems = async (updatedItems) => {
  try {
    const response = await axios.put(`${API_BASE_URL}/sidebar`, {
      menuItems: updatedItems
    });
    return response.data;
  } catch (error) {
    console.error('Error updating sidebar items:', error);
    throw error;
  }
};
