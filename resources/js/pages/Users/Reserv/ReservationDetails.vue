<!--فایل  ReservationDetails.js در services      فایل   ReservationDetails.json در پوشه docs -->


<template >
    <UserSidebar>
        <v-container fluid class="back">
            <v-row>
                <v-col cols="12">
                    <v-card class="mb-4" outlined>
                        <v-card-title class="text-h5 title">
                            {{ reservation.title }}
                        </v-card-title>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-img :src="reservation.image" class="reservation-image"></v-img>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card outlined class="details-card">
                        <v-card-title>
                            <v-icon :color="reservation.color" class="reservation-icon">
                                {{ reservation.icon }}
                            </v-icon>
                            {{ reservation.title }}
                        </v-card-title>
                        <v-card-subtitle class="reservation-date">
                            {{ reservation.date }}
                        </v-card-subtitle>
                        <v-card-text>
                            <p>{{ reservation.description }}</p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </UserSidebar>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import UserSidebar from "../Layout.vue";

const props = defineProps({
    id: String
});

const reservationId = ref(parseInt(props.id));

const reservations = ref([
    {
        id: 1,
        title: "رزرو خانه",
        date: "2025-01-01",
        icon: "mdi-home",
        color: "blue",
        image: "/ads/house.svg",
        description: "رزرو خانه برای تاریخ 2025-01-01",
    },
    {
        id: 2,
        title: "رزرو ماشین",
        date: "2024-12-29",
        icon: "mdi-car",
        color: "green",
        image: "/ads/car.svg",
        description: "رزرو ماشین برای تاریخ 2024-12-29",
    },
    {
        id: 3,
        title: "EventReservation",
        date: "2024-12-25",
        icon: "mdi-calendar",
        color: "purple",
        image: "/ads/event.svg",
        description: "رزرو بلیط رویداد برای تاریخ 2024-12-25",
    },
    {
        id: 4,
        title: "TravelerReservation",
        date: "2024-12-20",
        icon: "mdi-account-group",
        color: "orange",
        image: "/ads/firend.svg",
        description: "رزرو گروه مسافران برای تاریخ 2024-12-20",
    },
]);

const reservation = ref({});

onMounted(() => {
    reservation.value = reservations.value.find((r) => r.id === reservationId.value) || {};
});
</script>

<style scoped>
.details-card {
    padding: 20px;
    border-radius: 16px;
}

.reservation-image {
    width: 100%;
    object-fit: cover;
    border-radius: 16px;
}

.reservation-icon {
    font-size: 32px;
    margin-right: 10px;
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
