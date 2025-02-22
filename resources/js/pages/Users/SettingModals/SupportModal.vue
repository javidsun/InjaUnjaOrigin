<template>
    <v-dialog v-model="isSupportModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="support-header">
                <span class="support-title">{{ t('support.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeSupportModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="support-content">
                <p class="welcome-message">{{ t('support.welcomeMessage') }}</p>

                <v-text-field
                    v-model="searchQuery"
                    :placeholder="t('support.searchPlaceholder')"
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
                            <v-list-item-title>{{ t(question.title) }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <div class="contact-section">
                    <p class="contact-title"><strong>{{ t('support.contactTitle') }}</strong></p>
                    <p class="contact-subtitle">{{ t('support.contactSubtitle') }}</p>
                    <v-btn @click="contactSupport" color="primary" large class="contact-btn">
                        {{ t('support.contactButton') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isHelpModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="help-header">
                <span>{{ t(selectedQuestion?.title) }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeHelpModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="help-content">
                <p>{{ t(selectedQuestion?.answer) }}</p>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref, computed } from 'vue';
import { t } from "../../../store/languageStore";

const isSupportModalOpen = ref(false);

const openModal = () => {
    isSupportModalOpen.value = true;
};

const closeSupportModal = () => {
    isSupportModalOpen.value = false;
};

const isHelpModalOpen = ref(false);
const searchQuery = ref('');
const selectedQuestion = ref(null);

const supportQuestions = ref([
    { title: 'support.cancelGuest', answer: 'support.cancelGuestAnswer' },
    { title: 'support.accountSettings', answer: 'support.accountSettingsAnswer' },
    { title: 'support.refundHost', answer: 'support.refundHostAnswer' },
    { title: 'support.hostingGoals', answer: 'support.hostingGoalsAnswer' },
    { title: 'support.prepareListings', answer: 'support.prepareListingsAnswer' },
    { title: 'support.payments', answer: 'support.paymentsAnswer' },
    { title: 'support.manageExperiences', answer: 'support.manageExperiencesAnswer' },
    { title: 'support.coHost', answer: 'support.coHostAnswer' },
    { title: 'support.billHelp', answer: 'support.billHelpAnswer' },
]);

const filteredQuestions = computed(() => {
    return supportQuestions.value.filter(question =>
        t(question.title).toLowerCase().includes(searchQuery.value.toLowerCase())
    );
});

const openHelpModal = (question) => {
    selectedQuestion.value = question;
    isHelpModalOpen.value = true;
};

const closeHelpModal = () => {
    isHelpModalOpen.value = false;
};

const contactSupport = () => {
    const url = window.location.href;
    const supportDetails = t('support.contactMessage', { query: searchQuery.value });

    if (navigator.share) {
        navigator.share({
            title: t('support.contactTitle'),
            text: supportDetails,
            url: url,
        }).catch((error) => console.error("Error sharing:", error));
    } else {
        alert(t('support.contactFallback'));
    }
};

defineExpose({ openModal });
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
