import StepOneModalData from '../docs/StepOneModal.json';

export const useStepOneModalService = () => {
    const getPropertyTypes = () => {
        return StepOneModalData.propertyTypes;
    };

    const getAccommodationDetails = () => {
        return StepOneModalData.accommodationDetails;
    };

    const getModal4Options = () => {
        return StepOneModalData.modal4Options;
    };

    const getAmenities = () => {
        return StepOneModalData.amenities;
    };

    const getSpecialAmenities = () => {
        return StepOneModalData.specialAmenities;
    };

    const getSafetyFeatures = () => {
        return StepOneModalData.safetyFeatures;
    };

    const getDiscountOptions = () => {
        return StepOneModalData.discountOptions;
    };

    return {
        getPropertyTypes,
        getAccommodationDetails,
        getModal4Options,
        getAmenities,
        getSpecialAmenities,
        getSafetyFeatures,
        getDiscountOptions
    };
};
