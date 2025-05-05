<template>
    <div id="companion-map-container">
        <div id="companionMap" class="map-container"></div>
        <v-dialog v-model="showCompanionDetail" max-width="600">
            <v-card v-if="selectedCompanion">
                <v-card-title class="headline">
                    {{ selectedCompanion.destination }}
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" sm="6">
                            <p><strong>Name:</strong> {{ selectedCompanion.user.name }}</p>
                            <p><strong>Age:</strong> {{ selectedCompanion.user.age }}</p>
                            <p><strong>Gender:</strong> {{ selectedCompanion.user.gender }}</p>
                        </v-col>
                        <v-col cols="12" sm="6">
                            <p><strong>Travel Dates:</strong> {{ selectedCompanion.travelDates }}</p>
                            <p><strong>Interests:</strong> {{ selectedCompanion.interests.join(', ') }}</p>
                        </v-col>
                    </v-row>
                    <p class="mt-4">{{ selectedCompanion.description }}</p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="showCompanionDetail = false">
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
//Todo:companions:{id/destination/travelDates/description/interests/coordinates}
//Todo:user:{name/age/gender/profileImage}

import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

export default {
    props: {
        companions: {
            type: Array,
            required: true,
            default: () => []
        }
    },
    data() {
        return {
            map: null,
            markers: [],
            showCompanionDetail: false,
            selectedCompanion: null,
            markerIcons: {
                male: '/map-marker-male.png',
                female: '/map-marker-female.png',
                neutral: '/map-marker-neutral.png'
            },
            leafletOptions: {
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png',
                iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            }
        };
    },
    mounted() {
        this.initializeMap();
    },
    methods: {
        initializeMap() {
            try {
                delete L.Icon.Default.prototype._getIconUrl;
                L.Icon.Default.mergeOptions(this.leafletOptions);

                this.map = L.map('companionMap').setView([51.505, -0.09], 3);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);

                this.displayCompanionsOnMap();
            } catch (error) {
                this.$emit('map-error', 'Failed to initialize map. Please try again later.');
                console.error('Map initialization error:', error);
            }
        },

        displayCompanionsOnMap() {
            try {
                if (!this.companions || this.companions.length === 0) {
                    this.$emit('no-companions', 'No companions available to display.');
                    return;
                }

                this.clearExistingMarkers();

                this.companions.forEach(companion => {
                    this.addCompanionMarker(companion);
                });

                this.fitMapToMarkers();
            } catch (error) {
                this.$emit('marker-error', 'Error displaying companions on map.');
                console.error('Marker display error:', error);
            }
        },

        addCompanionMarker(companion) {
            try {
                if (!companion.coordinates || companion.coordinates.length !== 2) return;

                let customIcon = this.createCustomIcon(companion.user.gender);
                let marker = L.marker(companion.coordinates, { icon: customIcon })
                    .addTo(this.map)
                    .bindPopup(this.generatePopupContent(companion));

                marker.on('click', () => {
                    this.handleMarkerClick(companion);
                });

                this.markers.push(marker);
            } catch (error) {
                console.error('Error adding marker:', error);
            }
        },

        createCustomIcon(gender) {
            let iconPath = this.markerIcons[gender] || this.markerIcons.neutral;
            return L.icon({
                iconUrl: iconPath,
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });
        },

        generatePopupContent(companion) {
            return `
                <div style="min-width: 200px">
                    <h4 style="margin: 0 0 5px 0">${companion.destination}</h4>
                    <p style="margin: 0 0 5px 0"><strong>${companion.user.name}</strong>, ${companion.user.age} years</p>
                    <p style="margin: 0 0 5px 0">${companion.travelDates}</p>
                    <button style="padding: 5px 10px; background: #1976D2; color: white; border: none; border-radius: 4px; cursor: pointer;"
                            onclick="event.stopPropagation(); window.dispatchEvent(new CustomEvent('show-companion-detail', { detail: '${companion.id}' }))">
                        View Details
                    </button>
                </div>
            `;
        },

        handleMarkerClick(companion) {
            this.selectedCompanion = companion;
            this.showCompanionDetail = true;
            this.$emit('companion-selected', companion);
        },

        clearExistingMarkers() {
            this.markers.forEach(marker => {
                this.map.removeLayer(marker);
            });
            this.markers = [];
        },

        fitMapToMarkers() {
            if (this.markers.length > 0) {
                let markerGroup = new L.featureGroup(this.markers);
                this.map.fitBounds(markerGroup.getBounds().pad(0.2));
            }
        }
    },
    watch: {
        companions: {
            handler(newCompanions) {
                if (newCompanions && this.map) {
                    this.displayCompanionsOnMap();
                }
            },
            deep: true
        }
    },
    beforeDestroy() {
        if (this.map) {
            this.map.remove();
        }
    }
};
</script>

<style scoped>
.map-container {
    width: 100%;
    height: 500px;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#companion-map-container {
    position: relative;
}

.v-dialog {
    z-index: 1000;
}
</style>
