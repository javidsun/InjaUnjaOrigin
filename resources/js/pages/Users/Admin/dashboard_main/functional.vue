<template>
    <VCard class="main-card pa-4" outlined>
        <div class="dashboard-header">
            <p class="text-body-1 mb-0 fontsize">{{ translate('functional.todayPerformance') }}</p>
        </div>
        <div class="dashboard-cards">
            <VCard v-for="(item, index) in performanceStats" :key="index" class="stat-card d-flex text-secondary2 align-center " flat>
                <VIcon :color="item.color" size="24">{{ item.icon }}</VIcon>
                <div class="ms-3">
                    <div class="text-h6 mb-1 fontsize">{{ item.stats }}</div>
                    <div class="text-body-6 text-h6 text-secondary2  fontsize">{{ translate(item.title) }}</div>
                </div>
            </VCard>
        </div>
    </VCard>
</template>

<script>
import { translate } from "@/store/languageStore.js";

export default {
    name: 'functional',
    data() {
        return {
            performanceStats: [
                {
                    title: "functional.todayReservations",
                    stats: '35',
                    icon: 'mdi-calendar-check',
                    color: 'primary'
                },
                {
                    title: "functional.dailyRevenue",
                    stats: '1.5M',
                    icon: 'mdi-cash',
                    color: 'success'
                },
                {
                    title: "functional.newUsers",
                    stats: '45',
                    icon: 'mdi-account-plus',
                    color: 'warning'
                }
            ]
        }
    },
    methods: {
        translate,
        async fetchPerformanceData() {
            try {
                // Example API call
                // const response = await this.$api.get('/dashboard/performance');
                // this.performanceStats = response.data;
            } catch (error) {
                this.showError('Failed to load performance data');
                console.error('Error fetching performance data:', error);
            }
        },
        showError(message) {
            this.$emit('show-alert', {
                type: 'error',
                message: message,
                timeout: 5000
            });
        },
        showSuccess(message) {
            this.$emit('show-alert', {
                type: 'success',
                message: message,
                timeout: 3000
            });
        }
    },
    mounted() {
        this.fetchPerformanceData();
    }
}
</script>

<style>
@import '../../../../../css/@core/template/lib/@layouts/styles/cards.scss';

.text-body-1{
    font-size: 20px !important;
    font-family: "2  Baran",serif  !important;
    color: var(--text-card-color--groups);
    font-weight: bold;
}

.main-card {
    width: 100%;
    max-width: 800px;
    border-radius: 12px;
    box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
    height: 100%;
    background-color: var(--backgroundcards-color--groups);
}

.dashboard-header {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 16px;
    background-color: var(--backgroundcards-color--groups);
}

.dashboard-cards {
    padding-top: 20px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
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

.text-secondary2{
    color: #161626;
    font-family: "2  Baran",serif  !important;
}

.stat-card:hover {
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.stat-card .text-h6 {
    font-weight: 600;
}

.stat-card {
    color: #757575;
}
</style>
