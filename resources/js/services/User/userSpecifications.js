import userSpecs from '../../../docs/User/userSpecifications.json';

export const getUserSpecifications = () => {
    return new Promise((resolve) => {
        setTimeout(() => {
            resolve(userSpecs);
        }, 500);
    });
};
