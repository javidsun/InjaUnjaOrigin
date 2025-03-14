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

        <Sidebar app v-model="drawer" :class="{ active: drawer }" />

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid>
                <v-row>
                    <v-col cols="12" class="dashboard-card">
                        <Warning />
                    </v-col>
                    <v-col cols="12"   md="6"  class="dashboard-card">
                        <BasicStatistics />
                    </v-col>
                    <v-col cols="12"  md="6"     class="dashboard-card">
                        <Functional />
                    </v-col>
                    <v-col cols="12" class="dashboard-card">
                        <Services />
                    </v-col>
<!--                    <v-col cols="12"  class="dashboard-card">-->
<!--                        <Report />-->
<!--                    </v-col>-->
                    <v-col cols="12" class="dashboard-card">
                        <UserTable />
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <Footer app class="footer">...</Footer>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../layout/Header/search/Searchbar.vue";
import Darkmood from "../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../layout/Header/LanguageSwitcher.vue";
import Footer from "../layout/Footer.vue";
import Sidebar from "./Sidebar.vue";
import Warning from './dashboard_main/warning.vue'
import BasicStatistics from './dashboard_main/BasicStatistics.vue'
import Report from './dashboard_main/Reports.vue'
import Services from './dashboard_main/Services.vue'
import Functional from './dashboard_main/functional.vue'
import UserTable from './dashboard_main/UserTable.vue'

const isDarkMode = ref(true);
const drawer = ref(true);
</script>

<style scoped>
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

.language{
    margin-right: 80px!important;
}

.darkmood{
    margin-right: 20px!important;
}

.main-expanded {
    padding-left: 240px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
    padding-top: 64px;
}
.logo-image {
    width: 70px;
}

.main-collapsed {
    padding-left: 80px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
}

@media (max-width: 600px) {
    .main-expanded {
        padding-left: 0;
    }

    .main-collapsed {
        padding-left: 0;
    }

    .dashboard-card {
        width: 100% !important;
        font-size: 0.9rem;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--sidebar-background-color);
        transition: transform 0.3s ease;
        transform: translateX(-100%);
    }

    .sidebar.active {
        transform: translateX(0);
    }
    .logo-image {
        width: 50px;
    }
    .darkmood{
        margin-right: -10px!important;

    }
    .language{
        margin-right: -20px;
    }
}
.header{
    color: var(--text-color);
    background-color: var(--background-color);

}
</style>
