<template>
    <v-btn class="dark-mode-btn" icon @click="toggleDarkMode">
        <v-icon>{{ isDarkMode ? 'mdi-weather-sunny' : 'mdi-moon-waxing-crescent' }}</v-icon>
    </v-btn>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isDarkMode = ref(true);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;

    const themeClass = isDarkMode.value ? 'dark-mode' : 'light-mode';
    document.body.setAttribute('class', themeClass);

    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    isDarkMode.value = savedTheme === 'dark' || savedTheme === null;
    document.body.setAttribute('class', isDarkMode.value ? 'dark-mode' : 'light-mode');
});
</script>

<style scoped>
.dark-mode-btn {
    background-color: transparent;
    box-shadow: none;
    border: none;
    display: flex;
    justify-content: right;
    align-items: center;
    font-size: 18px;
    color: orange;
    transition: color 0.3s;
    margin-top: 10px;
    margin-right: 10px;
}

.dark-mode-btn:hover {
    color: #3700b3;
}
</style>
