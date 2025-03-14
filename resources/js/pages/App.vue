<template>
    <div id="app">
        <router-view />
    </div>
</template>

<script setup>

import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import { ref, watch } from "vue";

const isDarkMode = ref(true);

const vuetify = createVuetify({
    theme: {
        defaultTheme: 'dark',
        icons: {
            defaultSet: 'mdi',
            aliases,
            sets: {mdi},
        },
    },
});
watch(isDarkMode, (newValue) => {
    const body = document.body;
    if (newValue) {
        body.classList.add("dark-mode");
        body.classList.remove("light-mode");
    } else {
        body.classList.add("light-mode");
        body.classList.remove("dark-mode");
    }
});

</script>
<style>
:root {
    --background-color: #121213;
    --liner-background: linear-gradient(135deg, #161626, #323233);
    --text-color: #F8FAFC;
    --primary-color: #fffff6;
    --logo-brightness: 100%;
    --txt-color: #F2E5BF;
    --background-color--groups: #585d5e;
    --search-background-color: #ffffff;
    --AdsList-background-color: #D2D5E0FF;
    --sidebar-background-color: #2a2d2d;
    --sidebar-text-color: #ffffff;
    --sidebar-icon-color: #ece3e3;
    --sidebar-active-text-color: #6984c0;
    --report-title-text-color: #27243d;
    --report-back-color: #b6d2e3;
    --report-back2-color: #c6d8ef;
    --v-surface: #ecf1ff;
    --v-primary-darken1: #27243d;
    --backgroundcards-color--groups: #2a2a3a;
    --backgroundcards2-color--groups: #cccccc;
    --backgroundcards3-color--groups: #161626;
    --text-card-color--groups: #cccccc;
    --backgroundcards-color--profile: #2c294f;
    --border-color:#2a2a3b;
    --background-color--groups2: #858585;
    --price-color: #dee8f6;
    --background-color--groups3: #121213;
}

.dark-mode {
    --background-color: #121213;
    --liner-background: linear-gradient(135deg, #161626, #323233);
    --text-color: #F8FAFC;
    --primary-color: #fffff6;
    --logo-brightness: 100%;
    --txt-color: #F2E5BF;
    --background-color--groups: #585d5e;
    --search-background-color: #333333;
    --AdsList-background-color: #D2D5E0FF ;
    --sidebar-background-color: #2a2d2d;
    --sidebar-text-color: #ffffff;
    --sidebar-icon-color: #ffffff;
    --sidebar-active-text-color: #6984c0;
    --report-title-text-color: #27243d;
    --report-back-color: #b6d2e3;
    --report-back2-color: #c6d8ef;
    --v-surface: #ecf1ff;
    --backgroundcards-color--groups: #2a2a3a;
    --backgroundcards2-color--groups: #cccccc;
    --backgroundcards3-color--groups: #a3b1be;
    --text-card-color--groups: #cccccc;
    --backgroundcards-color--profile: #2c294f;
    --border-color:#2a2a3b;
    --background-color--groups2: #858585;
    --price-color: #dee8f6;
    --background-color--groups3: #121213;

}

body {
    background-color: var(--background-color) !important;
    color: var(--text-color) !important;
}

button {
    background-color: var(--primary-color);
    color: var(--text-color);
}
.light-mode {
    --background-color: #ffffff;
    --liner-background: linear-gradient(135deg, #a79ada, #eaeaea);
    --text-color: #000000;
    --primary-color: #0b5394;
    --logo-brightness: 70%;
    --txt-color: #181C14;
    --background-color--groups: #b7b5b5;
    --search-background-color: #eae9e9;
    --AdsList-background-color: #d7d7d7;
    --sidebar-background-color: #d7d7d7;
    --sidebar-text-color: #161626;
    --sidebar-icon-color: #161626;
    --sidebar-active-text-color: #a8baec;
    --report-title-text-color: #0a2359;
    --report-back-color: #d7d7d7;
    --report-back2-color: #d7d7d7;
    --v-surface: #d7d7d7;
    --backgroundcards-color--groups: #d7d7d7;
    --backgroundcards2-color--groups: #d7d7d7;
    --backgroundcards3-color--groups: #d7d7d7;
    --text-card-color--groups: #161626;
    --backgroundcards-color--profile: #e4dfff;
    --border-color:#d7d7d7;
    --background-color--groups2: #676767;
    --price-color: #dee8f6;
    --background-color--groups3: #858585;

}

</style>
