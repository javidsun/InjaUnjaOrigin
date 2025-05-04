<template>
    <v-btn
        class="dark-mode-btn"
        icon
        @click="toggleDarkMode"
        :title="isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
    >
        <v-icon>{{ isDarkMode ? 'mdi-weather-sunny' : 'mdi-moon-waxing-crescent' }}</v-icon>
    </v-btn>
</template>

<script>
export default {
    name: 'DarkMode',
    data() {
        return {
            isDarkMode: true
        }
    },
    methods: {
        toggleDarkMode() {
            try {
                this.isDarkMode = !this.isDarkMode;
                this.applyTheme();
                this.saveThemePreference();
            } catch (error) {
                console.error('Error toggling dark mode:', error);
                this.isDarkMode = false;
                this.applyTheme();
            }
        },
        applyTheme() {
            try {
                const themeClass = this.isDarkMode ? 'dark-mode' : 'light-mode';
                document.body.setAttribute('class', themeClass);
            } catch (error) {
                console.error('Error applying theme:', error);
            }
        },
        saveThemePreference() {
            try {
                localStorage.setItem('theme', this.isDarkMode ? 'dark' : 'light');
            } catch (error) {
                console.error('Error saving theme preference:', error);
            }
        },
        loadThemePreference() {
            try {
                const savedTheme = localStorage.getItem('theme');
                this.isDarkMode = savedTheme === 'dark' || savedTheme === null;
                this.applyTheme();
            } catch (error) {
                console.error('Error loading theme preference:', error);
                this.isDarkMode = true;
                this.applyTheme();
            }
        }
    },
    mounted() {
        this.loadThemePreference();
    }
}
</script>

<style scoped>
.dark-mode-btn {
    background-color: transparent;
    box-shadow: none;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 18px;
    color: orange;
    transition: color 0.3s;
    margin-top: 10px;
    margin-right: 10px;
    cursor: pointer;
}

.dark-mode-btn:hover {
    color: #3700b3;
    transform: scale(1.1);
}

.dark-mode-btn:active {
    transform: scale(0.95);
}

.dark-mode-btn .v-icon {
    transition: all 0.3s ease;
}
</style>
