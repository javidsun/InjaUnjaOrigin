<template>
    <v-app-bar app dense class="app_bar">
        <v-row align="center" class="px-6">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" />
                </div>
            </v-col>

            <v-col cols="6">
                <Searchbar />
            </v-col>

            <v-col cols="4" class="d-flex justify-end align-center menu-wrapper">
                <div class="menu-item d-flex align-center">
                    <LanguageSwitcher />
                    <Darkmood />
                </div>
                <HamburgerMenu />
            </v-col>
        </v-row>
    </v-app-bar>
</template>

<script>
import LanguageSwitcher from './LanguageSwitcher.vue';
import HamburgerMenu from './HamburgerMenu.vue';
import Searchbar from './search/Searchbar.vue';
import Darkmood from './Darkmood.vue';

export default {
    components: {
        Darkmood,
        LanguageSwitcher,
        HamburgerMenu,
        Searchbar,
    },
};
</script>

<style scoped>
.app_bar {
    background-color: var(--background-color) !important;
    color: var(--text-color) !important;
    min-height: 80px;
    display: flex;
    align-items: center;
    box-shadow: none;
    z-index: 10;
    overflow: visible;
    transition: background-color 0.3s, color 0.3s;
}

.logo-container {
    display: flex;
    align-items: center;
    overflow: visible;
    filter: brightness(var(--logo-brightness, 1));
}

@media (min-width: 993px) {
    .logo-image {
        width: 75px;
    }
    .logo-container {
        flex-shrink: 0;
        padding-top: 7px;
    }
}

@media (max-width: 992px) {
    .logo-image {
        width: 70px;
    }
    .logo-container {
        flex-shrink: 0;
        padding-top: 7px;
    }
}

.menu-wrapper {
    display: flex;
    align-items: center;
    gap: 16px;
}

.menu-item {
    display: flex;
    gap: 10px;
}

</style>
