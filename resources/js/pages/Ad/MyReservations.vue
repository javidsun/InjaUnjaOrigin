<template>
    <v-container>
        <h2 class="text-h4 font-weight-bold text-primary mb-4">رزروهای من</h2>

        <v-row v-if="reservations.length">
            <v-col
                v-for="reservation in reservations"
                :key="reservation.id"
                cols="12"
                md="6"
                lg="4"
            >
                <v-card class="reservation-card">
                    <v-img
                        :src="reservation.post.image"
                        height="180px"
                        cover
                    ></v-img>

                    <v-card-title class="text-h6">
                        {{ reservation.post.title }}
                    </v-card-title>

                    <v-card-subtitle class="text-grey">
                        {{ formatDate(reservation.created_at) }}
                    </v-card-subtitle>

                    <v-card-text>
                        <p>
                            <strong>قیمت:</strong> {{ reservation.post.price }} تومان
                        </p>
                        <v-chip :color="getStatusColor(reservation.status)" dark>
                            {{ reservation.status }}
                        </v-chip>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="red" @click="cancelReservation(reservation.id)">
                            <v-icon left>mdi-cancel</v-icon>
                            لغو رزرو
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-alert v-else type="info" variant="outlined">
            هنوز هیچ رزروی انجام نداده‌اید.
        </v-alert>
    </v-container>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const reservations = ref([]);

const fetchReservations = async () => {
    try {
        const response = await axios.get("/api/my-reservations");
        reservations.value = response.data;
    } catch (error) {
        console.error("خطا در دریافت رزروها:", error);
    }
};

const cancelReservation = async (id) => {
    try {
        await axios.delete(`/api/reservations/${id}`);
        reservations.value = reservations.value.filter((r) => r.id !== id);
    } catch (error) {
        console.error("خطا در لغو رزرو:", error);
    }
};

const formatDate = (date) => new Date(date).toLocaleDateString("fa-IR");

const getStatusColor = (status) => {
    return status === "فعال"
        ? "green"
        : status === "در انتظار"
            ? "orange"
            : "red";
};

onMounted(fetchReservations);
</script>

<style scoped>
.reservation-card {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.3s;
}

.reservation-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
</style>
