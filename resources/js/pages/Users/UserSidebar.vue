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
                    @click="goToPage(item.link)"
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
import { useRouter } from 'vue-router';

const router = useRouter();
const goToPage = (link) => {
    router.push(link);
};

const drawer = ref(false);

const activePage = ref("dashboard");

const setActivePage = (page) => {
  activePage.value = page;
};
const menuItems = [
  { title: "UserSidebar.UserDashboard", icon: "mdi-home", page: "UserDashboard", link: "/UserDashboard" },
  { title: "UserSidebar.createAdForm", icon: "mdi-home", page: "createAdForm", link: "/createAdForm" },
  { title: "UserSidebar.UserProfile", icon: "mdi-account-multiple", page: "UserProfile", link: "/UserProfile" },
  { title: "UserSidebar.UserReservations", icon: "mdi-home", page: "UserReservations", link: "/UserReservations" },
  { title: "UserSidebar.MyAds", icon: "mdi-home", page: "MyAds", link: "/MyAds" },
  { title: "UserSidebar.houses", icon: "mdi-home-city-outline", page: "houses", link: "/houses" },
  { title: "UserSidebar.vehicles", icon: "mdi-car", page: "vehicles", link: "/vehicles" },
  { title: "UserSidebar.events", icon: "mdi-calendar", page: "events", link: "/events" },
  { title: "UserSidebar.travelers", icon: "mdi-account-group", page: "travelers", link: "/travelers" },
  { title: "UserSidebar.notifications", icon: "mdi-bell", page: "notifications", link: "/notifications" },
  { title: "UserSidebar.UserFinance", icon: "mdi-file-chart", page: "UserFinance", link: "/UserFinance" },
  { title: "UserSidebar.UserSettings", icon: "mdi-cog", page: "UserSettings", link: "/UserSettings" },
  { title: "UserSidebar.Support", icon: "mdi-currency-usd", page: "Support", link: "/Support" },
];
</script>


<style scoped>
.sidebar {
    background-color: var(--sidebar-background-color);
    transition: background-color 0.3s ease;
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    width: 240px;
    z-index: 1000;
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
  line-height: 1.2;
  padding-left: 12px;
}

.sidebar-icon {
  color: var(--sidebar-icon-color);
  font-size: 28px;
}

.v-list-item {
  display: flex;
  flex-direction: row;
  align-items: center;
  padding: 16px 20px;
  margin-bottom: 10px;
  gap: 12px;
  transition: background-color 0.3s ease, color 0.3s ease;
  border-radius: 8px;
}

.v-list-item:hover {
  background-color: var(--sidebar-active-text-color);
  color: var(--report-title-text-color);
}

.v-list-item-content {
  display: flex;
  align-items: center;
  font-family: "2  Baran", serif;
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
</style>
