<template>
    <div>
        <v-btn
            icon
            @click="menuActive = !menuActive"
            :class="['menu-button', { 'menu-active': menuActive }]"
        >
            <v-icon>mdi-menu</v-icon>
        </v-btn>

        <v-menu v-model="menuActive" class="menu_open">
            <v-list>

<!--                <v-responsive max-width="599">-->
<!--                    <Searchbar :showInMenu="true" />-->
<!--                    <v-divider></v-divider>-->
<!--                </v-responsive>-->

                <v-list-item @click="navigateTo('/register')">
                    <v-list-item-title class="H_menu">{{ t('menu.register') }}</v-list-item-title>
                </v-list-item>
                <v-list-item @click="navigateTo('/login')">
                    <v-list-item-title class="H_menu">{{ t('menu.login') }}</v-list-item-title>
                </v-list-item>

                <v-divider></v-divider>
                <v-list-item @click="navigateTo('/add-property')">
                    <v-list-item-title class="H_menu">{{ t('menu.addProperty') }}</v-list-item-title>
                </v-list-item>
                <v-list-item @click="navigateTo('/gift-card')">
                    <v-list-item-title class="H_menu">{{ t('menu.giftCard') }}</v-list-item-title>
                </v-list-item>
                <v-list-item @click="navigateTo('/inja-unja')">
                    <v-list-item-title class="H_menu">{{ t('menu.injaUnja') }}</v-list-item-title>
                </v-list-item>
                <v-list-item @click="navigateTo('/help-center')">
                    <v-list-item-title class="H_menu">{{ t('menu.helpCenter') }}</v-list-item-title>
                </v-list-item>
            </v-list>

        </v-menu>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { t } from "../../../store/languageStore";
import Searchbar from "./search/Searchbar.vue";
import { useRouter } from "vue-router";

const navigateTo = (url) => {
    if (useRouter) {
        useRouter.push(url);
    } else {
        console.error('Router instance is not available');
    }
};

const menuActive = ref(false);
</script>

<style scoped>
.menu_open {
    padding-right: 0;
    display: flex;
    justify-content: right;
    align-items: inherit;
    margin-top: 60px;
    margin-right: 10px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

.H_menu {
    font-size: 12px;
    padding-left: 5px;
    padding-right: 90px;
    margin: 0;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.menu-button {
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 10px;
    margin-right: 40px;
}

.menu-button.menu-active {
    background-color: #e0e0e0;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}
</style>
