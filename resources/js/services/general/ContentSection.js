import contentData from '../../../docs/general/ContentSection.json';

export const getContentSectionData = () => {
    return contentData.contentSection;
};

export const getGroupData = (index) => {
    return contentData.contentSection.groups[index];
};

export const getAdvertisementData = () => {
    return contentData.contentSection.advertisements;
};

export const getMainBannerData = () => {
    return contentData.contentSection.mainBanner;
};
