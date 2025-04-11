<template class="cards">
    <v-card class="reservation-summary-card" outlined>
        <v-card-title>
            {{ translate("UserSidebar.RecentReservations") }}
        </v-card-title>
        <v-card-text>
            <v-row direction="rtl">
                <v-col
                    v-for="(reservation, index) in recentReservations"
                    :key="index"
                    cols="12"
                    md="6"
                    lg="3"
                    class="recentReservations"
                >
                    <div @click="goToPage(reservation.link)" class="reservation-link">
                        <v-card
                            outlined
                            class="reservation-card"
                            hover
                        >
                            <v-img
                                :src="reservation.image"
                                aspect-ratio="1"
                                class="reservation-image"
                                height="100"
                            ></v-img>
                            <v-card-title>
                                <v-icon :color="reservation.color" class="reservation-icon">
                                    {{ reservation.icon }}
                                </v-icon>
                                {{ reservation.title }}
                            </v-card-title>
                            <v-card-subtitle class="reservation-date">
                                {{ reservation.date }}
                            </v-card-subtitle>
                        </v-card>
                    </div>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import { ref } from 'vue';
import { translate } from "../../../store/languageStore";
import { Inertia } from '@inertiajs/inertia';

const goToPage = (link) => {
    Inertia.visit(link);
};

const recentReservations = ref([
    {
        title: translate("HouseReservation"),
        date: "2025-01-01",
        icon: "mdi-home",
        color: "blue",
        image: "/ads/house.svg",
        link: "/houses"
    },
    {
        title: translate("CarReservation"),
        date: "2024-12-29",
        icon: "mdi-car",
        color: "green",
        image: "/ads/car.svg",
        link: "/vehicles"
    },
    {
        title: translate("EventReservation"),
        date: "2024-12-25",
        icon: "mdi-calendar",
        color: "purple",
        image: "/ads/event.svg",
        link: "/events"
    },
    {
        title: translate("TravelerReservation"),
        date: "2024-12-20",
        icon: "mdi-account-group",
        color: "orange",
        image: "/ads/firend.svg",
        link: "/travelers"
    },
]);
</script>

<style scoped>
.reservation-summary-card {
    margin: 20px auto;
    padding: 20px;
    text-align: right;
    direction: rtl;
    box-shadow: none!important;
    color: var(--text-color);
}

.reservation-card {
    padding: 0;
    margin: 0;
    text-transform: none;
    display: block;
}

.reservation-card-inner {
    margin: 10px auto;
    border-radius: 16px;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    background-color: var(--backgroundcards-color--groups);
    color: var(--report-back2-color);
    box-sizing: border-box;
}

.reservation-card-inner:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

.reservation-card-inner:active {
    transform: translateY(2px) scale(0.97);
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
}

.reservation-image {
    width: 50%;
    margin: 0 auto;
    border-radius: 8px;
    height: auto;
}

.reservation-icon {
    font-size: 28px;
    margin-right: 8px;
}

.reservation-date {
    color: gray;
    font-style: italic;
}

.reservation-link {
    cursor: pointer;
}

</style>
