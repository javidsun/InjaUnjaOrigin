<template>
    <v-app class="app-container">
        <Header />
        <v-main class="main-container">

            <ContentSection />
        </v-main>

        <Footer />
    </v-app>
</template>


<script>

import Header from './layout/Header/Header.vue';
import Footer from './layout/Footer.vue';
import ContentSection from './layout/sections/ContentSection.vue';

export default {
        name: 'Home2',

        components: {
        Header,
        Footer,
        ContentSection,

    },
};
</script>

<style scoped>
html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
    overflow-x: hidden;
}

.app-container {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.main-container {
    flex: 1;
    padding: 15px;
    background-color: var(--background-color);
    color: var(--text-color);
    transition: background-color 0.3s, color 0.3s;
}

.footer {
    flex-shrink: 0;
}
</style>
