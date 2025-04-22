<!--فایل  WarningUser.js در services      فایل   WarningUser.json در پوشه docs -->


<template>
  <v-row class="gy-4" justify="start" align="center">
    <v-col cols="12" sm="6" md="4">
      <div class="card-container fontsize">
          <img src="/assets/images/user-vaziyat.svg" alt="Avatar" class="avatar" />

          <v-card class="card-info">
          <v-card-text>
            <h1>{{ translate("warningUser.subscriptionStatus2") }}</h1>
            <h2>{{ translate("warningUser.subscriptionStatus") }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>

    <v-col cols="12" sm="6" md="4">
      <div class="card-container fontsize">
        <img src="/assets/images/user-pm.svg" alt="Avatar" class="avatar"/>
        <v-card class="card-warning">
          <v-card-text>
            <h1>5</h1>
            <h2>{{ translate("warningUser.messagesAndNotifications") }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>

    <v-col cols="12" sm="6" md="4">
      <div class="card-container fontsize">
        <img src="/assets/images/user_pay.svg" alt="Avatar" class="avatar"/>
        <v-card class="card-success">
          <v-card-text>
            <h1>12</h1>
            <h2>{{ translate("warningUser.payments") }}</h2>
          </v-card-text>
        </v-card>
      </div>
    </v-col>
  </v-row>
</template>

<script setup>
import { translate } from "@/store/languageStore.js";
</script>

<style scoped>
.card-container {
  padding-top: 50px;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.avatar {
  position: absolute;
  right: 10px;
  width: 50px;
  z-index: 2;
}

.card-info,
.card-warning,
.card-success {
  position: relative;
  padding: 20px;
  overflow: hidden;
  width: 100%;
  height: 150px;
  text-align: center;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.card-info {
  background-color: #d0f0fd;
  color: #007bff;
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
