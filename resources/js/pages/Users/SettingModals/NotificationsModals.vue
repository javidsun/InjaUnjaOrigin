<template>
    <v-dialog v-model="isModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

                <span>{{ translate('NOTIFICATIONS_TITLE') }}</span>
                <v-spacer></v-spacer>
            </v-card-title>

            <v-card-text class="modal-content">
                <v-tabs v-model="tab" grow>
                    <v-tab value="offers">{{ translate('NOTIFICATIONS_OFFERS') }}</v-tab>
                    <v-tab value="account">{{ translate('NOTIFICATIONS_ACCOUNT') }}</v-tab>
                </v-tabs>

                <v-window v-model="tab">
                    <v-window-item value="offers">
                        <div class="tab-content">
                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_HOSTINSIGHTS') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_HOSTINSIGHTSDESC') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_RECOGNITION') }}</h4>
                                        <p :class="{'text-success': notifications.recognition, 'text-error': !notifications.recognition}">
                                            {{ notifications.recognition ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.recognition" color="primary" @change="showAlert('recognition')"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_INSIGHTS') }}</h4>
                                        <p :class="{'text-success': notifications.insights, 'text-error': !notifications.insights}">
                                            {{ notifications.insights ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.insights" color="primary" @change="showAlert('insights')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_PRICING') }}</h4>
                                        <p :class="{'text-success': notifications.pricing, 'text-error': !notifications.pricing}">
                                            {{ notifications.pricing ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.pricing" color="primary" @change="showAlert('pricing')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_HOSTING') }}</h4>
                                        <p :class="{'text-success': notifications.hosting, 'text-error': !notifications.hosting}">
                                            {{ notifications.hosting ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.hosting" color="primary" @change="showAlert('hosting')"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_HOSTUPDATES') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_HOSTUPDATESDESC') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_NEWS') }}</h4>
                                        <p :class="{'text-success': notifications.news, 'text-error': !notifications.news}">
                                            {{ notifications.news ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.news" color="primary" @change="showAlert('news')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_REGULATIONS') }}</h4>
                                        <p :class="{'text-success': notifications.regulations, 'text-error': !notifications.regulations}">
                                            {{ notifications.regulations ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.regulations" color="primary" @change="showAlert('regulations')"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_TRAVELTIPS') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_TRAVELTIPSDESC') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_INSPIRATION') }}</h4>
                                        <p :class="{'text-success': notifications.inspiration, 'text-error': !notifications.inspiration}">
                                            {{ notifications.inspiration ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.inspiration" color="primary" @change="showAlert('inspiration')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_TRIPPLANNING') }}</h4>
                                        <p :class="{'text-success': notifications.tripPlanning, 'text-error': !notifications.tripPlanning}">
                                            {{ notifications.tripPlanning ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.tripPlanning" color="primary" @change="showAlert('tripPlanning')"></v-switch>
                                </div>
                            </div>
                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_INJAONJAUPDATES') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_INJAONJAUPDATESDESC') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_INJAONJANEWS') }}</h4>
                                        <p :class="{'text-success': notifications.injaonjaNews, 'text-error': !notifications.injaonjaNews}">
                                            {{ notifications.injaonjaNews ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.injaonjaNews" color="primary" @change="showAlert('injaonjaNews')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_FEEDBACK') }}</h4>
                                        <p :class="{'text-success': notifications.feedback, 'text-error': !notifications.feedback}">
                                            {{ notifications.feedback ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.feedback" color="primary" @change="showAlert('feedback')"></v-switch>
                                </div>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_TRIPREGULATIONS') }}</h4>
                                        <p :class="{'text-success': notifications.tripRegulations, 'text-error': !notifications.tripRegulations}">
                                            {{ notifications.tripRegulations ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.tripRegulations" color="primary" @change="showAlert('tripRegulations')"></v-switch>
                                </div>
                            </div>

                            <v-divider></v-divider>

                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_UNSUBSCRIBE') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_UNSUBSCRIBEDESC') }}</p>
                            </div>

                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_ALLOFFERS') }}</h4>
                                        <p :class="{'text-success': notifications.allOffers, 'text-error': !notifications.allOffers}">
                                            {{ notifications.allOffers ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.allOffers" color="primary" @change="showAlert('allOffers')"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <h4>{{ translate('NOTIFICATIONS_ACCOUNTACTIVITY') }}</h4>
                                        <p :class="{'text-success': notifications.accountActivity, 'text-error': !notifications.accountActivity}">
                                            {{ notifications.accountActivity ? 'On: Email and Push' : 'Off' }}
                                        </p>
                                    </div>
                                    <v-switch v-model="notifications.accountActivity" color="primary" @change="showAlert('accountActivity')"></v-switch>
                                </div>
                            </div>
                            <div class="section">
                                <div class="toggle-item">
                                    <div>
                                        <p>{{ translate('NOTIFICATIONS_SMSCONSENT') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </v-window-item>

                    <v-window-item value="account">
                        <div class="tab-content">
                            <div class="section">
                                <h3>{{ translate('NOTIFICATIONS_ACTIVITYLIST') }}</h3>
                                <p>{{ translate('NOTIFICATIONS_REMINDERSDESC') }}</p>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ translate('NOTIFICATIONS_ACTIVITYLIST') }}</h4>
                                    <p :class="{'text-success': notifications.activityList, 'text-error': !notifications.activityList}">
                                        {{ notifications.activityList ? 'On: Email and Push' : 'Off' }}
                                    </p>
                                </div>
                                <v-switch v-model="notifications.activityList" color="primary" @change="showAlert('activityList')"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ translate('NOTIFICATIONS_GUESTPOLICIES') }}</h4>
                                    <p :class="{'text-success': notifications.guestPolicies, 'text-error': !notifications.guestPolicies}">
                                        {{ notifications.guestPolicies ? 'On: Email and Push' : 'Off' }}
                                    </p>
                                </div>
                                <v-switch v-model="notifications.guestPolicies" color="primary" @change="showAlert('guestPolicies')"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ translate('NOTIFICATIONS_HOSTPOLICIES') }}</h4>
                                    <p :class="{'text-success': notifications.hostPolicies, 'text-error': !notifications.hostPolicies}">
                                        {{ notifications.hostPolicies ? 'On: Email and Push' : 'Off' }}
                                    </p>
                                </div>
                                <v-switch v-model="notifications.hostPolicies" color="primary" @change="showAlert('hostPolicies')"></v-switch>
                            </div>
                        </div>

                        <v-divider></v-divider>

                        <div class="section">
                            <h3>{{ translate('NOTIFICATIONS_REMINDERS') }}</h3>
                            <p>{{ translate('NOTIFICATIONS_REMINDERSDESC') }}</p>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ translate('NOTIFICATIONS_REMINDERS') }}</h4>
                                    <p :class="{'text-success': notifications.reminders, 'text-error': !notifications.reminders}">
                                        {{ notifications.reminders ? 'On: Email and Push' : 'Off' }}
                                    </p>
                                </div>
                                <v-switch v-model="notifications.reminders" color="primary" @change="showAlert('reminders')"></v-switch>
                            </div>
                        </div>

                        <v-divider></v-divider>

                        <div class="section">
                            <h3>{{ translate('NOTIFICATIONS_MESSAGES') }}</h3>
                            <p>{{ translate('NOTIFICATIONS_MESSAGESDESC') }}</p>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <h4>{{ translate('NOTIFICATIONS_MESSAGES') }}</h4>
                                    <p :class="{'text-success': notifications.messages, 'text-error': !notifications.messages}">
                                        {{ notifications.messages ? 'On: Email and Push' : 'Off' }}
                                    </p>
                                </div>
                                <v-switch v-model="notifications.messages" color="primary" @change="showAlert('messages')"></v-switch>
                            </div>
                        </div>

                        <div class="section">
                            <div class="toggle-item">
                                <div>
                                    <p>{{ translate('NOTIFICATIONS_SMSCONSENT') }}</p>
                                </div>
                            </div>
                        </div>
                    </v-window-item>
                </v-window>
            </v-card-text>

            <v-snackbar v-model="alert.show" :color="alert.color" timeout="2000" top>
                {{ alert.message }}
            </v-snackbar>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: 'NotificationsModal',
    data() {
        return {
            isModalOpen: false,
            tab: 'offers',
            alert: {
                show: false,
                message: '',
                color: 'success'
            },
            notifications: {
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
            }
        }
    },
    methods: {
        translate,

        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
            this.$emit('settings-changed', this.getNotificationSettings());
        },
        showAlert(settingName) {
            const settingState = this.notifications[settingName] ? 'activated' : 'deactivated';
            this.alert = {
                show: true,
                message: `${this.translate(`notifications.${settingName}`)} notifications ${settingState}`,
                color: this.notifications[settingName] ? 'success' : 'error'
            };
        },
        getNotificationSettings() {
            return {
                notification_settings: {
                    offers: {
                        host_insights: {
                            recognition: this.notifications.recognition,
                            insights: this.notifications.insights,
                            pricing: this.notifications.pricing,
                            hosting: this.notifications.hosting
                        },
                        host_updates: {
                            news: this.notifications.news,
                            regulations: this.notifications.regulations
                        },
                        travel_tips: {
                            inspiration: this.notifications.inspiration,
                            trip_planning: this.notifications.tripPlanning
                        },
                        injaonja_updates: {
                            news: this.notifications.injaonjaNews,
                            feedback: this.notifications.feedback,
                            trip_regulations: this.notifications.tripRegulations
                        },
                        unsubscribe: {
                            all_offers: this.notifications.allOffers,
                            account_activity: this.notifications.accountActivity
                        }
                    },
                    account: {
                        activity_list: this.notifications.activityList,
                        guest_policies: this.notifications.guestPolicies,
                        host_policies: this.notifications.hostPolicies,
                        reminders: this.notifications.reminders,
                        messages: this.notifications.messages
                    }
                }
            };
        },
    }
}
</script>

<style scoped>
.text-success {
    color: #4CAF50;
}
.text-error {
    color: #F44336;
}
.dialog-header {
    background-color: var(--background-color);
    padding: 16px;
}
.close-btn {
    margin-right: -8px;
}
.modal-content {
    padding: 20px;
}
.section {
    margin-bottom: 20px;
}
.toggle-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
}
.tab-content {
    padding: 10px;
}
</style>
