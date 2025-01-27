<template>
  <v-navigation-drawer
      app
      v-model="drawer"
      class="sidebar"
  >
    <v-list dense class="sidebar2">
      <v-list-item-group v-model="activePage">
        <v-list-item
            v-for="(item, index) in menuItems"
            :key="index"
            @click="setActivePage(item.page)"
            :to="item.link"
            :active="activePage === item.page"
        >
          <v-list-item-content class="v-list-item-content">
            <v-list-item-icon class="v-list-item-icon">
              <v-icon class="sidebar-icon" large>{{ item.icon }}</v-icon>
            </v-list-item-icon>
            <v-list-item-title class="sidebar-title">{{ t(item.title) }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-navigation-drawer>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../store/languageStore";

const drawer = ref(false);

const activePage = ref("dashboard");

const setActivePage = (page) => {
  activePage.value = page;
};

const menuItems = [
  { title: "sidebar.dashboard", icon: "mdi-home", page: "dashboard", link: "/dashboard" },
  { title: "sidebar.userManagement", icon: "mdi-account-multiple", page: "user-management", link: "/dashboard/user-management" },
  { title: "sidebar.ads", icon: "mdi-home", page: "ads_management", link: "/dashboard/ads_management" },
  { title: "sidebar.houses", icon: "mdi-home-city-outline", page: "houses", link: "/dashboard/houses" },
  { title: "sidebar.vehicles", icon: "mdi-car", page: "vehicles", link: "/dashboard/vehicles" },
  { title: "sidebar.events", icon: "mdi-calendar", page: "events", link: "/dashboard/events" },
  { title: "sidebar.travelers", icon: "mdi-account-group", page: "travelers", link: "/dashboard/travelers" },
  { title: "sidebar.analytics", icon: "mdi-chart-areaspline", page: "analytics", link: "/dashboard/analytics" },
  { title: "sidebar.notifications", icon: "mdi-bell", page: "notifications", link: "/dashboard/notifications" },
  { title: "sidebar.reports", icon: "mdi-file-chart", page: "reports", link: "/dashboard/reports" },
  { title: "sidebar.settings", icon: "mdi-cog", page: "settings", link: "/dashboard/settings" },
  { title: "sidebar.finance", icon: "mdi-currency-usd", page: "finance", link: "/dashboard/finance" },
];
</script>

<style scoped>
.sidebar {
  background-color: var(--sidebar-background-color);
  transition: background-color 0.3s ease;
}

.sidebar2 {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.sidebar-title {
  color: var(--sidebar-text-color);
  font-size: 18px;
  font-weight: 500;
  margin: 0;
  line-height: 1;
  padding-left: 10px;
}

.sidebar-icon {
  color: var(--sidebar-icon-color);
}

.v-list-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 12px 16px;
  gap: 8px;
  transition: background-color 0.3s ease, color 0.3s ease;
}

@media (max-width: 600px) {
  .sidebar {
    max-width: 150px;
    font-size: 10px;
  }
}

.dark-mode {
  color: #ffffff !important;
}

.dark-mode .sidebar-title {
  color: #ffffff !important;
}

.v-list-item-content {
  display: flex;
  align-items: center;
  font-family: "2  Baran",serif;
}
</style>
