<template>
  <v-container>
    <v-row>
      <v-col cols="12" md="4">
        <v-card class="card-dashboard">
          <v-card-title>{{ translate('re_dashboard.conversionRate') }}</v-card-title>
          <v-card-text class="text1">
            <p>{{ translate('re_dashboard.conversionRateDescription') }}</p>
            <apex-chart
                type="pie"
                height="360"
                :options="chartData.conversionRate.options"
                :series="chartData.conversionRate.series"
            />
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card class="card-dashboard">
          <v-card-title>{{ translate('re_dashboard.revenueByCategory') }}</v-card-title>
          <v-card-text class="text1">
            <apex-chart
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
            />
          </v-card-text>
        </v-card>
      </v-col>

=      <v-col cols="12" md="4">
        <v-card class="card-dashboard text1">
          <v-card-title>{{ translate('re_dashboard.geoActivity') }}</v-card-title>
          <v-card-text>
            <apex-chart
                type="bar"
                height="410"
                :options="chartData.geoActivity.options"
                :series="chartData.geoActivity.series"
            />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref, computed } from "vue";
import ApexChart from "vue3-apexcharts";
import { translate } from "@/store/languageStore.js";

const conversionRate = 25;

const revenueByCategory = ref([
  { categoryKey: "re_dashboard.Home", revenue: 5000 },
  { categoryKey: "re_dashboard.Car", revenue: 2000 },
  { categoryKey: "re_dashboard.Others", revenue: 1000 },
]);

const topCities = ref([
  { cityKey: "re_dashboard.Barcelona", countryKey: "re_dashboard.Spain", bookings: 120 },
  { cityKey: "re_dashboard.Paris", countryKey: "re_dashboard.France", bookings: 110 },
  { cityKey: "re_dashboard.Rome", countryKey: "re_dashboard.Italy", bookings: 100 },
  { cityKey: "re_dashboard.Berlin", countryKey: "re_dashboard.Germany", bookings: 90 },
  { cityKey: "re_dashboard.Amsterdam", countryKey: "re_dashboard.Netherlands", bookings: 80 },
]);

const computedRevenueByCategory = computed(() =>
    revenueByCategory.value.map((item) => ({
      ...item,
      category: translate(item.categoryKey),
    }))
);

const computedTopCities = computed(() =>
    topCities.value.map((item) => ({
      ...item,
      city: translate(item.cityKey),
      country: translate(item.countryKey),
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

const chartData = {
  conversionRate: {
    options: {
      chart: { id: "conversion-rate-chart", background: "transparent" },
      legend: { position: "top" },
      labels: [translate("re_dashboard.Reservation"), translate("re_dashboard.Visit")],
    },
    series: [conversionRate, 100 - conversionRate],
  },
  revenueByCategory: {
    options: {
      chart: { id: "revenue-by-category-chart" },
      xaxis: { categories: computedRevenueByCategory.value.map((c) => c.category) },
    },
    series: [
      {
        name: translate("re_dashboard.revenue"),
        data: computedRevenueByCategory.value.map((c) => c.revenue),
      },
    ],
  },
  geoActivity: {
    options: {
      chart: { id: "geo-activity-chart" },
      xaxis: {
        categories: computedTopCities.value.map((city) => `${city.city} - ${city.country}`),
      },
    },
    series: [
      {
        name: translate("re_dashboard.Reservation"),
        data: computedTopCities.value.map((city) => city.bookings),
      },
    ],
  },
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
</style>
