<template>
    <v-dialog v-model="isModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ translate('privacySharing.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="modal-content">
                <p class="description">{{ translate('privacySharing.description') }}</p>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ translate('privacySharing.requestData.title') }}</h3>
                    <p>{{ translate('privacySharing.requestData.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="downloadUserData" color="primary">
                            {{ translate('privacySharing.requestData.button') }}
                        </v-btn>
                    </div>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ translate('privacySharing.deleteAccount.title') }}</h3>
                    <p>{{ translate('privacySharing.deleteAccount.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showDeleteConfirmation" color="error">
                            {{ translate('privacySharing.deleteAccount.button') }}
                        </v-btn>
                    </div>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ translate('privacySharing.thirdPartyTools.title') }}</h3>
                    <p>{{ translate('privacySharing.thirdPartyTools.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showThirdPartyTools = true" color="primary">
                            {{ translate('privacySharing.thirdPartyTools.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showThirdPartyTools" class="nested-section">
                            <p>{{ translate('privacySharing.thirdPartyTools.nestedDescription') }}</p>
                            <v-checkbox v-model="thirdPartySharing"
                                        :label="translate('privacySharing.thirdPartyTools.sharingLabel')"></v-checkbox>
                            <v-checkbox v-model="thirdPartyAnalytics"
                                        :label="translate('privacySharing.thirdPartyTools.analyticsLabel')"></v-checkbox>
                            <v-checkbox v-model="thirdPartyMarketing"
                                        :label="translate('privacySharing.thirdPartyTools.marketingLabel')"></v-checkbox>
                            <div class="button-container">
                                <v-btn @click="saveThirdPartySettings" color="primary">
                                    {{ translate('privacySharing.thirdPartyTools.saveButton') }}
                                </v-btn>
                                <v-btn @click="showThirdPartyTools = false" color="secondary">
                                    {{ translate('privacySharing.thirdPartyTools.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ translate('privacySharing.sharing.title') }}</h3>
                    <p>{{ translate('privacySharing.sharing.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showSharing = true" color="primary">
                            {{ translate('privacySharing.sharing.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showSharing" class="nested-section">
                            <p>{{ translate('privacySharing.sharing.nestedDescription') }}</p>
                            <v-radio-group v-model="profileVisibility">
                                <v-radio value="public"
                                         :label="translate('privacySharing.sharing.publicLabel')"></v-radio>
                                <v-radio value="private"
                                         :label="translate('privacySharing.sharing.privateLabel')"></v-radio>
                                <v-radio value="custom"
                                         :label="translate('privacySharing.sharing.customLabel')"></v-radio>
                            </v-radio-group>
                            <div class="button-container">
                                <v-btn @click="saveSharingSettings" color="primary">
                                    {{ translate('privacySharing.sharing.saveButton') }}
                                </v-btn>
                                <v-btn @click="showSharing = false" color="secondary">
                                    {{ translate('privacySharing.sharing.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ translate('privacySharing.services.title') }}</h3>
                    <p>{{ translate('privacySharing.services.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showServices = true" color="primary">
                            {{ translate('privacySharing.services.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showServices" class="nested-section">
                            <p>{{ translate('privacySharing.services.nestedDescription') }}</p>
                            <v-list>
                                <v-list-item v-for="service in connectedServices" :key="service.id">
                                    <v-list-item-content>
                                        <v-list-item-title>{{ service.name }}</v-list-item-title>
                                        <v-list-item-subtitle>{{ service.description }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-switch
                                            v-model="service.connected"
                                            color="primary"
                                            @change="toggleServiceConnection(service.id)"
                                        ></v-switch>
                                    </v-list-item-action>
                                </v-list-item>
                            </v-list>
                            <div class="button-container">
                                <v-btn @click="showServices = false" color="secondary">
                                    {{ translate('privacySharing.services.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showDeleteAlert" max-width="500px">
        <v-card>
            <v-card-title class="error white--text">
                <v-icon large color="white">mdi-alert-circle</v-icon>
                <span class="ml-2">{{ translate('alerts.deleteAccount.title') }}</span>
            </v-card-title>
            <v-card-text class="pa-4">
                <p>{{ translate('alerts.deleteAccount.message') }}</p>
                <p class="font-weight-bold mt-3">{{ translate('alerts.deleteAccount.warning') }}</p>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="secondary" @click="showDeleteAlert = false">
                    {{ translate('alerts.cancel') }}
                </v-btn>
                <v-btn color="error" @click="confirmDeleteAccount">
                    {{ translate('alerts.deleteAccount.confirm') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="showSuccessAlert" color="success" timeout="3000" top right>
        <v-icon left>mdi-check-circle</v-icon>
        {{ successMessage }}
    </v-snackbar>

    <v-snackbar v-model="showErrorAlert" color="error" timeout="3000" top right>
        <v-icon left>mdi-alert-circle</v-icon>
        {{ errorMessage }}
    </v-snackbar>
</template>

<script>
//Todo:getUserData:description/response
//Todo:deleteAccount:description/response
//Todo:thirdPartySettings:description/body:sharing/analytics/marketing
//Todo:profileVisibility:description/body:visibility
//Todo:connectedServices:description/response:id/name/description/connected
//Todo:alerts:description/successMessages:settingsSaved/serviceUpdated/downloadStarted/accountDeleted
//Todo:errorMessages:default/deleteAccount

import { translate } from "@/store/languageStore";

export default {
    name: 'PrivacySharingModal',
    data() {
        return {
            isModalOpen: false,
            showThirdPartyTools: false,
            showSharing: false,
            showServices: false,
            thirdPartySharing: false,
            thirdPartyAnalytics: false,
            thirdPartyMarketing: false,
            profileVisibility: "public",
            connectedServices: [
                {id: 1, name: "Google", description: "Connect to the account Google", connected: true},
                {id: 2, name: "Facebook", description: "Connect to the account Facebook", connected: true},
                {id: 3, name: "Twitter", description: "Connect to the account Twitter", connected: true},
            ],
            showDeleteAlert: false,
            showSuccessAlert: false,
            showErrorAlert: false,
            successMessage: '',
            errorMessage: ''
        }
    },
    methods: {
        translate,

        toggleServiceConnection(serviceId) {
            var service = this.connectedServices.find(function(s) { return s.id === serviceId; });
            if (service) {
                service.connected = !service.connected;
                console.log("Connection status " + service.name + ": " + (service.connected ? 'ON' : 'OFF'));
                this.showAlert('success', this.translate('alerts.serviceUpdated'));
            }
        },
        saveThirdPartySettings() {
            console.log("Third-party tool settings saved:", {
                sharing: this.thirdPartySharing,
                analytics: this.thirdPartyAnalytics,
                marketing: this.thirdPartyMarketing,
            });
            this.showThirdPartyTools = false;
            this.showAlert('success', this.translate('alerts.settingsSaved'));
        },
        saveSharingSettings() {
            console.log("Sharing settings saved:", this.profileVisibility);
            this.showSharing = false;
            this.showAlert('success', this.translate('alerts.settingsSaved'));
        },
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        downloadUserData() {
            var link = document.createElement('a');
            link.href = '/UserProfile.pdf';
            link.download = 'UserProfile.pdf';
            link.click();
            this.showAlert('success', this.translate('alerts.downloadStarted'));
        },
        showDeleteConfirmation() {
            this.showDeleteAlert = true;
        },
        confirmDeleteAccount() {
            this.showDeleteAlert = false;
            console.log("Account deleted.");
            this.showAlert('success', this.translate('alerts.accountDeleted'));
            this.closeModal();
        },
        showAlert(type, message) {
            if (type === 'success') {
                this.successMessage = message;
                this.showSuccessAlert = true;
            } else {
                this.errorMessage = message;
                this.showErrorAlert = true;
            }
        },
    }
}
</script>

<style scoped>
.dialog-header {
    display: flex;
    align-items: center;
    font-size: 1.5rem;
    font-weight: bold;
    padding: 16px;
}

.close-btn {
    margin-left: auto;
}

.description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
}

.modal-content {
    padding: 16px;
}

.description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
}

.section {
    margin: 1.5rem 0;
}

.section h3 {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.section p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 1rem;
}

.nested-section {
    margin-top: 1rem;
    padding: 1rem;
    background-color: #38383a;
    border-radius: 4px;
}

.button-container {
    display: flex;
    justify-content: flex-end;
}
</style>
