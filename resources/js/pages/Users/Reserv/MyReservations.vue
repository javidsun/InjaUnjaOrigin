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
                    <v-card outlined class="reservation-card" @click="navigateToReservationDetails(index)">
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

<script>
//Todo:id/title/date/icon/color/image/description/status/created_at/updated_at

import UserSidebar from '../Layout.vue';
import { translate } from "@/store/languageStore";

export default {
    name: 'UserReservations',
    components: {
        UserSidebar
    },
    data() {
        return {
            reservations: [
                {
                    title: this.translate("HouseReservation"),
                    date: "2025-01-01",
                    icon: "mdi-home",
                    color: "blue",
                    image: "/ads/house.svg",
                    description: "رزرو خانه برای تاریخ 2025-01-01"
                },
                {
                    title: this.translate("CarReservation"),
                    date: "2024-12-29",
                    icon: "mdi-car",
                    color: "green",
                    image: "/ads/car.svg",
                    description: "رزرو ماشین برای تاریخ 2024-12-29"
                },
                {
                    title: this.translate("EventReservation"),
                    date: "2024-12-25",
                    icon: "mdi-calendar",
                    color: "purple",
                    image: "/ads/event.svg",
                    description: "رزرو بلیط رویداد برای تاریخ 2024-12-25"
                },
                {
                    title: this.translate("TravelerReservation"),
                    date: "2024-12-20",
                    icon: "mdi-account-group",
                    color: "orange",
                    image: "/ads/firend.svg",
                    description: "رزرو گروه مسافران برای تاریخ 2024-12-20"
                }
            ]
        };
    },
    methods: {
        translate,

        navigateToReservationDetails(reservationId) {
            try {
                this.$inertia.visit(`/ReservationDetails/${reservationId + 1}`);
            } catch (error) {
                this.showErrorAlert('Failed to navigate to reservation details');
                console.error('Navigation error:', error);
            }
        },

        showErrorAlert(message) {
            this.$emit('show-alert', {
                type: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#ff4444'
            });
        },
    }
};
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
