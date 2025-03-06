import axios from "axios";

export default {
    getAds() {
        return axios.get("/api/ads");
    },

    getAdById(id) {
        return axios.get(`/api/ads/${id}`);
    },
    createAd(data) {
        return axios.post("/api/ads", data, {
            headers: { "Content-Type": "multipart/form-data" },
        });
    },
    getMyAds() {
        return axios.get("/api/my-ads");
    },
    deleteAd(id) {
        return axios.delete(`/api/ads/${id}`);
    },
};
