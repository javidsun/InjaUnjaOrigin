<template class="main">
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header" id="dashboardIcon">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer"/>
                </div>
            </v-col>
            <v-spacer/>
            <v-spacer/>
            <Darkmood class="darkmood"/>
            <LanguageSwitcher class="language"/>

            <v-btn icon @click="menuActive = !menuActive" class="menu-button">
                <v-avatar size="40px" v-bind="attrs" v-on="on" class="img2">
                    <img :src="userProfileImage" alt="User Profile"/>
                </v-avatar>
            </v-btn>
            <v-menu v-model="menuActive" class="menu_open" right>
                <v-list>
                    <v-list-item @click="logout">
                        <v-list-item-title>{{ translate('PROFILE_LOGOUT') }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <UserSidebar app v-model="drawer"/>

        <v-main>
            <slot/>
        </v-main>
        <Footer/>
    </v-app>
</template>

<script>
//Todo:userProfileImage/isDarkMode: true/drawer: true/menuActive: true/navigateTo:logout

import {translate} from "@/store/languageStore";
import UserSidebar from "./UserSidebar.vue";
import {useRouter} from 'vue-router';
import Darkmood from "../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../layout/Header/LanguageSwitcher.vue";
import Footer from "../layout/Footer.vue";

export default {
    components: {
        Darkmood,
        LanguageSwitcher,
        UserSidebar,
        Footer
    },
    data() {
        return {
            userProfileImage: '/avatar-2.png',
            isDarkMode: true,
            drawer: true,
            menuActive: false,
            router: useRouter()
        };
    },
    methods: {
        translate,
        navigateTo(path) {
            this.router.push(path);
            this.menuActive = false;
        },
        logout() {
            console.log("Log out of your account...");
            window.location.href = "/";
        }
    },
    mounted() {
        window.addEventListener("update-avatar", (event) => {
            this.userProfileImage = event.detail;
        });
    }
};
</script>

<style scoped>
.header {
    z-index: 1000;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: var(--background-color);
}

.main {
    background-color: var(--background-color);
}

.language, .darkmood {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}

.darkmood {
}

.language {
    margin-right: 20px;
}

.img2 img {
    object-fit: cover;
    width: 100%;
    height: 100%;
    border-radius: 50%;
}

.img2 {
    margin-right: 20px;
    margin-top: 10px;
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

.menu-button {
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 1px;
    margin-right: 40px;
}

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

</style>
