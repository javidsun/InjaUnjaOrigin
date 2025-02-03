<template>
    <div>
        <h2>آگهی‌های من</h2>
        <v-list>
            <v-list-item v-for="ad in ads" :key="ad.id">
                <v-list-item-content>
                    <v-list-item-title>{{ ad.title }}</v-list-item-title>
                    <v-list-item-subtitle>{{ ad.price }} تومان</v-list-item-subtitle>
                </v-list-item-content>
                <v-btn @click="deleteAd(ad.id)" color="red">حذف</v-btn>
            </v-list-item>
        </v-list>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import adService from "../../services/adService";

const ads = ref([]);

const fetchAds = async () => {
    try {
        const response = await adService.getMyAds();
        ads.value = response.data;
    } catch (error) {
        console.error("Error fetching ads:", error);
    }
};

const deleteAd = async (id) => {
    try {
        await adService.deleteAd(id);
        ads.value = ads.value.filter((ad) => ad.id !== id);
    } catch (error) {
        console.error("Error deleting ad:", error);
    }
};

onMounted(fetchAds);
</script>
