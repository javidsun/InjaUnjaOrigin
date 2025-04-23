import axios from "axios";

export default {
    getAds() {
        return axios.get("/api/ads");
    },

    getAdById(id) {
        return axios.get(`/api/ads/${id}`);
    },
};
