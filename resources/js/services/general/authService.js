import axios from 'axios';

export const register = async ({ name, email, password ,password_confirmation }) => {
    try {
        const response = await axios.post('/api/register', {
            name,
            email,
            password,
            password_confirmation,

        });
        return response.data;
    } catch (error) {
        if (error.response) {
            console.error('Registration error:', error.response.data);
            throw error.response.data;
        } else if (error.request) {
            console.error('No response received:', error.request);
            throw { message: 'No response from server' };
        } else {
            console.error('Unexpected error:', error.message);
            throw { message: error.message };
        }
    }
};

export const login = async ({ email, password, remember }) => {
    try {
        const response = await axios.post('/api/login', {
            email,
            password,
            remember
        });
        return response.data;
    } catch (error) {
        if (error.response) {
            console.error('Login error:', error.response.data);
            throw error.response.data;
        } else if (error.request) {
            console.error('No response received:', error.request);
            throw { message: 'No response from server' };
        } else {
            console.error('Unexpected error:', error.message);
            throw { message: error.message };
        }
    }
};
export const forgotPassword = async (email) => {
    try {
        const response = await axios.post('/api/forgot-password', {
            email,
        });
        return response.data;
    } catch (error) {
        if (error.response) {
            console.error('Forgot Password error:', error.response.data);
            throw error.response.data;
        } else if (error.request) {
            console.error('No response received:', error.request);
            throw { message: 'No response from server' };
        } else {
            console.error('Unexpected error:', error.message);
            throw { message: error.message };
        }
    }
};

export const resendVerificationEmail = async (email) => {
    try {
        const response = await axios.post('/api/resend-verification-email', { email });
        return response.data;
    } catch (error) {
        console.error('Error sending verification email:', error);
        throw error;
    }
};
