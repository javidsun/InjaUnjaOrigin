<template>
    <v-container class="dashboard">
        <v-row dense>
            <v-col cols="12" md="3">
                <v-card class="special-offer-card" outlined>
                    <v-img :src="specialOffer.image" height="200px"/>
                    <v-badge color="primary" content="Special offer" class="badge-title"></v-badge>
                    <v-card-title class="card-title">{{ translate('SpecialOffer.Title') }}</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="card-text">
                        <p>{{ translate('SpecialOffer.Description') }}</p>
                        <v-btn :to="specialOffer.link" color="secondary" outlined>
                            {{ translate('SpecialOffer.ViewButton') }}
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>

            <v-col cols="12" md="6">
                <v-carousel
                    height="400px"
                    class="latest-ads-carousel"
                    cycle
                    interval="4000"
                >
                    <v-carousel-item
                        v-for="(ad, index) in latestAds"
                        :key="index"
                    >
                        <v-img :src="ad.image" height="350px"/>
                        <div class="carousel-content">
                            <h3>{{ translate('AdsCarousel.ModernHouse1') }}</h3>
                            <p>{{ translate('AdsCarousel.ModernHouseDescription1') }}</p>

                        </div>
                    </v-carousel-item>
                </v-carousel>
            </v-col>

            <v-col cols="12" md="3">
                <v-card class="top-rated-card" outlined>
                    <v-img :src="topRatedAd.image" height="200px"/>
                    <v-card-title class="card-title">{{ translate('TopRatedAd.Title') }}</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="card-text">
                        <p>{{ translate('TopRatedAd.Description') }}</p>
                        <v-btn :to="topRatedAd.link" color="secondary" outlined>
                            {{ translate('TopRatedAd.ViewButton') }}
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
import {ref} from "vue";
import {translate} from "@/store/languageStore.js";

const specialOffer = ref({
    title: "پیشنهاد ویژه برای شما",
    description: "یک خانه شیک و زیبا برای اجاره.",
    image: "/ads/special-offer.jpg",
    link: "/ads/special",
});

const latestAds = ref([
    {
        title: "خانه مدرن شماره 1",
        description: "خانه‌ای مدرن با امکانات کامل.",
        image: "/ads/house1.jpg",
        link: "/ads/1",
    },
    {
        title: "خانه زیبا شماره 2",
        description: "مکانی آرام و زیبا برای اقامت.",
        image: "/ads/house2.jpg",
        link: "/ads/2",
    },
]);

const topRatedAd = ref({
    title: "خانه برتر",
    description: "این خانه بیشترین امتیاز را دریافت کرده است.",
    image: "/ads/top-rated.jpg",
    link: "/ads/top-rated",
});
</script>

<style scoped>

.dashboard {
    margin-top: 20px;
    font-family: '2 Baran', sans-serif;
    margin-bottom: -20px;
}

.card-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: var(--txt-color);
    font-family: '2 Baran', sans-serif;
}

.card-text {
    font-size: 0.9rem;
    color: var(--sidebar-text-color);
    font-family: '2 Baran', sans-serif;
}

.special-offer-card,
.top-rated-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    background-color: var(--backgroundcards-color--groups);
    border-radius: 5%;
    margin-top: 20px;
}

.special-offer-card:hover,
.top-rated-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

.latest-ads-carousel .carousel-content {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    padding: 10px;
    border-radius: 25px;
}

.badge-title {
    position: absolute;
    top: 10px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1;
    font-size: 1.1rem;
    font-weight: bold;
    padding: 5px 10px;
    border-radius: 20px;
}

.v-img {
    object-fit: cover;
    height: 100%;
}

@media (max-width: 600px) {
    .dashboard {
        margin-top: 10px;
    }
}
</style>
