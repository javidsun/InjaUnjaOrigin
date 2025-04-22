<!--فایل  ReservationManagement.js در services      فایل   ReservationManagement.json در پوشه docs -->


<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
                </div>
            </v-col>
            <v-spacer />
            <Searchbar />
            <v-spacer />
            <Darkmood class="darkmood"/>
            <LanguageSwitcher class="language" />
        </v-app-bar>

        <Sidebar app v-model="drawer" />

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid class="main1">
                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg pa-4">
                            <v-card-title class="text-h5 primary--text sizem">
                                <v-icon class="mr-2">mdi-file-chart</v-icon>
                                {{ translate('Admin_Reports.reservations_details') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card" elevation="2" @click="showDetails(reservationsDetails.total, 'total')">
                                            <v-card-title class="text-h6">
                                                {{ reservationsDetails.total }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.total_reservations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportToExcel('total')" color="primary">Export</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card success" elevation="2" @click="showDetails(reservationsDetails.successful, 'successful')">
                                            <v-card-title class="text-h6">
                                                {{ reservationsDetails.successful }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.successful_reservations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportToExcel('successful')" color="primary">Export</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card warning" elevation="2" @click="showDetails(reservationsDetails.pending, 'pending')">
                                            <v-card-title class="text-h6">
                                                {{ reservationsDetails.pending }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.pending_reservations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportToExcel('pending')" color="primary">Export</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card error" elevation="2" @click="showDetails(reservationsDetails.failed, 'failed')">
                                            <v-card-title class="text-h6">
                                                {{ reservationsDetails.failed }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.failed_reservations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportToExcel('failed')" color="primary">Export</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-col>
                                </v-row>

                                <v-data-table
                                    :headers="detailsTableHeaders"
                                    :items="detailsItems"
                                    hide-default-footer
                                    class="details-table mt-4"
                                    dense
                                    @click:row="showReservationDetails"
                                >
                                    <template v-slot:item.icon="{ item }">
                                        <v-icon :color="item.color">{{ item.icon }}</v-icon>
                                    </template>
                                    <template v-slot:item.image="{ item }">
                                        <v-img :src="item.image" width="50" height="50" class="reservation-image"></v-img>
                                    </template>
                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <v-dialog v-model="reservationDialog" max-width="800">
            <v-card>
                <v-card-title class="text-h5">{{ selectedReservation.title }}</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-img :src="selectedReservation.image" class="reservation-image"></v-img>
                        </v-col>
                        <v-col cols="12" md="6">
                            <v-card outlined class="details-card">
                                <v-card-title>
                                    <v-icon :color="selectedReservation.color" class="reservation-icon">
                                        {{ selectedReservation.icon }}
                                    </v-icon>
                                    {{ selectedReservation.title }}
                                </v-card-title>
                                <v-card-subtitle class="reservation-date">
                                    {{ selectedReservation.date }}
                                </v-card-subtitle>
                                <v-card-text>
                                    <p>{{ selectedReservation.amount }}</p>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="reservationDialog = false">close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="detailsDialog" max-width="800">
            <v-card>
                <v-card-title class="text-h5">{{ detailsTitle }}</v-card-title>
                <v-card-text>
                    <v-data-table
                        :headers="detailsTableHeaders"
                        :items="detailsItems"
                        hide-default-footer
                        class="details-table mt-4"
                        dense
                        @click:row="showReservationDetails"
                    >
                        <template v-slot:item.icon="{ item }">
                            <v-icon :color="item.color">{{ item.icon }}</v-icon>
                        </template>
                        <template v-slot:item.image="{ item }">
                            <v-img :src="item.image" width="50" height="50" class="reservation-image"></v-img>
                        </template>
                    </v-data-table>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="detailsDialog = false">close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-app>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import Sidebar from "../Sidebar.vue";
import { ref, computed } from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "@/store/languageStore.js";
import * as XLSX from 'xlsx';

const drawer = ref(true);
const reservationDialog = ref(false);
const selectedReservation = ref({});
const detailsDialog = ref(false);
const detailsTitle = ref('');
const detailsItems = computed(() => detailsData.value.total);
const computedReservationTableHeaders = ref([
    { text: "ID", value: "id" },
    { text: translate('Admin_Reports.guest_name'), value: "guest_name" },
    { text: translate('Admin_Reports.date'), value: "date" },
]);

function exportToExcel() {
    const data = detailsItems.value.map(item => ({
        نام: item.name,
        تاریخ: item.date,
        آیکون: item.icon,
        تصویر: item.image,
        مبلغ: item.amount
    }));

    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Reservations");
    XLSX.writeFile(workbook, "reservations.xlsx");
}

const reservationsDetails = ref({
    total: 123,
    successful: 100,
    pending: 20,
    failed: 3,
});

const reservations = ref([
    {
        title: translate("HouseReservation"),
        date: "2025-01-01",
        icon: "mdi-home",
        color: "blue",
        image: "/ads/house.svg",
        amount: "120 Euro",
    },
    {
        title: translate("CarReservation"),
        date: "2024-12-29",
        icon: "mdi-car",
        color: "green",
        image: "/ads/car.svg",
        amount: "50 Euro",

    },
    {
        title: translate("EventReservation"),
        date: "2024-12-25",
        icon: "mdi-calendar",
        color: "purple",
        image: "/ads/event.svg",
        amount: "20 Euro",

    },
    {
        title: translate("TravelerReservation"),
        date: "2024-12-20",
        icon: "mdi-account-group",
        color: "orange",
        image: "/ads/firend.svg",
        amount: "80 Euro",
    },
]);
const detailsTableHeaders = ref([
    { text: "نام", value: "name" },
    { text: "تاریخ", value: "date" },
    { text: "آیکون", value: "icon" },
    { text: "تصویر", value: "image" },
    { text: "مبلغ", value: "amount" },
]);


const detailsData = computed(() => ({
    total: reservations.value.map(reservation => ({
        name: reservation.title,
        date: reservation.date,
        icon: reservation.icon,
        color: reservation.color,
        image: reservation.image,
        amount: reservation.amount
    })),
    successful: reservations.value.filter(reservation => reservation.title === translate("HouseReservation") || reservation.title === translate("CarReservation")).map(reservation => ({
        name: reservation.title,
        date: reservation.date,
        icon: reservation.icon,
        color: reservation.color,
        image: reservation.image,
        amount: reservation.amount
    })),
    pending: reservations.value.filter(reservation => reservation.title === translate("EventReservation")).map(reservation => ({
        name: reservation.title,
        date: reservation.date,
        icon: reservation.icon,
        color: reservation.color,
        image: reservation.image,
        amount: reservation.amount
    })),
    failed: reservations.value.filter(reservation => reservation.title === translate("TravelerReservation")).map(reservation => ({
        name: reservation.title,
        date: reservation.date,
        icon: reservation.icon,
        color: reservation.color,
        image: reservation.image,
        amount: reservation.amount
    })),
}));
function showDetails(value, type) {
    detailsTitle.value = translate(`Admin_Reports.${type}_reservations`);
    detailsItems.value = detailsData.value[type];
    detailsDialog.value = true;
}
function showReservationDetails(event, { item }) {
    selectedReservation.value = item;
    reservationDialog.value = true;
}

</script>

<style scoped>
.info-card.success {
    background: #d4edda;
    color: #155724;
}

.info-card.warning {
    background: #fff3cd;
    color: #856404;
}

.info-card.error {
    background: #f8d7da;
    color: #721c24;
}

.logo-image {
    width: 60px;
}

.header {
    z-index: 1000;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: var(--background-color);
}

.v-btn {
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
}

.info-card {
    padding: 10px;
    text-align: center;
    border-radius: 8px;
    background: #3e5572;
    margin-bottom: 10px;
    cursor: pointer;
    transition: transform 0.2s;
}

.info-card:hover {
    transform: scale(1.05);
}

.v-chip {
    font-weight: bold;
}

.main-expanded {
    padding-left: 240px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
    padding-top: 64px;
}

.main-collapsed {
    padding-left: 80px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
}

.language {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}

.darkmood {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}

* {
    box-sizing: border-box;
}

body {
    overflow-x: hidden;
}

.footer {
    background-color: var(--background-color);
}

.language {
    margin-right: 80px !important;
}

.darkmood {
    margin-right: 20px !important;
}

.main1 {
    margin-left: 10px;
}

v-container {
    max-width: 100%;
    padding: 0;
}

.logo-container {
    display: flex;
    align-items: center;
    overflow: visible;
    filter: brightness(var(--logo-brightness, 1));
}

.border1 {
    margin-left: 20px;
}

@media (max-width: 600px) {
    .info-card {
        width: 100%;
        margin-bottom: -15px;
    }

    .v-card-title {
        font-size: 16px;
    }

    .v-card-subtitle {
        font-size: 14px;
    }

    .v-row {
        flex-direction: column;
    }

    .main-expanded {
        padding-left: 0;
        margin-left: 0;
    }

    .main-collapsed {
        padding-left: 0;
        margin-left: 0;
    }

    .logo-image {
        width: 50px;
    }

    .darkmood {
        margin-right: -20px !important;
    }

    .language {
        margin-right: -20px;
    }

    .sizem {
        font-size: 14px;
    }
}

.details-card {
    padding: 20px;
    border-radius: 16px;
}

.reservation-image {
    width: 100%;
    object-fit: cover;
    border-radius: 16px;
}

.reservation-icon {
    font-size: 32px;
    margin-right: 10px;
}

.reservation-date {
    color: gray;
    font-style: italic;
}

.title {
    background-color: var(--background-color--groups3);
    text-align: center;
    color: var(--text-color);
}

.back {
    background-color: var(--background-color--groups3);
}
.details-table {
    margin-top: 20px;
}

.reservation-image {
    border-radius: 8px;
}
</style>
