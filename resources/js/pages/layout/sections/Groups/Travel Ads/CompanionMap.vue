<template>
    <div id="companion-map-container">
        <div id="companionMap" class="map-container"></div>
    </div>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const iconRetinaUrl = 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png';
const iconUrl = 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png';
const shadowUrl = 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png';

export default {
    props: {
        companions: {
            type: Array,
            required: true
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
            }
        };
    },
    mounted() {
        this.initMap();
        this.displayCompanions();
    },
    methods: {
        initMap() {
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl,
                iconUrl,
                shadowUrl,
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });

            this.map = L.map('companionMap').setView([51.505, -0.09], 3);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map);
        },

        displayCompanions() {
            this.clearMarkers();

            this.companions.forEach(companion => {
                if (companion.coordinates && companion.coordinates.length === 2) {
                    const icon = this.getCompanionIcon(companion);
                    const marker = L.marker(companion.coordinates, { icon })
                        .addTo(this.map)
                        .bindPopup(this.createPopupContent(companion));

                    marker.on('click', () => {
                        this.showCompanionDetails(companion);
                    });

                    this.markers.push(marker);
                }
            });

            if (this.markers.length > 0) {
                const group = new L.featureGroup(this.markers);
                this.map.fitBounds(group.getBounds().pad(0.2));
            }
        },

        getCompanionIcon(companion) {
            const iconUrl = this.markerIcons[companion.user.gender] || this.markerIcons.neutral;
            return L.icon({
                iconUrl,
                iconSize: [32, 32],
                iconAnchor: [16, 32]
            });
        },

        createPopupContent(companion) {
            return `
        <div style="min-width: 200px">
          <h4 style="margin: 0 0 5px 0">${companion.destination}</h4>
          <p style="margin: 0 0 5px 0"><strong>${companion.user.name}</strong>, ${companion.user.age} سال</p>
          <p style="margin: 0 0 5px 0">${companion.travelDates}</p>
          <button onclick="window.dispatchEvent(new CustomEvent('show-companion-detail', { detail: ${companion.id} }))">
          </button>
        </div>
      `;
        },

        showCompanionDetails(companion) {
            this.selectedCompanion = companion;
            this.showCompanionDetail = true;
        },

        clearMarkers() {
            this.markers.forEach(marker => this.map.removeLayer(marker));
            this.markers = [];
        }
    },
    watch: {
        companions(newVal) {
            if (newVal) {
                this.displayCompanions();
            }
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
}
</style>
