<template>
    <v-row class="gy-4">
        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/public/avatar1.svg" alt="Avatar" class="avatar" />
                <v-card class="card-info" @click="goToReservations('follow-up')">
                    <v-card-text>
                        <h1 class="card-info2">42</h1>
                        <h2 class="card-info3">{{ translate('warning.followUp') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/public/avatar4.svg" alt="Avatar" class="avatar avatar4" />
                <v-card class="card-success" @click="goToReservations('successful')">
                    <v-card-text>
                        <h1 class="card-info2">13</h1>
                        <h2 class="card-info3">{{ translate('warning.successfulRequests') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>
        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/public/avatar3.svg" alt="Avatar" class="avatar" />
                <v-card class="card-warning" @click="goToReservations('pending')">
                    <v-card-text>
                        <h1 class="card-info2">27</h1>
                        <h2 class="card-info3">{{ translate('warning.pendingRequests') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/public/avatar2.svg" alt="Avatar" class="avatar" />
                <v-card class="card-error" @click="goToReservations('cancelled')">
                    <v-card-text>
                        <h1 class="card-info2">8</h1>
                        <h2 class="card-info3">{{ translate('warning.cancelledReservations') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

    </v-row>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: "Warning",
    setup() {
        const goToReservations = (type) => {
            window.location.href = `/ReservationManagement?type=${type}`;
        };

        return { translate, goToReservations };
    },
};
</script>

<style scoped>
@import '../../../../css/@core/template/lib/@layouts/styles/cards.scss';

.card-container {
    padding-top: 50px;
    position: relative;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.avatar4 {
    top: -30px !important;
}

.avatar {
    position: absolute;
    top: 0;
    right: 10px;
    width: 120px;
    z-index: 2;
}

@media (max-width: 950px) {
    .avatar {
        width: 80px;
    }

    .card-info3{
        font-size: 14px!important;
    }

    .card-info,
    .card-error,
    .card-warning,
    .card-success {
        height: auto;
        margin-bottom: 16px;
        font-size: 12px;
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.card-info,
.card-error,
.card-warning,
.card-success {
    position: relative;
    padding-top: 50px;
    overflow: hidden;
    width: 100%;
    height: 150px;
    text-align: center;
    border-radius: 12px;
}

.card-info {
    background-color: #d0f0fd;
    color: #007bff;
    font-size: 50px;
}

.card-info2 {
    font-size: 20px;
}

.card-error {
    background-color: #f8d7da;
    color: #dc3545;
}

.card-warning {
    background-color: #fff3cd;
    color: #ffc107;
}

.card-success {
    background-color: #d4edda;
    color: #28a745;
}
</style>
