<template>
    <v-container>
        <v-card>
            <v-card-title class="text-h6 Txt2">{{ translate("Ad.WhereAccommodation") }}</v-card-title>
            <v-card-subtitle class="Txt2"></v-card-subtitle>
            <v-card-text>
                <v-text-field v-model="searchQuery" label="Search location" @keyup.enter="searchLocation"></v-text-field>
                <div id="map" class="map-container"></div>
            </v-card-text>
        </v-card>
        <v-dialog v-model="showDetail" max-width="500px">
            <v-card>

                <v-card-title class="text-h5">{{ selectedApartment.location }}</v-card-title>
                <v-card-text>
                    <div v-if="selectedApartment.image">
                        <img :src="requireImage(selectedApartment.image)" alt="Apartment Image" style="width: 100%; border-radius: 10px; margin-bottom: 10px;">
                    </div>
                    <div><strong>Price:</strong> {{ selectedApartment.price }} {{ selectedApartment.period }}</div>
                    <div><strong>Rating:</strong> {{ selectedApartment.rating }}</div>
                    <div><strong>Extra fee:</strong> {{ selectedApartment.extraFee }} </div>
                </v-card-text>

                <v-card-actions>
                    <v-btn color="primary" @click="showDetail = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>

<script>
import "leaflet/dist/leaflet.css";
import L from "leaflet";
import axios from "axios";
import { translate } from "../../../../../store/languageStore";

export default {
    setup() {
        return { translate };
    },
    name: "HousesMap",
    data() {
        return {
            selectedApartment: null,
            showDetail: false,
            map: null,
            searchQuery: "",
            selectedCenter: null,
            apartments: [],
        };
    },
    mounted() {
        this.createMap();
        this.loadTestApartments();
    },
    methods: {
        createMap() {
            this.map = L.map("map").setView([50.8503, 4.3517], 13);
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(this.map);
        },
        showAdDetails(apartment) {
            this.selectedApartment = apartment;
            this.showDetail = true;
        },
        requireImage(imageName) {
            return new URL(`../public/${imageName}`, import.meta.url).href;
        },

        loadTestApartments() {
            this.apartments = [
                { id: 1, location: "بروکسل،بلژیک", host: "میزبان آرمین", rating: 4.8, price: 28, period: "شبانه", type: "home", image: "rectangle-720.png", coordinates: [50.8503, 4.3517], extraFee: 5 },
                { id: 2, location: "بروکسل،بلژیک", host: "میزبان آرمین", rating: 4.8, price: 28, period: "شبانه", type: "home", image: "rectangle-720.png", coordinates: [50.8503, 4.3517], extraFee: 5 },
                { id: 3, location: "آنتورپ،بلژیک", host: "مالک کامیاب", rating: 5, price: 18, period: "روزانه", type: "apartment", image: "rectangle-750.png", coordinates: [50.8549, 4.3479], extraFee: 8 },
                { id: 4, location: "بروکسل،بلژیک", host: "مالک کامیاب", rating: 5, price: 10, period: "روزانه", type: "apartment", image: "rectangle-750.png", coordinates: [50.8549, 4.3479], extraFee: 20 },
                { id: 5, location: "بروکسل،بلژیک", host: "میزبان سام", rating: 3.8, price: 22, type: "bed", period: "شبانه", image: "rectangle-2210.png", coordinates: [50.8521, 4.3459], extraFee: 5 },
                { id: 6, location: "بروکسل،بلژیک", host: "مالک کامیاب", rating: 5, price: 25, type: "tent", period: "روزانه", image: "rectangle-2200.png", coordinates: [50.8535, 4.3498], extraFee: 10 },
            ];
            this.displayApartments();
        },

        displayApartments() {
            this.apartments.forEach((apartment) => {
                const marker = L.marker(apartment.coordinates)
                    .addTo(this.map)
                    .bindPopup(`
                <strong>${apartment.location}</strong><br>
                ${apartment.host}<br>
                <strong>Price:</strong> ${apartment.price} ${apartment.period}<br>
                <strong>Rating:</strong> ${apartment.rating}
            `);

                marker.on('click', () => {
                    this.showAdDetails(apartment);
                });

            });
        },


        async searchLocation() {
            if (!this.searchQuery) return;
            const url = `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}`;
            const response = await axios.get(url);
            if (response.data.length > 0) {
                const { lat, lon } = response.data[0];
                this.selectedCenter = [parseFloat(lat), parseFloat(lon)];
                this.map.setView(this.selectedCenter, 13);
                this.filterApartments();
            }
        },

        filterApartments() {
            if (!this.selectedCenter) return;
            const RADIUS_KM = 5;
            const filteredApartments = this.apartments.filter((apartment) => {
                const distance = this.calculateDistance(this.selectedCenter, apartment.coordinates);
                return distance <= RADIUS_KM;
            });

            this.map.eachLayer((layer) => {
                if (layer instanceof L.Marker) {
                    this.map.removeLayer(layer);
                }
            });

            filteredApartments.forEach((apartment) => {
                L.marker(apartment.coordinates)
                    .addTo(this.map)
                    .bindPopup(`
                        <strong>${apartment.location}</strong><br>
                        ${apartment.host}<br>
                        <strong>Price:</strong> ${apartment.price} ${apartment.period}<br>
                        <strong>Rating:</strong> ${apartment.rating}
                    `);
            });
        },

        calculateDistance(coord1, coord2) {
            const toRad = (deg) => (deg * Math.PI) / 180;
            const R = 6371;
            const dLat = toRad(coord2[0] - coord1[0]);
            const dLon = toRad(coord2[1] - coord1[1]);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(toRad(coord1[0])) *
                Math.cos(toRad(coord2[0])) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        },
    },
};
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 300px;
    border-radius: 15px;
    overflow: hidden;
}
</style>
