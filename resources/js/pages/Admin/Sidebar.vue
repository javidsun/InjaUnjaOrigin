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

<script>
//Todo:{routes:AdminDashboard /UserManagement /ads_management/AdsHouse/vehicles/events/AdsTraveler/Finance/ReservationManagement/Analytics/Notifications/SupportSystem}

import { translate } from "@/store/languageStore";

export default {
    name: 'SidebarComponent',
    data() {
        return {
            drawer: false,
            activePage: "dashboard",
            menuItems: [
                { title: "SIDEBAR_DASHBOARD", icon: "mdi-home", page: "AdminDashboard", link: "/AdminDashboard" },
                { title: "SIDEBAR_USERMANAGEMENT", icon: "mdi-account-multiple", page: "UserManagement", link: "/UserManagement" },
                { title: "SIDEBAR_ADS", icon: "mdi-home", page: "ads_management", link: "/ads_management" },
                { title: "SIDEBAR_HOUSES", icon: "mdi-home-city-outline", page: "houses", link: "/AdsHouse" },
                { title: "SIDEBAR_VEHICLES", icon: "mdi-car", page: "vehicles", link: "/vehicles" },
                { title: "SIDEBAR_EVENTS", icon: "mdi-calendar", page: "events", link: "/events" },
                { title: "SIDEBAR_TRAVELERS", icon: "mdi-account-group", page: "AdsTraveler", link: "/AdsTraveler" },
                { title: "SIDEBAR_FINANCE", icon: "mdi-currency-usd", page: "Finance", link: "/Finance" },
                { title: "SIDEBAR_RESERV", icon: "mdi-calendar-check", page: "ReservationManagement", link: "/ReservationManagement" },
                { title: "SIDEBAR_ANALYTICS", icon: "mdi-chart-areaspline", page: "Analytics", link: "/Analytics" },
                { title: "SIDEBAR_NOTIFICATIONS", icon: "mdi-bell", page: "Notifications", link: "/Notifications" },
                { title: "SIDEBAR_SUPPORTSYSTEM", icon: "mdi-headset", page: "SupportSystem", link: "/SupportSystem" },
            ]
        }
    },
    methods: {
        translate,
        goToPage(link) {
            try {
                this.$inertia.visit(link);
                this.setActivePage(this.getPageFromLink(link));
            } catch (error) {
                this.showErrorAlert('Navigation failed', 'An error occurred while trying to navigate');
                console.error('Navigation error:', error);
            }
        },

        setActivePage(page) {
            this.activePage = page;
        },

        getPageFromLink(link) {
            try {
                const item = this.menuItems.find(item => item.link === link);
                return item ? item.page : 'dashboard';
            } catch (error) {
                this.showErrorAlert('Page detection failed', 'Could not determine current page');
                console.error('Page detection error:', error);
                return 'dashboard';
            }
        },

        showErrorAlert(title, message) {
            this.$swal({
                title: title,
                text: message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }
}
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
