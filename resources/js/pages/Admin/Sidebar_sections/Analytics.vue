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
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg border1 animated-card">
                            <v-card-title class="text-h5 primary--text">
                                <v-icon class="mr-2">mdi-chart-bar</v-icon>
                                {{ translate('Admin_Reports.analysis_and_reports') }}
                            </v-card-title>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12" md="6" lg="3">
                        <v-card class="elevation-4 rounded-lg pa-4 text-center animated-card" @click="goTo('/ReservationManagement')">
                            <v-icon size="50" color="primary">mdi-calendar-check</v-icon>
                            <v-card-title class="mt-2">{{ reservationsThisMonth }}</v-card-title>
                            <v-card-subtitle>{{ translate('Admin_Reports.reservations_this_month') }}</v-card-subtitle>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                        <v-card class="elevation-4 rounded-lg pa-4 text-center animated-card" @click="showModal('average_host_income')">
                            <v-icon size="50" color="green">mdi-cash-multiple</v-icon>
                            <v-card-title class="mt-2">{{ averageHostIncome }} €</v-card-title>
                            <v-card-subtitle>{{ translate('Admin_Reports.average_host_income') }}</v-card-subtitle>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                        <v-card class="elevation-4 rounded-lg pa-4 text-center animated-card" @click="showModal('approval_rate')">
                            <v-icon size="50" color="blue">mdi-checkbox-marked-circle-outline</v-icon>
                            <v-card-title class="mt-2">{{ approvalRate }}%</v-card-title>
                            <v-card-subtitle>{{ translate('Admin_Reports.approval_rate') }}</v-card-subtitle>
                        </v-card>
                    </v-col>
                    <v-col cols="12" md="6" lg="3">
                        <v-card class="elevation-4 rounded-lg pa-4 text-center animated-card" @click="goTo('/CancellationsDetails')">
                            <v-icon size="50" color="red">mdi-close-circle</v-icon>
                            <v-card-title class="mt-2">{{ cancellationRate }}%</v-card-title>
                            <v-card-subtitle>{{ translate('Admin_Reports.cancellation_rate') }}</v-card-subtitle>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12" md="4">
                        <v-card class="card-dashboard elevation-4 animated-card" @click="showTableDetails('conversionRate')">
                            <v-card-title>{{ translate('re_dashboard.conversionRate') }}</v-card-title>
                            <v-card-text class="text1">
                                <p>{{ translate('re_dashboard.conversionRateDescription') }}</p>
                                <apex-chart
                                    v-if="chartData.conversionRate && chartData.conversionRate.options"
                                    type="donut"
                                    height="360"
                                    :options="chartData.conversionRate.options"
                                    :series="chartData.conversionRate.series"
                                />
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card class="card-dashboard elevation-4 animated-card" @click="showTableDetails('revenueByCategory')">
                            <v-card-title>{{ translate('re_dashboard.revenueByCategory') }}</v-card-title>
                            <v-card-text class="text1">
                                <apex-chart
                                    v-if="chartData.revenueByCategory && chartData.revenueByCategory.options"
                                    type="bar"
                                    height="200"
                                    :options="chartData.revenueByCategory.options"
                                    :series="chartData.revenueByCategory.series"
                                />
                                <v-data-table
                                    :headers="computedTableHeaders"
                                    :items="computedRevenueByCategory"
                                    hide-default-footer
                                    class="datatable"
                                    dense
                                >
                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card class="card-dashboard elevation-4 animated-card text1" @click="showTableDetails('geoActivity')">
                            <v-card-title>{{ translate('re_dashboard.geoActivity') }}</v-card-title>
                            <v-card-text>
                                <apex-chart
                                    v-if="chartData.revenueByCategory && chartData.revenueByCategory.options"
                                    type="bar"
                                    height="200"
                                    :options="chartData.revenueByCategory.options"
                                    :series="chartData.revenueByCategory.series"
                                />
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-dialog v-model="tableDetailsVisible" max-width="800">
                    <v-card class="elevation-6">
                        <v-card-title class="text-h5">{{ tableDetailsTitle }}</v-card-title>
                        <v-card-text>
                            <v-data-table
                                v-if="tableDetailsKey === 'revenueByCategory'"
                                :headers="computedTableHeaders"
                                :items="computedRevenueByCategory"
                                hide-default-footer
                                class="datatable"
                                dense
                            ></v-data-table>

                            <apex-chart
                                v-else-if="tableDetailsKey === 'conversionRate'"
                                type="donut"
                                height="360"
                                :options="chartData.conversionRate.options"
                                :series="chartData.conversionRate.series"
                            />

                            <apex-chart
                                v-else-if="tableDetailsKey === 'geoActivity'"
                                type="bar"
                                height="200"
                                :options="chartData.revenueByCategory.options"
                                :series="chartData.revenueByCategory.series"
                            />
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="tableDetailsVisible = false">{{ translate('Admin_AdManagement.close') }}</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

            </v-container>
        </v-main>

        <v-dialog v-model="modalVisible" max-width="500">
            <v-card class="elevation-6">
                <v-card-title class="text-h5">{{ modalTitle }}</v-card-title>
                <v-card-text>
                    <p><strong>{{ translate('Admin_Reports.value') }}:</strong> {{ modalData.value }}</p>
                    <p><strong>{{ translate('Admin_Reports.description') }}:</strong> {{ modalData.description }}</p>
                    <p><strong>{{ translate('Admin_Reports.date') }}:</strong> {{ modalData.date }}</p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="modalVisible = false">{{ translate('Admin_AdManagement.close') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import Sidebar from "../Sidebar.vue";
import { ref, computed } from "vue";
import Searchbar from "../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import ApexChart from "vue3-apexcharts";
import { translate } from "@/store/languageStore.js";
import { watchEffect } from "vue";

const isDarkMode = ref(true);
const drawer = ref(true);
const reservationsThisMonth = ref(123);
const averageHostIncome = ref(2500);
const approvalRate = ref(85);
const cancellationRate = ref(12);
const goTo = (path) => {
    window.location.href = path;
};
const tableDetailsVisible = ref(false);
const tableDetailsTitle = ref('');
const tableDetailsKey = ref('');

const showTableDetails = (key) => {
    tableDetailsKey.value = key;
    tableDetailsTitle.value = translate(`re_dashboard.${key}`);
    tableDetailsVisible.value = true;
};

const modalVisible = ref(false);
const modalTitle = ref('');
const modalData = ref({
    value: '',
    description: '',
    date: new Date().toLocaleDateString(),
});

const showModal = (key) => {
    const data = {
        reservations_this_month: {
            value: reservationsThisMonth.value,
            description: translate('Admin_Reports.reservations_this_month_description'),
        },
        average_host_income: {
            value: `${averageHostIncome.value} €`,
            description: translate('Admin_Reports.average_host_income_description'),
        },
        approval_rate: {
            value: `${approvalRate.value}%`,
            description: translate('Admin_Reports.approval_rate_description'),
        },
        cancellation_rate: {
            value: `${cancellationRate.value}%`,
            description: translate('Admin_Reports.cancellation_rate_description'),
        },
    }[key];

    modalTitle.value = translate(`Admin_Reports.${key}`);
    modalData.value = { ...data, date: new Date().toLocaleDateString() };
    modalVisible.value = true;
};

const conversionRate = 25;
const revenueByCategory = ref([
    { categoryKey: "re_dashboard.Home", revenue: 5000 },
    { categoryKey: "re_dashboard.Car", revenue: 2000 },
    { categoryKey: "re_dashboard.Others", revenue: 1000 },
]);

const computedRevenueByCategory = computed(() =>
    revenueByCategory.value.map((item) => ({
        ...item,
        category: translate(item.categoryKey),
    }))
);

const tableHeaders = ref([
    { textKey: "re_dashboard.category", key: "category" },
    { textKey: "re_dashboard.revenue", key: "revenue" },
]);

const computedTableHeaders = computed(() =>
    tableHeaders.value.map((header) => ({
        ...header,
        text: translate(header.textKey),
    }))
);

const chartData = ref({
    conversionRate: {
        options: {
            chart: {
                id: "conversion-rate-chart",
                background: "transparent"
            },
            labels: ["converted", "not converted"],
            theme: {
                mode: isDarkMode.value ? "dark" : "light",
            },
            tooltip: {
                enabled: true,
                theme: isDarkMode.value ? "dark" : "light",
            },
            colors: ["#4CAF50", "#FF5252"],
        },
        series: [conversionRate, 100 - conversionRate],
    },
    revenueByCategory: {
        options: {
            chart: {
                id: "revenue-by-category-chart",
                background: "transparent"
            },
            theme: {
                mode: isDarkMode.value ? "dark" : "light",
            },
            tooltip: {
                theme: isDarkMode.value ? "dark" : "light",
            }
        },
        series: [],
    },
});
watchEffect(() => {
    if (chartData.value.revenueByCategory) {
        chartData.value.revenueByCategory.series = [
            {
                name: translate("re_dashboard.revenue"),
                data: computedRevenueByCategory.value.map((c) => c.revenue),
            },
        ];
    }
});

const exportToCSV = () => {
    const headers = computedTableHeaders.value.map(header => header.text);
    const data = computedRevenueByCategory.value.map(item => [item.category, item.revenue]);
    exportCSV(headers, data, 'revenue_by_category.csv');
};



</script>

<style scoped>
.v-data-table th {
    background-color: var(--background-color);
    font-weight: bold;
    color: var(--text-color);
}

.logo-container {
    display: flex;
    align-items: center;
}

.logo-image {
    width: 50px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.logo-image:hover {
    transform: scale(1.1);
}

.v-menu__content {
    background-color: var(--background-color) !important;
}

.v-application {
    background: var(--background-color) !important;
    color: var(--text-color) !important;
}

.v-list-item {
    color: black !important;
}

.v-menu__content {
    background-color: var(--background-color) !important;
    color: var(--text-color) !important;
}

.animated-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.animated-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
}

.main-expanded {
    transition: margin-left 0.3s ease;
}

.main-collapsed {
    transition: margin-left 0.3s ease;
}
</style>
