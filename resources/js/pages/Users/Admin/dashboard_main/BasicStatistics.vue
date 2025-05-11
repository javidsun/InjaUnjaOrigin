<template>
    <VCard class="main-card2 pa-4" outlined>
        <div class="dashboard-cards2 fontsize">
            <VCard
                v-for="(stat, index) in stats"
                :key="index"
                class="stat-card text-secondary2 d-flex align-center pa-2"
                flat
            >
                <VIcon :color="stat.color" size="24">{{ stat.icon }}</VIcon>
                <div class="ms-3">
                    <div class="text-h6 mb-1 fontsize">{{ stat.value }}</div>
                    <div class="text-secondary2 text-h6 fontsize">{{ translate(stat.title) }}</div>
                </div>
            </VCard>
        </div>
    </VCard>
</template>

<script>
//Todo:title/ value
import { translate } from "../../../../store/languageStore.js";

export default {
    name: 'BasicStatistics',
    data() {
        return {
            stats: [
                { title: "Basics.activeUsers", value: '1,200', icon: 'mdi-account', color: 'primary' },
                { title: "Basics.totalReservations", value: '350', icon: 'mdi-calendar-check', color: 'success' },
                { title: "Basics.totalRevenue", value: '750K $', icon: 'mdi-cash', color: 'warning' },
                { title: "Basics.activeAds", value: '120', icon: 'mdi-format-list-bulleted', color: 'info' },
            ]
        }
    },
    methods: {
        translate,
    }
}
</script>

<style>

@import '../../../../../css/@core/template/lib/@layouts/styles/cards.scss';

@media (max-width: 950px) {
    .fontsize {
        font-size: 12px!important;
    }
}
.main-card2 {
    height: 100%;
    width: 100%;
    max-width: 800px;
    border-radius: 12px;
    background-color: var(--backgroundcards-color--groups);
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
}

.dashboard-cards2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    background-color: var(--backgroundcards-color--groups);
}

.stat-card {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    border-radius: 8px;
    transition: box-shadow 0.3s ease;
    padding: 16px;
    background-color: var(--backgroundcards2-color--groups) !important;
}

.stat-card:hover {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.stat-card .text-h6 {
    font-weight: 900;
}

.stat-card {
    color: #161626 !important;
}

.text-secondary2 {
    color: #161626;
}
</style>
