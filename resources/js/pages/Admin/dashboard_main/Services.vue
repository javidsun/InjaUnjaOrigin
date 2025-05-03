
<template>
    <VContainer>
        <VRow>
            <VCol
                v-for="(card, index) in cards"
                :key="index"
                cols="12"
                md="3"
            >
                <VCard class="custom-card fontsize" @click="goToPage(card.route)">
                    <VCardTitle class="text-h6 text-center fontsize">
                        {{ translate(card.title) }}
                    </VCardTitle>
                    <VCardText class="text-center">
                        <h3 class="text-h4 fontsize">{{ card.count }}</h3>
                        <VProgressLinear color="primary" :value="100" height="10" rounded-bar />
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
    </VContainer>
</template>

<script>
//Todo:title/count/route/active

import { translate } from "@/store/languageStore";

export default {
    name: 'ServiceCardsDashboard',
    data() {
        return {
            cards: [
                {
                    title: "Services.house",
                    count: 45,
                    route: "/AdsHouse",
                },
                {
                    title: "Services.car",
                    count: 12,
                    route: null,
                },
                {
                    title: "Services.event",
                    count: 7,
                    route: null,
                },
                {
                    title: "Services.travel",
                    count: 20,
                    route: "/AdsTraveler",
                }
            ]
        }
    },
    methods: {
        translate,
        goToPage(route) {
            try {
                if (route) {
                    window.location.href = route;
                } else {
                    this.showComingSoonMessage();
                }
            } catch (error) {
                this.handleNavigationError(error);
            }
        },


        showComingSoonMessage() {
            try {
                this.$root.$emit('show-info-message', {
                    title: this.translate('Messages.comingSoon'),
                    text: this.translate('Messages.featureInDevelopment'),
                    timeout: 3000
                });
            } catch (error) {
                console.error('Error showing coming soon message:', error);
                // Fallback to basic alert if Vuetify alert fails
                alert(this.translate('Messages.featureInDevelopment'));
            }
        },


        handleNavigationError(error) {
            try {
                this.$root.$emit('show-error-message', {
                    title: this.translate('Messages.navigationError'),
                    text: this.translate('Messages.navigationFailed'),
                    timeout: 5000
                });
            } catch (alertError) {
                console.error('Error handling navigation error:', alertError);
                alert(this.translate('Messages.navigationFailed'));
            }
        },

    }
}
</script>
<style scoped>
@import '../../../../css/@core/template/lib/@layouts/styles/cards.scss';

@media (max-width: 950px) {
    .fontsize {
        font-size: 18px !important;
    }
}

.custom-card {
    background-color: var(--backgroundcards3-color--groups) !important;
    border: 1px solid #d1d9e6;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    color: black;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.custom-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.text-center {
    text-align: center;
    font-family: "2 Baran", serif !important;
}

.v-progress-linear {
    margin-top: 10px;
    width: 100%;
}

.v-card-actions {
    margin-top: 10px;
}
</style>
