<!--فایل  Sidebar.js در services      فایل   Sidebar.json در پوشه docs -->


<template>
  <v-navigation-drawer
      app
      v-model="drawer"
      class="sidebar"
  >
      <v-list dense class="sidebar">
          <v-list-item-group v-model="activePage">
              <v-list-item
                  v-for="(item, index) in menuItems"
                  :key="index"
                  @click="goToPage(item.link)"
                  :active="activePage === item.page"
              >

                  <v-list-item-content class="v-list-item-content">
                      <v-list-item-icon class="v-list-item-icon">
                          <v-icon class="sidebar-icon" large>{{ item.icon }}</v-icon>
                      </v-list-item-icon>
                      <v-list-item-title class="sidebar-title sidebar2">{{ translate(item.title) }}</v-list-item-title>
                  </v-list-item-content>
              </v-list-item>
          </v-list-item-group>

      </v-list>
  </v-navigation-drawer>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import { ref } from 'vue';
import { translate } from "@/store/languageStore.js";
import { useRouter } from 'vue-router';
import { Inertia } from '@inertiajs/inertia';

const goToPage = (link) => {
    Inertia.visit(link);
};

const router = useRouter();

const drawer = ref(false);

const activePage = ref("dashboard");

const setActivePage = (page) => {
    activePage.value = page;
};
const menuItems = [
    { title: "sidebar.dashboard", icon: "mdi-home", page: "AdminDashboard", link: "/AdminDashboard" },
    { title: "sidebar.userManagement", icon: "mdi-account-multiple", page: "UserManagement", link: "/UserManagement" },
    { title: "sidebar.ads", icon: "mdi-home", page: "ads_management", link: "/ads_management" },
    { title: "sidebar.houses", icon: "mdi-home-city-outline", page: "houses", link: "/AdsHouse" },
    { title: "sidebar.vehicles", icon: "mdi-car", page: "vehicles", link: "/vehicles" },
    { title: "sidebar.events", icon: "mdi-calendar", page: "events", link: "/events" },
    { title: "sidebar.travelers", icon: "mdi-account-group", page: "AdsTraveler", link: "/AdsTraveler" },
    { title: "sidebar.finance", icon: "mdi-currency-usd", page: "Finance", link: "/Finance" },
    { title: "sidebar.reserv", icon: "mdi-calendar-check", page: "ReservationManagement", link: "/ReservationManagement" },
    { title: "sidebar.analytics", icon: "mdi-chart-areaspline", page: "Analytics", link: "/Analytics" },
    { title: "sidebar.notifications", icon: "mdi-bell", page: "Notifications", link: "/Notifications" },
    { title: "sidebar.SupportSystem", icon: "mdi-headset", page: "SupportSystem", link: "/SupportSystem" },

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
    .sidebar2{
        font-size: 12px;
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
