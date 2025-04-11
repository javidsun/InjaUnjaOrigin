<template>
    <v-container class="dashboard">
        <v-row dense>
            <v-col cols="12" md="3">
                <v-card class="special-offer-card" outlined>
                    <v-img :src="companionAds[0]?.image || '/ads/companion-default.jpg'" height="200px" />
                    <v-badge color="primary" content="همسفر" class="badge-title"></v-badge>
                    <v-card-title class="card-title">{{ companionAds[0]?.title || translate('CompanionAd.DefaultTitle') }}</v-card-title>
                    <v-divider></v-divider>
                    <v-card-text class="card-text">
                        <p>{{ companionAds[0]?.description || translate('CompanionAd.DefaultDescription') }}</p>
                        <v-btn :to="companionAds[0]?.link || '/companion-ads'" color="secondary" outlined>
                            {{ translate('CompanionAd.ViewButton') }}
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
                        v-for="(ad, index) in combinedAds"
                        :key="index"
                    >
                        <v-img :src="ad.image" height="350px" />
                        <div class="carousel-content">
                            <h3>{{ ad.title }}</h3>
                            <p>{{ ad.description }}</p>
                            <v-chip small :color="ad.type === 'companion' ? 'primary' : 'secondary'">
                                {{ ad.type === 'companion' ? translate('AdsCarousel.Companion') : translate('AdsCarousel.House') }}
                            </v-chip>
                        </div>
                    </v-carousel-item>
                </v-carousel>
            </v-col>

            <v-col cols="12" md="3">
                <v-card class="top-rated-card" outlined>
                    <v-img :src="topRatedAd.image" height="200px" />
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
import { ref, computed } from "vue";
import { translate } from "../../store/languageStore";

const specialOffer = ref({
    title: "پیشنهاد ویژه اروپا",
    description: "ویلاهای لوکس در جنوب فرانسه با تخفیف ویژه",
    image: "/ads/europe-special.jpg",
    link: "/europe/offers",
});

const companionAds = ref([
    {
        title: "همسفر برای تور اروپای مرکزی",
        description: "سفر 10 روزه به آلمان، اتریش و مجارستان",
        image: "/1010.png",
        link: "/companion/europe/1",
        type: "companion",
        details: {
            date: "15 ژوئن تا 25 ژوئن 2023",
            budget: "1200 یورو",
            gender: "مرد"
        }
    },
    {
        title: "همسفر برای سفر به ایتالیا",
        description: "به دنبال همسفر زن برای سفر به رم و فلورانس",
        image: "/1020.png",
        link: "/companion/europe/2",
        type: "companion",
        details: {
            date: "1 سپتامبر 2023",
            budget: "800 یورو",
            gender: "زن"
        }
    },
    {
        title: "کوچ سرفینگ در اسپانیا",
        description: "تجربه زندگی با locals در بارسلون ",
        image: "/1030.png",
        link: "/companion/europe/3",
        type: "companion",
        details: {
            date: "تمام تابستان 2023",
            budget: "500 یورو",
            gender: "مهم نیست"
        }
    }
]);

const houseAds = ref([
    {
        title: "آپارتمان در مرکز پاریس",
        description: "آپارتمان 2 خوابه نزدیک برج ایفل - امکانات کامل",
        image: "/rectangle-720.png",
        link: "/europe/housing/1",
        type: "house",
        details: {
            price: "95 یورو در شب",
            location: "پاریس، فرانسه",
            amenities: ["واي فاي", "تهويه مطبوع", "آشپزخانه مجهز"]
        }
    },
    {
        title: "ویلا در ساحل آلگاروه",
        description: "ویلای خصوصی با استخر و دسترسی مستقیم به ساحل",
        image: "/rectangle-2210.png",
        link: "/europe/housing/2",
        type: "house",
        details: {
            price: "180 یورو در شب",
            location: "آلگاروه، پرتغال",
            amenities: ["استخر خصوصی", "پارکينگ", "آشپزخانه حرفه اي"]
        }
    },
    {
        title: "کلبه چوبی در آلپ سوئیس",
        description: "منظره کوهستان ",
        image: "/rectangle-750.png",
        link: "/europe/housing/3",
        type: "house",
        details: {
            price: "150 یورو در شب",
            location: "زرمات، سوئیس",
            amenities: ["شومینه", "حمام سنگی", "تراس رو به کوه"]
        }
    }
]);

// ترکیب اگهی‌های خانه و همسفر برای اسلایدشو
const combinedAds = computed(() => {
    // ترکیب تصادفی
    return [...companionAds.value, ...houseAds.value]
        .sort(() => Math.random() - 0.5)
        .slice(0, 5); // نمایش 5 اگهی در اسلایدشو
});

const topRatedAd = ref({
    title: "برترین اقامتگاه اروپا 2023",
    description: "هتل بوتیک در ونیز با امتیاز 4.9 از 5",
    image: "/rectangle-2200.png",
    link: "/europe/top-rated",
    type: "house"
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
