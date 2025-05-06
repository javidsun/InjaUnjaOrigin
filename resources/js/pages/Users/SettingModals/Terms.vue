<template>
    <v-dialog v-model="isTermsModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="terms-header">
                <span class="terms-title">{{ translate('terms.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeTermsModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text class="terms-content">
                <v-card class="info-card mx-auto">
                    <v-card-text>
                        <div class="info-header">
                            <v-icon class="info-icon">mdi-book</v-icon>
                            <span class="info-title">{{ translate('terms.infoTitle') }}</span>
                        </div>
                        <p class="info-description">{{ translate('terms.infoDescriptionEEA') }}</p>
                        <p class="info-description">{{ translate('terms.infoDescriptionNonEEA') }}</p>
                        <p class="info-description">{{ translate('terms.infoDescriptionAustralia') }}</p>
                    </v-card-text>
                </v-card>

                <p class="section-title">{{ translate('terms.sectionTitle') }}</p>
                <p class="section-description">{{ translate('terms.sectionDescription') }}</p>
                <p class="section-update">{{ translate('terms.sectionUpdate') }}</p>

                <p class="thank-you">{{ translate('terms.thankYou') }}</p>
                <p class="terms-text">{{ translate('terms.termsText') }}</p>
                <p class="table-of-contents">{{ translate('terms.tableOfContents') }}</p>

                <v-list>
                    <v-list-item v-for="(item, index) in termsList" :key="index">
                        <v-list-item-content>
                            <v-list-item-title>{{ translate(item) }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: "TermsModal",

    data() {
        return {
            isTermsModalOpen: false,
            termsList: [
                'terms.guestConditions1',
                'terms.guestConditions2',
                'terms.guestConditions3',
                'terms.hostConditions1',
                'terms.hostConditions2',
                'terms.hostConditions3',
                'terms.hostConditions4',
                'terms.generalConditions1',
                'terms.generalConditions2',
                'terms.generalConditions3',
                'terms.generalConditions4',
                'terms.generalConditions5',
                'terms.generalConditions6',
                'terms.generalConditions7',
                'terms.generalConditions8',
                'terms.generalConditions9',
                'terms.generalConditions10',
                'terms.generalConditions11',
                'terms.generalConditions12',
                'terms.generalConditions13',
                'terms.generalConditions14',
                'terms.generalConditions15',
                'terms.generalConditions16',
            ]
        };
    },

    methods: {
        translate,

        openModal() {
            this.isTermsModalOpen = true;
        },
        closeTermsModal() {
            this.isTermsModalOpen = false;
        },
    }
};
</script>

<style scoped>
.terms-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.terms-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.terms-content {
    padding: 20px;
    text-align: center;
}

.info-card {
    border-radius: 10px;
    margin-bottom: 20px;
    max-width: 600px;
}

.info-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.info-icon {
    margin-right: 10px;
}

.info-title {
    font-size: 1.1rem;
    font-weight: bold;
    color: #007bff;
}

.info-description {
    font-size: 0.9rem;
    color: #ffffff;
    margin-bottom: 10px;
}

.section-title {
    font-size: 1.1rem;
    margin-top: 20px;
    margin-bottom: 10px;
    font-weight: bold;
    color: #007bff;
}

.section-description {
    font-size: 0.9rem;
    color: #ffffff;
    margin-bottom: 10px;
}

.section-update {
    font-size: 0.8rem;
    color: #999;
    margin-bottom: 20px;
}

.thank-you {
    font-size: 1rem;
    margin-top: 20px;
    margin-bottom: 10px;
    font-weight: bold;
    color: #4CAF50;
}

.terms-text {
    font-size: 0.9rem;
    color: #ffffff;
    margin-bottom: 20px;
}

.table-of-contents {
    font-size: 1.1rem;
    margin-top: 20px;
    margin-bottom: 10px;
    font-weight: bold;
    color: #007bff;
}

.v-list {
    margin-top: 10px;
}

.v-list-item-title {
    font-size: 0.9rem;
    color: #ffffff;
}
</style>
