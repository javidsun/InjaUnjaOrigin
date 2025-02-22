<template>
    <v-dialog v-model="isModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ t('privacySharing.title') }}</span>
                <v-spacer></v-spacer> <!-- اینجا فضای بین عنوان و دکمه بستن را ایجاد می‌کند -->
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-card-text class="modal-content">
                <p class="description">{{ t('privacySharing.description') }}</p>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ t('privacySharing.requestData.title') }}</h3>
                    <p>{{ t('privacySharing.requestData.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="downloadUserData" color="primary">
                            {{ t('privacySharing.requestData.button') }}
                        </v-btn>
                    </div>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ t('privacySharing.deleteAccount.title') }}</h3>
                    <p>{{ t('privacySharing.deleteAccount.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="deleteAccount" color="error">
                            {{ t('privacySharing.deleteAccount.button') }}
                        </v-btn>
                    </div>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ t('privacySharing.thirdPartyTools.title') }}</h3>
                    <p>{{ t('privacySharing.thirdPartyTools.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showThirdPartyTools = true" color="primary">
                            {{ t('privacySharing.thirdPartyTools.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showThirdPartyTools" class="nested-section">
                            <p>{{ t('privacySharing.thirdPartyTools.nestedDescription') }}</p>
                            <v-checkbox v-model="thirdPartySharing" :label="t('privacySharing.thirdPartyTools.sharingLabel')"></v-checkbox>
                            <v-checkbox v-model="thirdPartyAnalytics" :label="t('privacySharing.thirdPartyTools.analyticsLabel')"></v-checkbox>
                            <v-checkbox v-model="thirdPartyMarketing" :label="t('privacySharing.thirdPartyTools.marketingLabel')"></v-checkbox>
                            <div class="button-container">
                                <v-btn @click="saveThirdPartySettings" color="primary">
                                    {{ t('privacySharing.thirdPartyTools.saveButton') }}
                                </v-btn>
                                <v-btn @click="showThirdPartyTools = false" color="secondary">
                                    {{ t('privacySharing.thirdPartyTools.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ t('privacySharing.sharing.title') }}</h3>
                    <p>{{ t('privacySharing.sharing.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showSharing = true" color="primary">
                            {{ t('privacySharing.sharing.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showSharing" class="nested-section">
                            <p>{{ t('privacySharing.sharing.nestedDescription') }}</p>
                            <v-radio-group v-model="profileVisibility">
                                <v-radio value="public" :label="t('privacySharing.sharing.publicLabel')"></v-radio>
                                <v-radio value="private" :label="t('privacySharing.sharing.privateLabel')"></v-radio>
                                <v-radio value="custom" :label="t('privacySharing.sharing.customLabel')"></v-radio>
                            </v-radio-group>
                            <div class="button-container">
                                <v-btn @click="saveSharingSettings" color="primary">
                                    {{ t('privacySharing.sharing.saveButton') }}
                                </v-btn>
                                <v-btn @click="showSharing = false" color="secondary">
                                    {{ t('privacySharing.sharing.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
                <v-divider></v-divider>

                <div class="section">
                    <h3>{{ t('privacySharing.services.title') }}</h3>
                    <p>{{ t('privacySharing.services.description') }}</p>
                    <div class="button-container">
                        <v-btn @click="showServices = true" color="primary">
                            {{ t('privacySharing.services.button') }}
                        </v-btn>
                    </div>

                    <v-expand-transition>
                        <div v-if="showServices" class="nested-section">
                            <p>{{ t('privacySharing.services.nestedDescription') }}</p>
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
                                    {{ t('privacySharing.services.closeButton') }}
                                </v-btn>
                            </div>
                        </div>
                    </v-expand-transition>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>


<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isModalOpen = ref(false);
const showThirdPartyTools = ref(false);
const showSharing = ref(false);
const showServices = ref(false);
const thirdPartySharing = ref(false);
const thirdPartyAnalytics = ref(false);
const thirdPartyMarketing = ref(false);
const profileVisibility = ref("public");

const connectedServices = ref([
    { id: 1, name: "Google", description: "Connect to the account Google", connected: true },
    { id: 2, name: "Facebook", description: "Connect to the account Facebook", connected: true },
    { id: 3, name: "Twitter", description: "Connect to the account Twitter", connected: true },
]);

const toggleServiceConnection = (serviceId) => {
    const service = connectedServices.value.find(s => s.id === serviceId);
    if (service) {
        service.connected = !service.connected;
        console.log(`Connection status ${service.name}: ${service.connected ? 'ON' : 'OFF'}`);
    }
};

const saveThirdPartySettings = () => {
    console.log("تنظیمات ابزارهای شخص ثالث ذخیره شد:", {
        sharing: thirdPartySharing.value,
        analytics: thirdPartyAnalytics.value,
        marketing: thirdPartyMarketing.value,
    });
};

const saveSharingSettings = () => {
    console.log("تنظیمات اشتراک‌گذاری ذخیره شد:", profileVisibility.value);
};

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const downloadUserData = () => {
    const link = document.createElement('a');
    link.href = '/path/to/UserProfile.pdf';
    link.download = 'UserProfile.pdf';
    link.click();
};

const deleteAccount = () => {
    if (confirm("Are you sure you want to delete your account?")) {
        console.log("حساب کاربری حذف شد.");
    }
};

defineExpose({ openModal });
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
