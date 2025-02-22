<template>
    <v-dialog v-model="isModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ t('notifications.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text class="modal-content">
                <v-tabs v-model="tab" grow>
                    <v-tab value="offers">{{ t('notifications.offers') }}</v-tab>
                    <v-tab value="account">{{ t('notifications.account') }}</v-tab>
                </v-tabs>

                <v-window v-model="tab">
                    <v-window-item value="offers">
                        <div class="tab-content">
                            <div class="section">
                                <h3>{{ t('notifications.hostInsights') }}</h3>
                                <p>{{ t('notifications.hostInsightsDesc') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.recognition') }}</h4>
                                        <p>{{ notifications.recognition ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.recognition" color="primary"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.insights') }}</h4>
                                        <p>{{ notifications.insights ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.insights" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.pricing') }}</h4>
                                        <p>{{ notifications.pricing ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.pricing" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.hosting') }}</h4>
                                        <p>{{ notifications.hosting ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.hosting" color="primary"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ t('notifications.hostUpdates') }}</h3>
                                <p>{{ t('notifications.hostUpdatesDesc') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.news') }}</h4>
                                        <p>{{ notifications.news ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.news" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.regulations') }}</h4>
                                        <p>{{ notifications.regulations ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.regulations" color="primary"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ t('notifications.travelTips') }}</h3>
                                <p>{{ t('notifications.travelTipsDesc') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.inspiration') }}</h4>
                                        <p>{{ notifications.inspiration ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.inspiration" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.tripPlanning') }}</h4>
                                        <p>{{ notifications.tripPlanning ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.tripPlanning" color="primary"></v-switch>
                                </div>
                            </div>
                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ t('notifications.injaonjaUpdates') }}</h3>
                                <p>{{ t('notifications.injaonjaUpdatesDesc') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.injaonjaNews') }}</h4>
                                        <p>{{ notifications.injaonjaNews ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.injaonjaNews" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.feedback') }}</h4>
                                        <p>{{ notifications.feedback ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.feedback" color="primary"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.tripRegulations') }}</h4>
                                        <p>{{ notifications.tripRegulations ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.tripRegulations" color="primary"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ t('notifications.unsubscribe') }}</h3>
                                <p>{{ t('notifications.unsubscribeDesc') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.allOffers') }}</h4>
                                        <p>{{ notifications.allOffers ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.allOffers" color="primary"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ t('notifications.accountActivity') }}</h4>
                                        <p>{{ notifications.accountActivity ? 'On: Email and Push' : 'Off' }}</p>
                                    </div>
                                    <v-switch v-model="notifications.accountActivity" color="primary"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <p>{{ t('notifications.smsConsent') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-window-item>

                    <v-window-item value="account">
                        <div class="tab-content">
                            <div class="section">
                                <h3>{{ t('notifications.activityList') }}</h3>
                                <p>{{ t('notifications.remindersDesc') }}</p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ t('notifications.activityList') }}</h4>
                                    <p>{{ notifications.activityList ? 'On: Email and Push' : 'Off' }}</p>
                                </div>
                                <v-switch v-model="notifications.activityList" color="primary"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ t('notifications.guestPolicies') }}</h4>
                                    <p>{{ notifications.guestPolicies ? 'On: Email and Push' : 'Off' }}</p>
                                </div>
                                <v-switch v-model="notifications.guestPolicies" color="primary"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ t('notifications.hostPolicies') }}</h4>
                                    <p>{{ notifications.hostPolicies ? 'On: Email and Push' : 'Off' }}</p>
                                </div>
                                <v-switch v-model="notifications.hostPolicies" color="primary"></v-switch>
                            </div>
                        </div>

                        <v-divider></v-divider>

                        <div class="section">
                            <h3>{{ t('notifications.reminders') }}</h3>
                            <p>{{ t('notifications.remindersDesc') }}</p>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ t('notifications.reminders') }}</h4>
                                    <p>{{ notifications.reminders ? 'On: Email and Push' : 'Off' }}</p>
                                </div>
                                <v-switch v-model="notifications.reminders" color="primary"></v-switch>
                            </div>
                        </div>

                        <v-divider></v-divider>

                        <div class="section">
                            <h3>{{ t('notifications.messages') }}</h3>
                            <p>{{ t('notifications.messagesDesc') }}</p>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ t('notifications.messages') }}</h4>
                                    <p>{{ notifications.messages ? 'On: Email and Push' : 'Off' }}</p>
                                </div>
                                <v-switch v-model="notifications.messages" color="primary"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <p>{{ t('notifications.smsConsent') }}</p>
                                </div>
                            </div>
                        </div>
                    </v-window-item>
                </v-window>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isModalOpen = ref(false);
const tab = ref('offers');

const notifications = ref({
    recognition: true,
    insights: true,
    pricing: true,
    hosting: true,
    news: true,
    regulations: true,
    inspiration: true,
    tripPlanning: true,
    injaonjaNews: true,
    feedback: true,
    tripRegulations: true,
    allOffers: true,
    accountActivity: true,
    activityList: true,
    guestPolicies: true,
    hostPolicies: true,
    reminders: true,
    messages: true,
});

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

defineExpose({ openModal });
</script>

<style scoped>
.dialog-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.modal-content {
    padding: 16px;
    font-size: 1rem;
    color: #adadb0;
}

.tab-content {
    padding: 16px;
}

.section {
    margin-bottom: 20px;
}

.toggle-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.v-card-actions {
    padding: 16px;
}
</style>
