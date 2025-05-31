<template>
    <v-dialog v-model="ispolicyModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="policy-header">
                <span class="policy-title">{{ translate('GUIDE_POLICY_TITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closePolicyModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="policy-content text-center">
                <div class="policy-section">
                    <h3 class="section-title">{{ translate('GUIDE_POLICY_PRIVACYPOLICYTITLE') }}</h3>
                    <p class="section-description">{{ translate('GUIDE_POLICY_PRIVACYPOLICYDESCRIPTION') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ translate('GUIDE_POLICY_SUPPLEMENTARYDOCUMENTSTITLE') }}</h3>
                    <ul class="document-list">
                        <li v-for="(document, index) in supplementaryDocuments" :key="index">
                            {{ translate(document) }}
                            <v-icon v-if="hasAlert(document)" color="warning" small class="ml-1">mdi-alert</v-icon>
                        </li>
                    </ul>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ translate('GUIDE_POLICY_RELATEDARTICLESTITLE') }}</h3>
                    <p class="section-description">{{ translate('GUIDE_POLICY_RELATEDARTICLESDESCRIPTION') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ translate('GUIDE_POLICY_HOSTSECTIONTITLE') }}</h3>
                    <p class="section-description">{{ translate('GUIDE_POLICY_HOSTSECTIONDESCRIPTION') }}</p>
                </div>
                <v-divider></v-divider>

                <div class="policy-section">
                    <h3 class="section-title">{{ translate('GUIDE_POLICY_TERMSUPDATESTITLE') }}</h3>
                    <p class="section-description">{{ translate('GUIDE_POLICY_TERMSUPDATESDESCRIPTION') }}</p>
                </div>
            </v-card-text>

            <v-card-actions>
                <v-btn color="error" @click="showConfirmation" class="mr-4">
                    <v-icon left>mdi-alert-circle</v-icon>
                    {{ translate('GUIDE_POLICY_IMPORTANT_NOTICE') }}
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="acceptPolicy">
                    {{ translate('ACCEPT') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: 'PolicyModal',
    data() {
        return {
            ispolicyModalOpen: false,
            supplementaryDocuments: [
                'policy.outsideUS',
                'policy.stateSupplements',
                'policy.cookiePolicy',
                'policy.enterpriseCustomers',
                'policy.chinaPrivacySupplement',
                'policy.colombiaOnly',
                'policy.turkeyOnly',
                'policy.dac7Notice'
            ],
            documentsWithAlerts: [
                'policy.chinaPrivacySupplement',
                'policy.dac7Notice'
            ]
        }
    },
    methods: {
        translate,
        openModal() {
            this.ispolicyModalOpen = true;
        },
        closePolicyModal() {
            this.ispolicyModalOpen = false;
        },
        hasAlert(documentKey) {
            return this.documentsWithAlerts.includes(documentKey);
        },
        showConfirmation() {
            this.$emit('show-alert', {
                title: this.translate('policy.importantNoticeTitle'),
                message: this.translate('policy.importantNoticeMessage'),
                type: 'warning'
            });
        },
        acceptPolicy() {
            this.$emit('policy-accepted');
            this.closePolicyModal();
            this.$emit('show-alert', {
                title: this.translate('policy.thankYouTitle'),
                message: this.translate('policy.thankYouMessage'),
                type: 'success'
            });
        }
    }
}
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
    text-transform: uppercase;
}

.section-description {
    color: var(--text-color);
    font-size: 0.9rem;
    margin-bottom: 10px;
    line-height: 1.6;
}

.document-list {
    list-style-type: none;
    padding: 0;
    text-align: center;
}

.document-list li {
    color: white;
    font-size: 0.9rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.v-card-actions {
    padding: 16px;
    background-color: var(--background-color);
    border-top: 1px solid #ddd;
}
</style>
