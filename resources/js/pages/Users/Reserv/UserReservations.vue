<template class="cards">
  <v-card class="reservation-summary-card" outlined>
    <v-card-title>
      {{ translate("UserSidebar.RecentReservations") }}
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
          <v-card outlined class="reservation-card">
            <v-img
                :src="reservation.image"
                aspect-ratio="1"
                class="reservation-image"
                height="100"
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
          </v-card>
        </v-col>
      </v-row>
    </v-card-text>
    <v-card-actions>
        <v-btn :to="'/MyReservations'" color="primary" outlined class="ml-auto">
            {{ translate("UserSidebar.ViewAllReservations") }}
        </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script setup>
import { ref } from 'vue';
import { translate } from "../../../store/languageStore.js";

const recentReservations = ref([
  {
    title: translate("UserSidebar.HouseReservation"),
    date: "2025-01-01",
    icon: "mdi-home",
    color: "blue",
    image: "/ads/house.svg",
  },
  {
    title: translate("UserSidebar.CarReservation"),
    date: "2024-12-29",
    icon: "mdi-car",
    color: "green",
    image: "/ads/car.svg",
  },
  {
    title: translate("UserSidebar.EventReservation"),
    date: "2024-12-25",
    icon: "mdi-calendar",
    color: "purple",
    image: "/ads/event.svg",
  },
  {
    title: translate("UserSidebar.TravelerReservation"),
    date: "2024-12-20",
    icon: "mdi-account-group",
    color: "orange",
    image: "/ads/firend.svg",
  },
]);
</script>

<style scoped>
.reservation-summary-card {
  margin: 20px auto;
  padding: 20px;
  text-align: right;
  direction: rtl;
  box-shadow: none!important;
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
