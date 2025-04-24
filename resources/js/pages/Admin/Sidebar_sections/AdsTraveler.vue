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
                        <travelers/>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import Sidebar from "../Sidebar.vue";
import { ref } from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import travelers from '../../layout/sections/Groups/Travel Ads/TravelersContent.vue';

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
.language{
    margin-right: 80px!important;
}
.darkmood{
    margin-right: 20px!important;
}

@media (max-width: 600px) {
    .main {
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

@media (max-width: 600px) {

    .main-expanded {
        margin-left: 0;
    }

    .main-collapsed {
        margin-left: 0;
    }

    .v-app-bar .logo-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .v-app-bar .logo-image {
        max-width: 80%;
    }
}

</style>
