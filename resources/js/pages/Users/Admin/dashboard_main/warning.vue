<template>
    <v-row class="gy-4">
        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/avatar1.svg" alt="Avatar" class="avatar" />
                <v-card class="card-info" @click="handleCardClick('follow-up')">
                    <v-card-text>
                        <h1 class="card-info2">{{ cardData.followUp.count }}</h1>
                        <h2 class="card-info3">{{ translate('warning.followUp') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/avatar4.svg" alt="Avatar" class="avatar avatar4" />
                <v-card class="card-success" @click="handleCardClick('successful')">
                    <v-card-text>
                        <h1 class="card-info2">{{ cardData.successful.count }}</h1>
                        <h2 class="card-info3">{{ translate('warning.successfulRequests') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>
        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/avatar3.svg" alt="Avatar" class="avatar" />
                <v-card class="card-warning" @click="handleCardClick('pending')">
                    <v-card-text>
                        <h1 class="card-info2">{{ cardData.pending.count }}</h1>
                        <h2 class="card-info3">{{ translate('warning.pendingRequests') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>

        <v-col cols="12" sm="6" md="3">
            <div class="card-container fontsize">
                <img src="/avatar2.svg" alt="Avatar" class="avatar" />
                <v-card class="card-error" @click="handleCardClick('cancelled')">
                    <v-card-text>
                        <h1 class="card-info2">{{ cardData.cancelled.count }}</h1>
                        <h2 class="card-info3">{{ translate('warning.cancelledReservations') }}</h2>
                    </v-card-text>
                </v-card>
            </div>
        </v-col>
    </v-row>
</template>

<script>
//Todo:dashboard_stats": {follow_up: count/ label }/{successful: count/ label }/{pending: count/ label }/{cancelled: count/ label }


import { translate } from "@/store/languageStore.js";

export default {
    name: "warning",
    data() {
        return {
            cardData: {
                followUp: {
                    count: 42,
                    route: '/ReservationManagement?type=follow-up'
                },
                successful: {
                    count: 13,
                    route: '/ReservationManagement?type=successful'
                },
                pending: {
                    count: 27,
                    route: '/ReservationManagement?type=pending'
                },
                cancelled: {
                    count: 8,
                    route: '/ReservationManagement?type=cancelled'
                }
            }
        }
    },
    methods: {
        translate,

        handleCardClick(cardType) {
            try {
                if (!this.cardData[cardType]) {
                    throw new Error(`Invalid card type: ${cardType}`);
                }
                window.location.href = this.cardData[cardType].route;
            } catch (error) {
                this.showErrorAlert(error.message);
            }
        },


        showErrorAlert(message) {
            alert(`Error: ${message}`);
        },

    }
};
</script>

<style scoped>
@import '../../../../../css/@core/template/lib/@layouts/styles/cards.scss';

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
