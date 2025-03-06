import { createStore } from 'vuex';

export default createStore({
    state: {
        ads: [], // لیست اگهی‌ها
    },
    mutations: {
        ADD_AD(state, ad) {
            state.ads.push({ ...ad, id: state.ads.length + 1 });
        },
    },
    actions: {
        saveAd({ commit }, ad) {
            commit('ADD_AD', ad);
        },
    },
    getters: {
        getAds: (state) => state.ads, // دریافت لیست اگهی‌ها
    },
});
