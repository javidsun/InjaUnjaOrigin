<template>
    <v-row app dense class="search">
        <v-row dense class="search-bar-wrapper rounded-border">
            <v-btn class="search-btn">

                <v-icon color="blue lighten-1" size="28">
                    mdi-magnify
                </v-icon>
            </v-btn>

            <AnywhereField :activeMenu="activeMenu" @update-active-menu="updateActiveMenu" />
            <AnyweekField :activeMenu="activeMenu" @update-active-menu="updateActiveMenu" />
            <GuestsField :activeMenu="activeMenu" @update-active-menu="updateActiveMenu" />
        </v-row>
    </v-row>
</template>

<script>
import AnywhereField from "./AnywhereField.vue";
import AnyweekField from "./AnyweekField.vue";
import GuestsField from "./GuestsField.vue";

export default {
    components: {
        AnywhereField,
        AnyweekField,
        GuestsField,
    },
    data() {
        return {
            activeMenu: null,
        };
    },
    methods: {
        updateActiveMenu(menuName) {
            this.activeMenu = this.activeMenu === menuName ? null : menuName;
        },
    },
};
</script>

<style scoped>
.search-bar-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: var(--background-color);
    width: 100%;
    max-width: 800px;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    border-left: none !important;
    border-right: none !important;
    border-radius: 12px;
    padding: 6px 15px;
    gap: 6px;
    box-shadow: none !important;
    overflow: visible;
    position: relative;
    z-index: 9999;
}
.v-row {
    margin: 0 !important;
    padding: 0 !important;
}

.search {
    border: none !important;
    padding: 8px 0;
}

.search-btn, .search-bar-wrapper > * {
    border-left: none !important;
    border-right: none !important;
}

@media (max-width: 650px) {
    .search-btn {
        display: none;
    }
    .search-bar-wrapper {
        display: none;

    }

}
</style>
