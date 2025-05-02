<template>
    <div>
        <h2>Available ads</h2>
        <CategoryFilter @filter="filterAds" />
        <v-list>
            <v-list-item
                v-for="ad in filteredAds"
                :key="ad.id"
                @click="navigateToAd(ad.id)"
            >
                <v-list-item-content>
                    <v-list-item-title>{{ ad.title }}</v-list-item-title>
                    <v-list-item-subtitle>{{ ad.price }} Euro</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>
    </div>
</template>

<script>
//Todo: id/title/price/category_id/description/created_at/updated_at/images/user_id/location/location

import adService from "../../services/adService";
import CategoryFilter from "../Ad/CategoryFilter.vue";

export default {
    components: {
        CategoryFilter
    },
    data() {
        return {
            ads: [],
            filteredAds: []
        };
    },
    methods: {
        async fetchAds() {
            try {
                const response = await adService.getAds();
                this.ads = response.data;
                this.filteredAds = this.ads;
            } catch (error) {
                this.showError("Error receiving ads", error);
            }
        },
        filterAds(categoryId) {
            try {
                this.filteredAds = this.ads.filter(ad => ad.category_id === categoryId);
            } catch (error) {
                this.showError("Error filtering ads", error);
            }
        },
        navigateToAd(adId) {
            try {
                this.$router.push(`/ads/${adId}`);
            } catch (error) {
                this.showError("Error in moving to the ad page", error);
            }
        },
        showError(message, error) {
            console.error(message, error);
            this.$alert(message, "error", {
                type: "error",
                confirmButtonText: "I understand"
            });
        }
    },
    mounted() {
        this.fetchAds();
    }
};
</script>
