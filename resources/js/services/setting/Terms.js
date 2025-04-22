import TermsData from '../docs/Terms.json';

export const getTermsData = () => {
    return TermsData;
};

export const getGuestConditions = () => {
    return TermsData.guestConditions;
};

export const getHostConditions = () => {
    return TermsData.hostConditions;
};

export const getGeneralConditions = () => {
    return TermsData.generalConditions;
};
