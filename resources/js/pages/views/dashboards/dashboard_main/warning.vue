<template>
  <v-row class="gy-4">
    <v-col cols="12" sm="6" md="3">
      <div class="card-container fontsize ">
        <img src="/public/avatar1.svg" alt="Avatar" class="avatar" />
        <v-card class="card-info">
          <v-card-text>
            <h1>42</h1>
            <h2>{{ t('warning.followUp') }}</h2>

          </v-card-text>
        </v-card>
      </div>
    </v-col>

    <v-col cols="12" sm="6" md="3">
      <div class="card-container fontsize">
        <img src="/public/avatar2.svg" alt="Avatar" class="avatar" />
        <v-card class="card-error">
          <v-card-text>
            <h1>8</h1>
            <h2>{{ t('warning.cancelledReservations') }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>

    <v-col cols="12" sm="6" md="3">
      <div class="card-container fontsize">
        <img src="/public/avatar3.svg" alt="Avatar" class="avatar" />
        <v-card class="card-warning">
          <v-card-text>
            <h1>27</h1>
            <h2>{{ t('warning.pendingRequests') }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>

    <v-col cols="12" sm="6" md="3">
      <div class="card-container fontsize">
        <img src="/public/avatar4.svg" alt="Avatar" class="avatar avatar4" />
        <v-card class="card-success">
          <v-card-text>
            <h1>13</h1>
            <h2>{{ t('warning.successfulRequests') }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>
  </v-row>
</template>

<script>
import { t } from "../../../../store/languageStore";

export default {
  name: "Warning",
  setup() {
    return { t };
  },
};
</script>

<style scoped>
@import '../../../../../../resources/css/@core/template/lib/@layouts/styles/cards.scss';

.card-container {
  padding-top: 50px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.avatar4{
  top:-30px !important;
}
.avatar {
  position: absolute;
  top:0;
  right: 10px;
  width: 120px;
  z-index: 2;
}

@media (max-width: 950px) {
  .avatar {
    width: 80px;
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
