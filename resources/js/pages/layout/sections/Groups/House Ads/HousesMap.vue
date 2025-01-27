<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <div id="map" class="map-container"></div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";

export default {
  name: "HousesMap",
  props: {
    apartments: {
      type: Array,
      required: true,
    },
  },
  mounted() {
    this.createMap();
  },
  methods: {
    createMap() {
      const map = L.map("map").setView([50.8503, 4.3517], 13); // Brussels as map center

      // Add OpenStreetMap tile layer
      L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
      }).addTo(map);

      // Add markers for each apartment
      this.apartments.forEach((apartment) => {
        L.marker(apartment.coordinates)
          .addTo(map)
          .bindPopup(`
            <strong>${apartment.location}</strong><br>
            ${apartment.host}<br>
            <strong>Price:</strong> ${apartment.price} ${apartment.period}<br>
            <strong>Rating:</strong> ${apartment.rating}
          `);
      });
    },
  },
};
</script>

<style scoped>
.map-container {
  width: 100%;
  height: 85vh;
  border-radius: 15px;
  overflow: hidden;
}
</style>
