<template>
    <UserSidebar>

    <v-container fluid class="back">
        <v-row>
            <v-col cols="12">
                <v-card class="mb-4" outlined>
                    <v-card-title class="text-h5 title">
                        {{ translate("UserReservation.AllReservations") }}
                    </v-card-title>
                </v-card>
            </v-col>
        </v-row>

        <v-row>
            <v-col
                v-for="(reservation, index) in reservations"
                :key="index"
                cols="12"
                sm="6"
                md="4"
            >
                <v-card outlined class="reservation-card" @click="$inertia.visit(`/ReservationDetails/${index + 1}`)">
                    <v-img
                        :src="reservation.image"
                        aspect-ratio="1.7"
                        class="reservation-image"
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
                    <v-card-text class="title">
                        {{ reservation.description }}
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
    </UserSidebar>

</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref } from "vue";
import { translate } from "@/store/languageStore.js";
import UserSidebar from '../Layout.vue';

const reservations = ref([
    {
        title: translate("HouseReservation"),
        date: "2025-01-01",
        icon: "mdi-home",
        color: "blue",
        image: "/ads/house.svg",
        description: "رزرو خانه برای تاریخ 2025-01-01"
    },
    {
        title: translate("CarReservation"),
        date: "2024-12-29",
        icon: "mdi-car",
        color: "green",
        image: "/ads/car.svg",
        description: "رزرو ماشین برای تاریخ 2024-12-29"
    },
    {
        title: translate("EventReservation"),
        date: "2024-12-25",
        icon: "mdi-calendar",
        color: "purple",
        image: "/ads/event.svg",
        description: "رزرو بلیط رویداد برای تاریخ 2024-12-25"
    },
    {
        title: translate("TravelerReservation"),
        date: "2024-12-20",
        icon: "mdi-account-group",
        color: "orange",
        image: "/ads/firend.svg",
        description: "رزرو گروه مسافران برای تاریخ 2024-12-20"
    },
]);
</script>

<style scoped>
.reservation-card {
    margin: 10px auto;
    border-radius: 16px;
    min-height: 250px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    background-color: var(--backgroundcards-color--groups);
    color: var(--report-back2-color);
    box-sizing: border-box;
}

.reservation-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

.reservation-card:active {
    transform: translateY(2px) scale(0.97);
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.2);
}

.reservation-image {
    width: 100%;
    object-fit: cover;
    border-top-left-radius: 16px;
    border-top-right-radius: 16px;
}

.reservation-icon {
    font-size: 28px;
    margin-right: 8px;
}

.reservation-date {
    color: gray;
    font-style: italic;
}
.title{
    background-color: var(--background-color--groups3);
    text-align: center;
    color: var(--text-color);
}
.back{
    background-color: var(--background-color--groups3);

}

</style>
