<template>
    <v-container>
        <v-card>
            <v-card-title class="text-h6 Txt2">{{ translate("Ad.WhereAccommodation") }}</v-card-title>
            <v-card-subtitle class="Txt2"></v-card-subtitle>
            <v-card-text>
                <v-text-field
                    v-model="searchQuery"
                    :label="translate('Search location')"
                    @keyup.enter="handleSearchLocation"
                    :loading="isSearching"
                ></v-text-field>
                <div id="map" class="map-container"></div>
            </v-card-text>
        </v-card>

        <v-dialog v-model="showDetail" max-width="500px">
            <v-card>
                <v-card-title class="text-h5">{{ selectedApartment.location }}</v-card-title>
                <v-card-text>
                    <div v-if="selectedApartment.image">
                        <img :src="getImageUrl(selectedApartment.image)" alt="Apartment Image" class="apartment-image">
                    </div>
                    <div class="detail-item"><strong>{{ translate('Price') }}:</strong> {{ selectedApartment.price }} {{ selectedApartment.period }}</div>
                    <div class="detail-item"><strong>{{ translate('Rating') }}:</strong> {{ selectedApartment.rating }}</div>
                    <div class="detail-item"><strong>{{ translate('Extra fee') }}:</strong> {{ selectedApartment.extraFee }}</div>
                    <div class="detail-item"><strong>{{ translate('Host') }}:</strong> {{ selectedApartment.host }}</div>
                </v-card-text>

                <v-card-actions>
                    <v-btn color="primary" @click="closeDetailDialog">{{ translate('Close') }}</v-btn>
                    <v-btn color="secondary" @click="handleBookNow">{{ translate('Book Now') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
//TOdo:apartments:{id/location/host name/rating/price/type:(home/apartment/bed/tent etc.)/period:(nightly/daily/weekly etc.)/image/coordinates:(lat /lng)
//TOdo:extraFee/amenities/description/availableFrom/availableTo
//TOdo:searchLocations:{query/lat/lng/rating/radius
//TOdo:address:{city/country/postcode}

import "leaflet/dist/leaflet.css";
import L from "leaflet";
import axios from "axios";
import {translate} from "@/store/languageStore";

export default {
    name: "HousesMap",

    data() {
        return {
            selectedApartment: null,
            showDetail: false,
            map: null,
            searchQuery: "",
            selectedCenter: null,
            apartments: [],
            isSearching: false,
            mapMarkers: []
        };
    },

    mounted() {
        this.initializeMap();
        this.loadSampleApartments();
    },

    methods: {
        translate,

        initializeMap() {
            try {
                this.map = L.map("map").setView([50.8503, 4.3517], 13);
                L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 18
                }).addTo(this.map);

                this.map.on('click', this.handleMapClick);
            } catch (error) {
                this.showErrorNotification('Failed to initialize map');
                console.error('Map initialization error:', error);
            }
        },

        loadSampleApartments() {
            try {
                this.apartments = this.getSampleApartmentData();
                this.displayApartmentsOnMap();
            } catch (error) {
                this.showErrorNotification('Failed to load apartment data');
                console.error('Apartment loading error:', error);
            }
        },

        getSampleApartmentData() {
            return [
                {
                    id: 1,
                    location: "بروکسل،بلژیک",
                    host: "میزبان آرمین",
                    rating: 4.8,
                    price: 28,
                    period: "شبانه",
                    type: "home",
                    image: "rectangle-720.png",
                    coordinates: [50.8503, 4.3517],
                    extraFee: 5
                },
                {
                    id: 2,
                    location: "بروکسل،بلژیک",
                    host: "میزبان آرمین",
                    rating: 4.8,
                    price: 28,
                    period: "شبانه",
                    type: "home",
                    image: "rectangle-720.png",
                    coordinates: [50.8503, 4.3517],
                    extraFee: 5
                },
                {
                    id: 3,
                    location: "آنتورپ،بلژیک",
                    host: "مالک کامیاب",
                    rating: 5,
                    price: 18,
                    period: "روزانه",
                    type: "apartment",
                    image: "rectangle-750.png",
                    coordinates: [50.8549, 4.3479],
                    extraFee: 8
                },
                {
                    id: 4,
                    location: "بروکسل،بلژیک",
                    host: "مالک کامیاب",
                    rating: 5,
                    price: 10,
                    period: "روزانه",
                    type: "apartment",
                    image: "rectangle-750.png",
                    coordinates: [50.8549, 4.3479],
                    extraFee: 20
                },
                {
                    id: 5,
                    location: "بروکسل،بلژیک",
                    host: "میزبان سام",
                    rating: 3.8,
                    price: 22,
                    type: "bed",
                    period: "شبانه",
                    image: "rectangle-2210.png",
                    coordinates: [50.8521, 4.3459],
                    extraFee: 5
                },
                {
                    id: 6,
                    location: "بروکسل،بلژیک",
                    host: "مالک کامیاب",
                    rating: 5,
                    price: 25,
                    type: "tent",
                    period: "روزانه",
                    image: "rectangle-2200.png",
                    coordinates: [50.8535, 4.3498],
                    extraFee: 10
                }
            ];
        },

        displayApartmentsOnMap() {
            try {
                this.clearMapMarkers();

                this.apartments.forEach(apartment => {
                    const marker = L.marker(apartment.coordinates)
                        .addTo(this.map)
                        .bindPopup(this.createPopupContent(apartment));

                    marker.on('click', () => {
                        this.showApartmentDetails(apartment);
                    });

                    this.mapMarkers.push(marker);
                });
            } catch (error) {
                this.showErrorNotification('Failed to display apartments on map');
                console.error('Map marker error:', error);
            }
        },

        createPopupContent(apartment) {
            return `
                <strong>${apartment.location}</strong><br>
                ${apartment.host}<br>
                <strong>${translate('Price')}:</strong> ${apartment.price} ${apartment.period}<br>
                <strong>${translate('Rating')}:</strong> ${apartment.rating}
            `;
        },

        async handleSearchLocation() {
            if (!this.searchQuery.trim()) {
                this.showWarningNotification('Please enter a location to search');
                return;
            }

            this.isSearching = true;

            try {
                const response = await axios.get(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}`,
                    {
                        headers: {
                            'User-Agent': 'YourAppName/1.0 (your@email.com)'
                        }
                    }
                );

                if (response.data && response.data.length > 0) {
                    const firstResult = response.data[0];
                    this.selectedCenter = [parseFloat(firstResult.lat), parseFloat(firstResult.lon)];
                    this.map.setView(this.selectedCenter, 13);
                    this.filterApartmentsByDistance();
                } else {
                    this.showWarningNotification('Location not found');
                }
            } catch (error) {
                this.showErrorNotification('Failed to search location');
                console.error('Location search error:', error);
            } finally {
                this.isSearching = false;
            }
        },

        filterApartmentsByDistance() {
            if (!this.selectedCenter) return;

            try {
                const RADIUS_KM = 5;
                const filteredApartments = this.apartments.filter(apartment => {
                    const distance = this.calculateDistanceBetweenCoordinates(
                        this.selectedCenter,
                        apartment.coordinates
                    );
                    return distance <= RADIUS_KM;
                });

                this.clearMapMarkers();
                this.displayFilteredApartments(filteredApartments);
            } catch (error) {
                this.showErrorNotification('Failed to filter apartments');
                console.error('Filtering error:', error);
            }
        },

        displayFilteredApartments(apartments) {
            apartments.forEach(apartment => {
                const marker = L.marker(apartment.coordinates)
                    .addTo(this.map)
                    .bindPopup(this.createPopupContent(apartment));

                marker.on('click', () => {
                    this.showApartmentDetails(apartment);
                });

                this.mapMarkers.push(marker);
            });
        },

        calculateDistanceBetweenCoordinates(coord1, coord2) {
            try {
                const toRad = deg => (deg * Math.PI) / 180;
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
            } catch (error) {
                console.error('Distance calculation error:', error);
                return Infinity;
            }
        },

        showApartmentDetails(apartment) {
            this.selectedApartment = apartment;
            this.showDetail = true;
        },

        closeDetailDialog() {
            this.showDetail = false;
            this.selectedApartment = null;
        },

        handleBookNow() {
            if (this.selectedApartment) {
                this.showSuccessNotification(`Booking request sent for ${this.selectedApartment.location}`);
                this.closeDetailDialog();
            }
        },

        handleMapClick(e) {
            console.log('Map clicked at:', e.latlng);
        },

        clearMapMarkers() {
            this.mapMarkers.forEach(marker => {
                this.map.removeLayer(marker);
            });
            this.mapMarkers = [];
        },

        getImageUrl(imageName) {
            try {
                return new URL(`../public/${imageName}`, import.meta.url).href;
            } catch (error) {
                console.error('Image load error:', error);
                return '';
            }
        },

        showSuccessNotification(message) {
            this.$emit('show-notification', {
                type: 'success',
                message: translate(message)
            });
        },

        showWarningNotification(message) {
            this.$emit('show-notification', {
                type: 'warning',
                message: translate(message)
            });
        },

        showErrorNotification(message) {
            this.$emit('show-notification', {
                type: 'error',
                message: translate(message)
            });
        }
    }
};
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 400px;
    border-radius: 15px;
    overflow: hidden;
    margin-top: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.apartment-image {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 16px;
    max-height: 250px;
    object-fit: cover;
}

.detail-item {
    margin-bottom: 8px;
    font-size: 16px;
}

.Txt2 {
    color: var(--v-primary-darken1);
}
</style>
