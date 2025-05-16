<template>
    <UserSidebar>
        <v-card>
            <v-card-text class="support-content">
                <p class="welcome-message">{{ translate('support.welcomeMessage') }}</p>

                <v-text-field
                    v-model="searchQuery"
                    :placeholder="translate('support.searchPlaceholder')"
                    outlined
                    dense
                    class="search-bar"
                ></v-text-field>

                <v-list>
                    <v-list-item
                        v-for="(question, index) in filteredQuestions"
                        :key="index"
                        @click="openHelpModal(question)"
                    >
                        <v-list-item-content>
                            <v-list-item-title>{{ translate(question.title) }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <div class="contact-section">
                    <p class="contact-title"><strong>{{ translate('support.contactTitle') }}</strong></p>
                    <p class="contact-subtitle">{{ translate('support.contactSubtitle') }}</p>
                    <v-btn @click="contactSupport" color="primary" large class="contact-btn">
                        {{ translate('support.contactButton') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>

        <v-dialog v-model="isHelpModalOpen" max-width="600px" transition="dialog-transition">
            <v-card>
                <v-card-title class="help-header">
                    <span>{{ translate(selectedQuestion?.title) }}</span>
                    <v-spacer></v-spacer>
                    <v-btn icon @click="closeHelpModal" class="close-btn">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>

                <v-card-text class="help-content">
                    <p>{{ translate(selectedQuestion?.answer) }}</p>
                </v-card-text>
            </v-card>
        </v-dialog>
    </UserSidebar>
</template>

<script>
import { translate } from "@/store/languageStore";
import UserSidebar from './Layout.vue';

export default {
    components: {
        UserSidebar
    },
    data() {
        return {

            isHelpModalOpen: false,
            searchQuery: '',
            selectedQuestion: null,
            supportQuestions: [
                {title: 'support.cancelGuest', answer: 'support.cancelGuestAnswer'},
                {title: 'support.accountSettings', answer: 'support.accountSettingsAnswer'},
                {title: 'support.refundHost', answer: 'support.refundHostAnswer'},
                {title: 'support.hostingGoals', answer: 'support.hostingGoalsAnswer'},
                {title: 'support.prepareListings', answer: 'support.prepareListingsAnswer'},
                {title: 'support.payments', answer: 'support.paymentsAnswer'},
                {title: 'support.manageExperiences', answer: 'support.manageExperiencesAnswer'},
                {title: 'support.coHost', answer: 'support.coHostAnswer'},
                {title: 'support.billHelp', answer: 'support.billHelpAnswer'},
            ],
        };
    },
    computed: {
        filteredQuestions() {
            return this.supportQuestions.filter(question =>
                this.translate(question.title).toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    methods: {
        openHelpModal(question) {
            this.selectedQuestion = question;
            this.isHelpModalOpen = true;
        },
        closeHelpModal() {
            this.isHelpModalOpen = false;
        },
        contactSupport() {
            const url = window.location.href;
            const supportDetails = this.translate('support.contactMessage', { query: this.searchQuery });

            if (navigator.share) {
                navigator.share({
                    title: this.translate('support.contactTitle'),
                    text: supportDetails,
                    url: url,
                }).catch((error) => console.error("Error sharing:", error));
            } else {
                alert(this.translate('support.contactFallback'));
            }
        },
        translate,
    }
};
</script>

<style scoped>
.support-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 10px;
}

.support-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.support-content {
    padding: 10px;
}

.welcome-message {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.search-bar {
    margin-bottom: 5px;
}

.contact-section {
    margin-top: 30px;
    text-align: center;
    margin-bottom: 150px;
}

.contact-title {
    font-size: 1.1rem;
    margin-bottom: 5px;
}

.contact-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 5px;
}

.contact-btn {
    width: 100%;
    max-width: 200px;
}

.help-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 10px;
}

.help-content {
    padding: 10px;
}
</style>
