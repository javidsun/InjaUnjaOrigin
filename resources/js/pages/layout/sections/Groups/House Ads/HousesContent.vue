<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-tabs vertical v-model="tab" class="pt-1">
          <v-tab>
            <v-icon left>mdi-home</v-icon>
            {{ t('housescontent.list') }}
          </v-tab>
          <v-tab>
            <v-icon left>mdi-map</v-icon>
            {{ t('housescontent.map') }}
          </v-tab>
        </v-tabs>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" v-show="tab === 0">
        <v-row class="mb-4 ">
          <v-col v-for="(icon, index) in icons" :key="index" cols="2">
            <v-btn class="d-flex justify-center align-center icon-btn" tile>
              <img :src="icon.src" alt="Icon" class="icon-img" />
            </v-btn>
          </v-col>
        </v-row>

        <v-row class="d-flex flex-wrap">
          <v-col
            v-for="(item, index) in apartments"
            :key="index"
            class="apartment-card-container"
          >
            <v-card class="apartment-card">
              <v-img :src="item.image" height="200px" class="apartment-img"></v-img>
              <v-card-title class="apartment-title">
                {{ item.location }}
              </v-card-title>
              <v-card-subtitle class="apartment-subtitle">
                {{ item.host }}
              </v-card-subtitle>
              <v-card-text class="apartment-text">
                <v-icon color="yellow">mdi-star</v-icon> {{ item.rating }}
                <br />
                {{ item.price }} {{ item.period }}
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" class="d-flex justify-center">
            <v-btn class="more-button" color="primary">
              {{ t('housescontent.seeMore') }}
            </v-btn>
          </v-col>
        </v-row>
      </v-col>

      <v-col cols="12" v-if="tab === 1">
        <v-card>
          <v-card-title>Map</v-card-title>
          <HousesMap :apartments="apartments" />
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { t } from "../../../../../store/languageStore";
import HousesMap from "./HousesMap.vue";

export default {
  setup() {
    return { t };
  },
  components: {
    HousesMap,
  },
  data() {
    return {
      tab: 0,
      icons: [
        { name: 'home', src: '/home-icon.png' },
        { name: 'apartment', src: '/apartment-icon.png' },
        { name: 'furniture', src: '/furniture-icon.png' },
        { name: 'bed', src: '/bed-icon.png' },
        { name: 'car', src: '/car-icon.png' },
        { name: 'travel tent', src: '/tent-icon.png' },
      ],
      apartments: [
        {
          location: "بروکسل،بلژیک",
          host: "میزبان آرمین",
          rating: "4.8",
          price: "€ ۲۸",
          period: "شبانه",
          image: "rectangle-720.png",
          coordinates: [50.8503, 4.3517],
        },
        {
          location: "بروکسل،بلژیک",
          host: "مالک کامیاب",
          rating: "5",
          price: "€ ۱۸",
          period: "روزانه",
          image: "rectangle-750.png",
          coordinates: [50.8549, 4.3479],
        },
        {
          location: "بروکسل،بلژیک",
          host: "میزبان سام",
          rating: "3.8",
          price: "€ 18",
          period: "شبانه",
          image: "rectangle-2210.png",
          coordinates: [50.8521, 4.3459],
        },
        {
          location: "بروکسل،بلژیک",
          host: "مالک کامیاب",
          rating: "5",
          price: "€ 30",
          period: "روزانه",
          image: "rectangle-2200.png",
          coordinates: [50.8535, 4.3498],
        },
      ],
    };
  },
};
</script>

<style scoped>
.apartment-card{
  background-color: var(--sidebar-background-color);
  color: var(--text-color);
}
.icon-btn{
  background-color: var(--background-color);

}

#map {
  height: 85vh;
  width: 100%;
}
</style>
