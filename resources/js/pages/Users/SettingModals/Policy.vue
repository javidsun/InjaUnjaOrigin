<template>
    <v-dialog v-model="ispolicyModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="policy-header">
                <span class="policy-title">{{ t('policy.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closePolicyModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="policy-content text-center">
                <div class="policy-section">
                    <h3 class="section-title">{{ t('policy.privacyPolicyTitle') }}</h3>
                    <p class="section-description">{{ t('policy.privacyPolicyDescription') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ t('policy.supplementaryDocumentsTitle') }}</h3>
                    <ul class="document-list">
                        <li>{{ t('policy.outsideUS') }}</li>
                        <li>{{ t('policy.stateSupplements') }}</li>
                        <li>{{ t('policy.cookiePolicy') }}</li>
                        <li>{{ t('policy.enterpriseCustomers') }}</li>
                        <li>{{ t('policy.chinaPrivacySupplement') }}</li>
                        <li>{{ t('policy.colombiaOnly') }}</li>
                        <li>{{ t('policy.turkeyOnly') }}</li>
                        <li>{{ t('policy.dac7Notice') }}</li>
                    </ul>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ t('policy.relatedArticlesTitle') }}</h3>
                    <p class="section-description">{{ t('policy.relatedArticlesDescription') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ t('policy.hostSectionTitle') }}</h3>
                    <p class="section-description">{{ t('policy.hostSectionDescription') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ t('policy.termsUpdatesTitle') }}</h3>
                    <p class="section-description">{{ t('policy.termsUpdatesDescription') }}</p>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const ispolicyModalOpen = ref(false);

const openModal = () => {
    ispolicyModalOpen.value = true;
};

const closePolicyModal = () => {
    ispolicyModalOpen.value = false;
};

defineExpose({ openModal });
</script>

<style scoped>
.policy-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.policy-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.policy-content {
    padding: 20px;
    text-align: center;
}

.policy-section {
    margin-bottom: 20px;
}

.section-title {
    color: #2196F3;
    font-size: 1.1rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.section-description {
    color: white;
    font-size: 0.9rem;
    margin-bottom: 10px;
}

.document-list {
    list-style-type: none;
    padding: 0;
    text-align: center;
}

.document-list li {
    color: white;
    font-size: 0.9rem;
    margin-bottom: 5px;
}
</style>
