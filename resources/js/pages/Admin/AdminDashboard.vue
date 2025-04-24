<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer"/>
                </div>
            </v-col>
            <v-spacer/>

            <Searchbar/>
            <v-spacer/>

            <Darkmood class="darkmood"/>
            <LanguageSwitcher class="language"/>
        </v-app-bar>

        <Sidebar app v-model="drawer"/>

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid>

                <v-row>
                    <v-col cols="12">
                        <warning/>
                    </v-col>
                    <v-col cols="12" md="6" style="width: 200px;">
                        <BasicStatistics/>
                    </v-col>
                    <v-col cols="12" md="6" style="width: 200px;">
                        <functional/>
                    </v-col>
                    <v-col cols="12">
                        <Services/>
                    </v-col>
                    <v-col cols="12">
                        <Report/>
                    </v-col>
                    <v-col cols="12">
                        <UserTable/>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <Footer app class="footer">...</Footer>
    </v-app>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import {ref, computed} from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../../layout/Header/LanguageSwitcher.vue";
import Footer from "../../../layout/Footer.vue";
import Sidebar from "../../Sidebar.vue";

const imageUrl = '/illustration-1.png';
const imageUrl2 = '/illustration-2.png';
import warning from './dashboard_main/warning.vue'
import BasicStatistics from './dashboard_main/BasicStatistics.vue'
import Report from './Sidebar_sections/Reports.vue'
import Services from './dashboard_main/Services.vue'
import functional from './dashboard_main/functional.vue'
import UserTable from './dashboard_main/UserTable.vue'
import {useRouter} from 'vue-router';

const router = useRouter();

const props = defineProps({
    type: Array,
});

const isDarkMode = ref(true);
const drawer = ref(true);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
};

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

@media (max-width: 600px) {
    .main {
        padding-left: 0;
        margin-left: 150px;
        margin-bottom: 100px;
    }
}

@media (max-width: 960px) {
    .main {
        margin-bottom: 70px;
    }
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


</style>
