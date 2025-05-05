<template>
    <UserSidebar>
        <v-container fluid class="back">
            <v-row>
                <v-col cols="12">
                    <v-card class="mb-4" outlined>
                        <v-card-title class="text-h5 title">
                            {{ currentReservation.title }}
                        </v-card-title>
                    </v-card>
                </v-col>
            </v-row>

            <v-row>
                <v-col cols="12" md="6">
                    <v-img :src="currentReservation.image" class="reservation-image"></v-img>
                </v-col>
                <v-col cols="12" md="6">
                    <v-card outlined class="details-card">
                        <v-card-title>
                            <v-icon :color="currentReservation.color" class="reservation-icon">
                                {{ currentReservation.icon }}
                            </v-icon>
                            {{ currentReservation.title }}
                        </v-card-title>
                        <v-card-subtitle class="reservation-date">
                            {{ currentReservation.date }}
                        </v-card-subtitle>
                        <v-card-text>
                            <p>{{ currentReservation.description }}</p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </UserSidebar>
</template>

<script>
import UserSidebar from "../Layout.vue";

export default {
    name: 'ReservationDetail',
    components: {
        UserSidebar
    },
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            allReservations: [
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
            ],
            currentReservation: {},
            isLoading: false,
            error: null
        };
    },
    computed: {
        parsedReservationId() {
            try {
                return parseInt(this.id);
            } catch (error) {
                this.handleError("Invalid reservation ID format", error);
                return null;
            }
        }
    },
    mounted() {
        this.loadReservation();
    },
    methods: {

        loadReservation() {
            try {
                if (!this.parsedReservationId) {
                    this.handleError("No valid reservation ID provided");
                    return;
                }

                this.isLoading = true;
                const foundReservation = this.allReservations.find(
                    item => item.id === this.parsedReservationId
                );

                if (foundReservation) {
                    this.currentReservation = foundReservation;
                } else {
                    this.handleError("Reservation not found");
                }
            } catch (error) {
                this.handleError("Failed to load reservation details", error);
            } finally {
                this.isLoading = false;
            }
        },

        handleError(message, error) {
            this.error = message;
            this.$emit('error', { message, error });

            if (error) {
                console.error(`Technical Error Details: ${error.message}`);
            }
        }
    }
};
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

.title {
    background-color: var(--background-color--groups3);
    text-align: center;
    color: var(--text-color);
}

.back {
    background-color: var(--background-color--groups3);
}
</style>
