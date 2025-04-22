<!--فایل  UserSidebar.js در services      فایل   UserSidebar.json در پوشه docs -->



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
                        <v-list-item-title class="sidebar-title">{{ translate(item.title) }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>

        </v-list>
    </v-navigation-drawer>

</template>

<script setup>
//TODO : composition --> option & const & error warning

import {ref} from 'vue';
import {translate} from "@/store/languageStore.js";
import {useRouter} from 'vue-router';
import {Inertia} from '@inertiajs/inertia';

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
    {title: "UserSidebar.UserDashboard", icon: "mdi-view-dashboard", page: "UserDashboard", link: "/UserDashboard"},
    {title: "UserSidebar.createAdForm", icon: "mdi-plus-box", page: "createAdForm", link: "/createAdForm"},
    {title: "UserSidebar.UserProfile", icon: "mdi-account", page: "UserProfile", link: "/UserProfile"},
    {
        title: "UserSidebar.UserReservations",
        icon: "mdi-calendar-check",
        page: "MyReservations",
        link: "/MyReservations"
    },
    {title: "UserSidebar.MyAds", icon: "mdi-format-list-bulleted", page: "MyAds", link: "/MyAds"},
    {title: "UserSidebar.houses", icon: "mdi-home-city", page: "houses", link: "/houses"},
    {title: "UserSidebar.vehicles", icon: "mdi-car", page: "vehicles", link: "/vehicles"},
    {title: "UserSidebar.events", icon: "mdi-calendar-star", page: "events", link: "/events"},
    {title: "UserSidebar.travelers", icon: "mdi-account-group", page: "travelers", link: "/travelers"},
    {title: "UserSidebar.Messages", icon: "mdi-message", page: "Messages", link: "/Messages"},
    {title: "UserSidebar.UserFinance", icon: "mdi-finance", page: "UserFinance", link: "/UserFinance"},
    {title: "UserSidebar.UserSettings", icon: "mdi-cog", page: "UserSettings", link: "/UserSettings"},
    {title: "UserSidebar.Support", icon: "mdi-help-circle", page: "Support", link: "/Support"},
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
