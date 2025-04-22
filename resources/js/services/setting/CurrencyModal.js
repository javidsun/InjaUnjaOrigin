import currencyData from '../docs/CurrencyModal.json';

export const getCurrencyData = () => {
    return currencyData;
};

export const setUserCurrency = (currencyCode) => {
    //  بعداً برای ذخیره انتخاب کاربر استفاده شود
    console.log(`Selected currency: ${currencyCode}`);
    return { success: true, message: 'Currency updated successfully' };
};
