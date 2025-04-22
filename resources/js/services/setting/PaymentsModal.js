import axios from 'axios';

export const PaymentService = {
    // شارژ کیف پول
    chargeWallet: async (amount, currency = 'IRR') => {
        try {
            const response = await axios.post('/api/wallet/charge', {
                amount,
                currency
            });
            return response.data;
        } catch (error) {
            console.error('Error charging wallet:', error);
            throw error;
        }
    },

    // پرداخت آنلاین
    processOnlinePayment: async (paymentData) => {
        try {
            const response = await axios.post('/api/payment/online', paymentData);
            return response.data;
        } catch (error) {
            console.error('Error processing online payment:', error);
            throw error;
        }
    },

    // لیست کوپن‌های کاربر
    getUserCoupons: async () => {
        try {
            const response = await axios.get('/api/user/coupons');
            return response.data;
        } catch (error) {
            console.error('Error fetching user coupons:', error);
            throw error;
        }
    },

    // دریافت اطلاعات مالی کاربر
    getUserFinance: async () => {
        try {
            const response = await axios.get('/api/user/finance');
            return response.data;
        } catch (error) {
            console.error('Error fetching user finance:', error);
            throw error;
        }
    }
};
