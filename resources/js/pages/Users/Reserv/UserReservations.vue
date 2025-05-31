<template class="cards">
    <v-card class="reservation-summary-card" outlined>
        <v-card-title>
            {{ translate("USERSIDEBAR_RECENTRESERVATIONS") }}
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
                    <v-card outlined class="reservation-card" @click="handleReservationClick(reservation)">
                        <v-img
                            :src="reservation.image"
                            aspect-ratio="1"
                            class="reservation-image"
                            height="100"
                            @error="handleImageError"
                        ></v-img>
                        <v-card-title>
                            <v-icon :color="reservation.color" class="reservation-icon">
                                {{ reservation.icon }}
                            </v-icon>
                            {{ reservation.title }}
                        </v-card-title>
                        <v-card-subtitle class="reservation-date">
                            {{ formatDate(reservation.date) }}
                        </v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-btn :to="'/MyReservations'" color="primary" outlined class="ml-auto">
                {{ translate("USERSIDEBAR_VIEWALLRESERVATIONS") }}
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
//Todo:id/title/date/icon/color/image/type

import { translate } from "@/store/languageStore";

export default {
    name: 'RecentReservationsCard',
    data() {
        return {
            recentReservations: [
                {
                    title: translate("USERSIDEBAR_HOUSERESERVATION"),
                    date: "2025-01-01",
                    icon: "mdi-home",
                    color: "blue",
                    image: "/ads/house.svg",
                    type: "house"
                },
                {
                    title: translate("USERSIDEBAR_CARRESERVATION"),
                    date: "2024-12-29",
                    icon: "mdi-car",
                    color: "green",
                    image: "/ads/car.svg",
                    type: "car"
                },
                {
                    title: translate("USERSIDEBAR_EVENTRESERVATION"),
                    date: "2024-12-25",
                    icon: "mdi-calendar",
                    color: "purple",
                    image: "/ads/event.svg",
                    type: "event"
                },
                {
                    title: translate("USERSIDEBAR_TRAVELERRESERVATION"),
                    date: "2024-12-20",
                    icon: "mdi-account-group",
                    color: "orange",
                    image: "/ads/firend.svg",
                    type: "traveler"
                }
            ],
            defaultImage: "/ads/default-image.svg"
        };
    },
    methods: {
        handleReservationClick(reservation) {
            try {
                this.$router.push(`/reservation-details/${reservation.type}/${reservation.date}`);
            } catch (error) {
                this.showErrorNotification("Failed to navigate to reservation details");
            }
        },

        formatDate(dateString) {
            try {
                const options = {year: 'numeric', month: 'long', day: 'numeric'};
                return new Date(dateString).toLocaleDateString(undefined, options);
            } catch (error) {
                this.showErrorNotification("Invalid date format");
                return dateString; // Return original if formatting fails
            }
        },

        handleImageError(event) {
            try {
                event.target.src = this.defaultImage;
            } catch (error) {
                console.log("Error handling image load failure");
            }
        },

        showErrorNotification(message) {
            this.$emit('show-error', message);
        },

        translate,
    }
};
</script>

<style scoped>
.reservation-summary-card {
    margin: 20px auto;
    padding: 20px;
    text-align: right;
    direction: rtl;
    box-shadow: none !important;
    color: var(--text-color);
}

.reservation-card {
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

.reservation-card:hover {
    transform: translateY(-8px) scale(1.05);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
}

.reservation-card:active {
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
</style>
