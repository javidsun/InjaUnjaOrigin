<template>
  <v-app>
    <v-app-bar app elevation="1" class="header">
      <v-col cols="2">
        <div class="logo-container">
            <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
        </div>
      </v-col>
      <v-spacer />
      <v-spacer />

      <Searchbar />
      <v-spacer />

      <Darkmood />
      <LanguageSwitcher />

    </v-app-bar>
    <Sidebar app v-model="drawer" permanent>...</Sidebar>
    <v-main class="main">
    </v-main>
    <Footer app class="footer">...</Footer>

  </v-app>
</template>

<script setup>
import { ref } from "vue";
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../../../../components/layout/Header/search/Searchbar.vue";
import Darkmood from "../../../../components/layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../../../components/layout/Header/LanguageSwitcher.vue";
import Footer from "../../../../components/layout/Footer.vue";
import Sidebar from "../../../Sidebar.vue";

const isDarkMode = ref(true);
const drawer = ref(true);

const toggleDarkMode = () => {
  isDarkMode.value = !isDarkMode.value;
};

const props = defineProps({
  navItems: {
    type: Array,
    required: true,
  },
});


</script>

<style scoped>
* {
  box-sizing: border-box;
}
body {
  overflow-x: hidden;
}

.main {
  background-color: var(--background-color);
  transition: all 0.5s ease;
  padding-top: 64px;
  padding-left: 240px;
}
.footer {
  margin-left: 100px;
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
}
.sidebar {
  width: 240px;
}

.Footer {
  z-index: 900;
  position: fixed;
  height: 100%;
  left: 0;
  top: 0;
}

</style>
