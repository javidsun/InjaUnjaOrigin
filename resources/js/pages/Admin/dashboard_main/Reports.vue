<template>
    <v-container fluid>
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
            <v-card>
                <v-card-title class="headline">{{ tableDetailsTitle }}</v-card-title>
                <v-card-text>
                    <v-alert v-if="errorMessage" type="error" class="mb-4">
                        {{ errorMessage }}
                    </v-alert>

                    <div v-if="tableDetailsKey === 'conversionRate'">
                        <apex-chart
                            type="donut"
                            height="360"
                            :options="chartData.conversionRate.options"
                            :series="chartData.conversionRate.series"
                        />
                    </div>

                    <div v-else-if="tableDetailsKey === 'revenueByCategory'">
                        <v-data-table
                            :headers="computedTableHeaders"
                            :items="computedRevenueByCategory"
                            class="elevation-1"
                        ></v-data-table>
                    </div>

                    <div v-else-if="tableDetailsKey === 'geoActivity'">
                        <v-data-table
                            :headers="geoActivityHeaders"
                            :items="computedTopCities"
                            class="elevation-1"
                        ></v-data-table>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="tableDetailsVisible = false">
                        {{ translate('common.close') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
//Todo:  "conversionRate: value/ total /labels:Reservation, Visit
//revenueByCategory: {categoryKey /revenue
// geoActivity:cityKey /countryKey /bookings
import { translate } from "@/store/languageStore.js";
import ApexChart from "vue3-apexcharts";

export default {
    name: 'Reports',
    components: {
        ApexChart
    },
    data() {
        return {
            conversionRate: 25,
            revenueByCategory: [
                { categoryKey: "re_dashboard.Home", revenue: 5000 },
                { categoryKey: "re_dashboard.Car", revenue: 2000 },
                { categoryKey: "re_dashboard.Others", revenue: 1000 },
            ],
            topCities: [
                { cityKey: "re_dashboard.Barcelona", countryKey: "re_dashboard.Spain", bookings: 120 },
                { cityKey: "re_dashboard.Paris", countryKey: "re_dashboard.France", bookings: 110 },
                { cityKey: "re_dashboard.Rome", countryKey: "re_dashboard.Italy", bookings: 100 },
                { cityKey: "re_dashboard.Berlin", countryKey: "re_dashboard.Germany", bookings: 90 },
                { cityKey: "re_dashboard.Amsterdam", countryKey: "re_dashboard.Netherlands", bookings: 80 },
            ],
            tableHeaders: [
                { textKey: "re_dashboard.category", key: "category" },
                { textKey: "re_dashboard.revenue", key: "revenue" },
            ],
            geoActivityHeaders: [
                { textKey: "re_dashboard.city", key: "city" },
                { textKey: "re_dashboard.country", key: "country" },
                { textKey: "re_dashboard.bookings", key: "bookings" },
            ],
            tableDetailsVisible: false,
            tableDetailsKey: "",
            errorMessage: ""
        };
    },
    computed: {
        computedRevenueByCategory() {
            try {
                return this.revenueByCategory.map(item => ({
                    ...item,
                    category: this.translate(item.categoryKey)
                }));
            } catch (error) {
                this.handleError("Failed to compute revenue by category", error);
                return [];
            }
        },
        computedTopCities() {
            try {
                return this.topCities.map(item => ({
                    ...item,
                    city: this.translate(item.cityKey),
                    country: this.translate(item.countryKey)
                }));
            } catch (error) {
                this.handleError("Failed to compute top cities", error);
                return [];
            }
        },
        computedTableHeaders() {
            try {
                return this.tableHeaders.map(header => ({
                    ...header,
                    text: this.translate(header.textKey)
                }));
            } catch (error) {
                this.handleError("Failed to compute table headers", error);
                return [];
            }
        },
        chartData() {
            return {
                conversionRate: {
                    options: {
                        chart: { id: "conversion-rate-chart", background: "transparent" },
                        legend: { position: "top" },
                        labels: [
                            this.translate("re_dashboard.Reservation"),
                            this.translate("re_dashboard.Visit")
                        ],
                    },
                    series: [this.conversionRate, 100 - this.conversionRate],
                },
                revenueByCategory: {
                    options: {
                        chart: { id: "revenue-by-category-chart" },
                        xaxis: {
                            categories: this.computedRevenueByCategory.map(c => c.category)
                        },
                    },
                    series: [
                        {
                            name: this.translate("re_dashboard.revenue"),
                            data: this.computedRevenueByCategory.map(c => c.revenue),
                        },
                    ],
                },
                geoActivity: {
                    options: {
                        chart: { id: "geo-activity-chart" },
                        xaxis: {
                            categories: this.computedTopCities.map(
                                city => `${city.city} - ${city.country}`
                            ),
                        },
                    },
                    series: [
                        {
                            name: this.translate("re_dashboard.Reservation"),
                            data: this.computedTopCities.map(city => city.bookings),
                        },
                    ],
                },
            };
        },
        tableDetailsTitle() {
            try {
                switch (this.tableDetailsKey) {
                    case "conversionRate":
                        return this.translate("re_dashboard.conversionRate");
                    case "revenueByCategory":
                        return this.translate("re_dashboard.revenueByCategory");
                    case "geoActivity":
                        return this.translate("re_dashboard.geoActivity");
                    default:
                        return "";
                }
            } catch (error) {
                this.handleError("Failed to get table details title", error);
                return "";
            }
        }
    },
    methods: {
        translate,

        showTableDetails(key) {
            try {
                this.tableDetailsKey = key;
                this.tableDetailsVisible = true;
            } catch (error) {
                this.handleError("Failed to show table details", error);
            }
        },
        handleError(message, error) {
            this.errorMessage = `${message}: ${error.message}`;
            console.error(message, error);

            this.$notify({
                title: 'Error',
                text: message,
                type: 'error',
                duration: 5000
            });
        }
    }
};
</script>

<style scoped>
.card-dashboard {
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    background-color: var(--report-back-color);
}

.card-dashboard:hover {
    transform: translateY(-5px);
}

.card-dashboard .v-card-title {
    font-weight: bold;
    font-size: 22px;
    color: var(--report-title-text-color);
    font-family: "2 Baran", serif;
}

.datatable {
    background-color: var(--report-back2-color);
    border-radius: 10%;
}

.animated-card {
    transition: all 0.3s ease;
}
</style>
