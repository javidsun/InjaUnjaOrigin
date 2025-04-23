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
                                <v-icon class="mr-2">mdi-cancel</v-icon>
                                {{ translate('Admin_Reports.cancellation_details') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card" elevation="2" @click="openModal('total')">
                                            <v-card-title class="text-h6">
                                                {{ cancellationDetails.totalCancellations }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.total_cancellations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportData('total')" color="primary">Export</v-btn>
                                            </v-card-actions>

                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card success" elevation="2" @click="openModal('host_schedule_change')">
                                            <v-card-title class="text-h6">
                                                {{ cancellationDetails.cancellationReasons[0].count }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.host_schedule_change') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportData('total')" color="primary">Export</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card warning" elevation="2" @click="openModal('payment_issue')">
                                            <v-card-title class="text-h6">
                                                {{ cancellationDetails.cancellationReasons[1].count }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.payment_issue') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportData('total')" color="primary">Export</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card error" elevation="2" @click="openModal('user_cancellations')">
                                            <v-card-title class="text-h6">
                                                {{ cancellationDetails.cancellationReasons[2].count }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Reports.user_cancellations') }}</v-card-subtitle>
                                            <v-card-actions>
                                                <v-btn @click="exportData('total')" color="primary">Export</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </v-row>

                                <v-data-table
                                    :headers="computedCancellationTableHeaders"
                                    :items="cancellations.total"
                                    hide-default-footer
                                    class="details-table mt-4"
                                    dense
                                    @click:row="showCancellationDetails"
                                >
                                    <template v-slot:item.actions="{ item }">
                                        <v-btn small @click.stop="openDetailModal(item)">{{ translate('Admin_Reports.details') }}</v-btn>
                                    </template>
                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
        <v-dialog v-model="modalOpen" max-width="800px">
            <v-card>
                <v-card-title>
                    {{ selectedType === 'total' ? 'Total Cancellations' : selectedType === 'host_schedule_change' ? 'Host Schedule Change' : selectedType === 'payment_issue' ? 'Payment Issue' : 'User Cancellations' }}
                </v-card-title>
                <v-card-text>
                    <v-table>
                        <thead>
                        <tr>
                            <th>{{ translate('Admin_Reports.id') }}</th>
                            <th>{{ translate('Admin_Reports.user_name') }}</th>
                            <th>{{ translate('Admin_Reports.reason') }}</th>
                            <th>{{ translate('Admin_Reports.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in selectedData" :key="item.id" @click="openDetailModal(item)">
                            <td>{{ item.id }}</td>
                            <td>{{ item.userName }}</td>
                            <td>{{ item.reason }}</td>
                            <td>
                                <v-btn small @click.stop="openDetailModal(item)">{{ translate('Admin_Reports.details') }}</v-btn>
                            </td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="modalOpen = false">Close</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="detailModalOpen" max-width="600px">
            <v-card>
                <v-card-title>{{ translate('Admin_Reports.cancellation_details') }}</v-card-title>
                <v-card-text>
                    <p><strong>{{ translate('Admin_Reports.id') }}:</strong> {{ selectedDetail.id }}</p>
                    <p><strong>{{ translate('Admin_Reports.order_name') }}:</strong> {{ selectedDetail.name }}</p>
                    <p><strong>{{ translate('Admin_Reports.reason') }}:</strong> {{ selectedDetail.reason }}</p>
                    <p><strong>{{ translate('Admin_Reports.date') }}:</strong> {{ selectedDetail.date }}</p>
                    <p><strong>{{ translate('Admin_Reports.user_name') }}:</strong> {{ selectedDetail.userName }}</p>
                    <p><strong>{{ translate('Admin_Reports.status') }}:</strong> {{ selectedDetail.status }}</p>
                    <p><strong>{{ translate('Admin_Reports.amount') }}:</strong> {{ selectedDetail.amount }}</p>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="detailModalOpen = false">Close</v-btn>
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
const modalOpen = ref(false);
const detailModalOpen = ref(false);
const selectedType = ref('');
const selectedData = ref([]);
const selectedDetail = ref({});

const cancellationDetails = ref({
    totalCancellations: 15,
    cancellationReasons: [
        { reasonKey: "Admin_Reports.host_schedule_change", count: 8, icon: "mdi-calendar-remove", color: "blue" },
        { reasonKey: "Admin_Reports.payment_issue", count: 5, icon: "mdi-credit-card-off", color: "red" },
        { reasonKey: "Admin_Reports.other", count: 2, icon: "mdi-help-circle", color: "gray" },
    ],
});
function exportData(type) {
    const data = cancellations[type];
    const worksheet = XLSX.utils.json_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
    XLSX.writeFile(workbook, `${type}_cancellations.xlsx`);
}

const cancellations = {
    total: [
        { id: 1, name: 'Order 101', reason: 'System error', date: '2023-10-01', userName: 'John Doe', status: 'Cancelled', amount: 100 },
        { id: 2, name: 'Order 102', reason: 'Timeout issue', date: '2023-10-02', userName: 'Jane Smith', status: 'Cancelled', amount: 150 },
        { id: 3, name: 'Order 201', reason: 'Host schedule change', date: '2023-10-03', userName: 'Alice Johnson', status: 'Cancelled', amount: 200 },
        { id: 4, name: 'Order 202', reason: 'Host unavailable', date: '2023-10-04', userName: 'Bob Brown', status: 'Cancelled', amount: 250 },
        { id: 5, name: 'Order 301', reason: 'Payment failed', date: '2023-10-05', userName: 'Charlie Davis', status: 'Cancelled', amount: 300 },
        { id: 6, name: 'Order 302', reason: 'Payment issue', date: '2023-10-06', userName: 'Eva Green', status: 'Cancelled', amount: 350 },
        { id: 7, name: 'Order 401', reason: 'User request', date: '2023-10-07', userName: 'Frank White', status: 'Cancelled', amount: 400 },
        { id: 8, name: 'Order 402', reason: 'Duplicate order', date: '2023-10-08', userName: 'Grace Black', status: 'Cancelled', amount: 450 },
    ],
    host_schedule_change: [
        { id: 1, name: 'Order 101', reason: 'System error', date: '2023-10-01', userName: 'John Doe', status: 'Cancelled', amount: 100 },
        { id: 2, name: 'Order 102', reason: 'Timeout issue', date: '2023-10-02', userName: 'Jane Smith', status: 'Cancelled', amount: 150 },
        { id: 3, name: 'Order 201', reason: 'Host schedule change', date: '2023-10-03', userName: 'Alice Johnson', status: 'Cancelled', amount: 200 },
        { id: 4, name: 'Order 202', reason: 'Host unavailable', date: '2023-10-04', userName: 'Bob Brown', status: 'Cancelled', amount: 250 },
    ],
    payment_issue: [
        { id: 5, name: 'Order 301', reason: 'Payment failed', date: '2023-10-05', userName: 'Charlie Davis', status: 'Cancelled', amount: 300 },
        { id: 6, name: 'Order 302', reason: 'Payment issue', date: '2023-10-06', userName: 'Eva Green', status: 'Cancelled', amount: 350 },
    ],
    user_cancellations: [
        { id: 7, name: 'Order 401', reason: 'User request', date: '2023-10-07', userName: 'Frank White', status: 'Cancelled', amount: 400 },
        { id: 8, name: 'Order 402', reason: 'Duplicate order', date: '2023-10-08', userName: 'Grace Black', status: 'Cancelled', amount: 450 },
    ],
};

function openModal(type) {
    selectedType.value = type;
    selectedData.value = cancellations[type];
    modalOpen.value = true;
}

function openDetailModal(item) {
    selectedDetail.value = item;
    detailModalOpen.value = true;
}

const computedCancellationTableHeaders = computed(() => [
    { text: 'ID', value: 'id' },
    { text: 'Order Name', value: 'name' },
    { text: 'Reason', value: 'reason' },
    { text: 'Date', value: 'date' },
    { text: 'User Name', value: 'userName' },
    { text: 'Status', value: 'status' },
    { text: 'Amount', value: 'amount' },
    { text: 'Actions', value: 'actions' },
]);

const cancellationTableHeaders = ref([
    { textKey: "Admin_Reports.reason", value: "reason" },
    { textKey: "Admin_Reports.count", value: "count" },
]);
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
