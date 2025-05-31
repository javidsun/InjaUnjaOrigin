<template>
    <v-dialog v-model="isSupportModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="support-header">
                <span class="support-title">{{ translate('GUIDE_SUPPORT_TITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeSupportModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="support-content">
                <p class="welcome-message">{{ translate('GUIDE_SUPPORT_WELCOMEMESSAGE') }}</p>

                <v-text-field
                    v-model="searchQuery"
                    :placeholder="translate('GUIDE_SUPPORT_SEARCHPLACEHOLDER')"
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
                    <p class="contact-title"><strong>{{ translate('GUIDE_SUPPORT_CONTACTTITLE') }}</strong></p>
                    <p class="contact-subtitle">{{ translate('GUIDE_SUPPORT_CONTACTSUBTITLE') }}</p>
                    <v-btn @click="contactSupport" color="primary" large class="contact-btn">
                        {{ translate('GUIDE_SUPPORT_CONTACTBUTTON') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isHelpModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="help-header">
                <span>{{ translate(selectedQuestion?.title) }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeHelpModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="help-content">
                <p>{{ translate(selectedQuestion?.answer) }}</p>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:questions/contact/id

import { translate } from "@/store/languageStore";

export default {
    name: "SupportModal",
    data() {
        return {
            isSupportModalOpen: false,
            isHelpModalOpen: false,
            searchQuery: '',
            selectedQuestion: null,
            supportQuestions: [
                { title: 'GUIDE_SUPPORT_CANCELGUEST', answer: 'GUIDE_SUPPORT_CANCELGUESTANSWER' },
                { title: 'GUIDE_SUPPORT_ACCOUNTSETTINGS', answer: 'GUIDE_SUPPORT_ACCOUNTSETTINGSANSWER' },
                { title: 'GUIDE_SUPPORT_REFUNDHOST', answer: 'GUIDE_SUPPORT_REFUNDHOSTANSWER' },
                { title: 'GUIDE_SUPPORT_HOSTINGGOALS', answer: 'GUIDE_SUPPORT_HOSTINGGOALSANSWER' },
                { title: 'GUIDE_SUPPORT_PREPARELISTINGS', answer: 'GUIDE_SUPPORT_PREPARELISTINGSANSWER' },
                { title: 'GUIDE_SUPPORT_PAYMENTS', answer: 'GUIDE_SUPPORT_PAYMENTSANSWER' },
                { title: 'GUIDE_SUPPORT_MANAGEEXPERIENCES', answer: 'GUIDE_SUPPORT_MANAGEEXPERIENCESANSWER' },
                { title: 'GUIDE_SUPPORT_COHOST', answer: 'GUIDE_SUPPORT_COHOSTANSWER' },
                { title: 'GUIDE_SUPPORT_BILLHELP', answer: 'GUIDE_SUPPORT_BILLHELPANSWER' },
            ]
        };
    },
    computed: {
        filteredQuestions() {
            return this.supportQuestions.filter((question) =>
                translate(question.title).toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    },
    methods: {
        translate,

        openModal() {
            this.isSupportModalOpen = true;
        },
        closeSupportModal() {
            this.isSupportModalOpen = false;
        },
        openHelpModal(question) {
            this.selectedQuestion = question;
            this.isHelpModalOpen = true;
        },
        closeHelpModal() {
            this.isHelpModalOpen = false;
        },
        contactSupport() {
            const url = window.location.href;
            const supportDetails = translate('GUIDE_SUPPORT_CONTACTMESSAGE', { query: this.searchQuery });

            if (navigator.share) {
                navigator.share({
                    title: translate('GUIDE_SUPPORT_CONTACTTITLE'),
                    text: supportDetails,
                    url: url,
                }).catch((error) => console.error("Error sharing:", error));
            } else {
                alert(translate('GUIDE_SUPPORT_CONTACTFALLBACK'));
            }
        }
    }
};
</script>

<style scoped>
.support-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
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
    padding: 20px;
}

.welcome-message {
    font-size: 1.1rem;
    margin-bottom: 20px;
}

.search-bar {
    margin-bottom: 20px;
}

.contact-section {
    margin-top: 30px;
    text-align: center;
}

.contact-title {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.contact-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 20px;
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
    padding: 16px;
}

.help-content {
    padding: 20px;
}
</style>
