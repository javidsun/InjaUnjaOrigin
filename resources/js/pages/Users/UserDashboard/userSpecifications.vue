<template>
  <v-container class="user-dashboard" fluid>
    <v-row justify="center" align="center">
      <v-col cols="12" class="text-center">
        <h2 class="welcome-text">
          {{ translate("UserProfile.WelcomeMessage", { userName: userName }) }}
        </h2>
        <p class="status-text">
          {{ translate("UserProfile.StatusMessage", { userReservationsCount: userReservationsCount }) }}
        </p>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref } from 'vue';
import { translate } from "@/store/languageStore.js";

const userName = ref("reza");
const userReservationsCount = ref(2);
</script>

<style scoped>
.user-dashboard {
  background-color: var(--background-color);
  padding: 20px;
  margin-top: 45px;
}

.welcome-text {
  font-family: "2 Baran", serif !important;
  font-size: 2rem;
  color: var(--sidebar-text-color);
  margin-bottom: 10px;
}

.status-text {
  font-family: "2 Baran", serif !important;
  font-size: 1.25rem;
  color: var(--sidebar-text-color);
  margin-top: 0;
}
</style>
