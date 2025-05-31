<template>
    <v-dialog v-model="isTermsModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="terms-header">
                <span class="terms-title">{{ translate('GUIDE_TERMS_TITLE') }}</span>
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
                            <span class="info-title">{{ translate('GUIDE_TERMS_INFOTITLE') }}</span>
                        </div>
                        <p class="info-description">{{ translate('GUIDE_TERMS_INFODESCRIPTIONEEA') }}</p>
                        <p class="info-description">{{ translate('GUIDE_TERMS_INFODESCRIPTIONNONEEA') }}</p>
                        <p class="info-description">{{ translate('GUIDE_TERMS_INFODESCRIPTIONAUSTRALIA') }}</p>
                    </v-card-text>
                </v-card>

                <p class="section-title">{{ translate('GUIDE_TERMS_SECTIONTITLE') }}</p>
                <p class="section-description">{{ translate('GUIDE_TERMS_SECTIONDESCRIPTION') }}</p>
                <p class="section-update">{{ translate('GUIDE_TERMS_SECTIONUPDATE') }}</p>

                <p class="thank-you">{{ translate('GUIDE_TERMS_THANKYOU') }}</p>
                <p class="terms-text">{{ translate('GUIDE_TERMS_TERMSTEXT') }}</p>
                <p class="table-of-contents">{{ translate('TABLE_OF_CONTENTS') }}</p>

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
                'GUIDE_TERMS_GUESTCONDITIONS1',
                'GUIDE_TERMS_GUESTCONDITIONS2',
                'GUIDE_TERMS_GUESTCONDITIONS3',
                'GUIDE_TERMS_HOSTCONDITIONS1',
                'GUIDE_TERMS_HOSTCONDITIONS2',
                'GUIDE_TERMS_HOSTCONDITIONS3',
                'GUIDE_TERMS_HOSTCONDITIONS4',
                'GUIDE_TERMS_GENERALCONDITIONS1',
                'GUIDE_TERMS_GENERALCONDITIONS2',
                'GUIDE_TERMS_GENERALCONDITIONS3',
                'GUIDE_TERMS_GENERALCONDITIONS4',
                'GUIDE_TERMS_GENERALCONDITIONS5',
                'GUIDE_TERMS_GENERALCONDITIONS6',
                'GUIDE_TERMS_GENERALCONDITIONS7',
                'GUIDE_TERMS_GENERALCONDITIONS8',
                'GUIDE_TERMS_GENERALCONDITIONS9',
                'GUIDE_TERMS_GENERALCONDITIONS10',
                'GUIDE_TERMS_GENERALCONDITIONS11',
                'GUIDE_TERMS_GENERALCONDITIONS12',
                'GUIDE_TERMS_GENERALCONDITIONS13',
                'GUIDE_TERMS_GENERALCONDITIONS14',
                'GUIDE_TERMS_GENERALCONDITIONS15',
                'GUIDE_TERMS_GENERALCONDITIONS16',
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
