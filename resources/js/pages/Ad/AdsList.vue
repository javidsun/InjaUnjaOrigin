<!--فایل  AdsList.js در services      فایل   AdsList.json در پوشه docs -->


<template>
    <div>
        <h2>آگهی‌های موجود</h2>
        <CategoryFilter @filter="filterAds" />
        <v-list>
            <v-list-item v-for="ad in filteredAds" :key="ad.id" @click="$router.push(`/ads/${ad.id}`)">
                <v-list-item-content>
                    <v-list-item-title>{{ ad.title }}</v-list-item-title>
                    <v-list-item-subtitle>{{ ad.price }} Euro</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import { ref, onMounted } from "vue";
import adService from "../../services/Ads/AdDetails.JS";
import CategoryFilter from "../Ad/CategoryFilter.vue";

const ads = ref([]);
const filteredAds = ref([]);

const fetchAds = async () => {
    try {
        const response = await adService.getAds();
        ads.value = response.data;
        filteredAds.value = ads.value;
    } catch (error) {
        console.error("Error fetching ads:", error);
    }
};

const filterAds = (categoryId) => {
    filteredAds.value = ads.value.filter((ad) => ad.category_id === categoryId);
};

onMounted(fetchAds);
</script>
