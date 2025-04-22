<!--فایل  FeedbackModal.js در services      فایل   FeedbackModal.json در پوشه docs -->

<template>
    <v-dialog v-model="isFeedbackModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="feedback-header">
                <span class="feedback-title">{{ translate('feedback.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeFeedbackModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>

            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="feedback-content">
                <p class="description">{{ translate('feedback.description') }}</p>

                <p class="feedback-question">{{ translate('feedback.feedbackQuestion') }}</p>
                <v-divider/>

                <p class="feedback-question">{{ translate('feedback.selectFeedbackType') }}</p>


                <v-radio-group v-model="selectedFeedbackCategory">
                    <v-radio
                        v-for="(category, index) in feedbackCategories"
                        :key="index"
                        :label="t(category.label)"
                        :value="category.value"
                    ></v-radio>
                </v-radio-group>

                <v-btn @click="submitFeedback" color="primary" large class="submit-btn">
                    {{ translate('feedback.submitButton') }}
                </v-btn>

                <v-divider class="my-4"></v-divider>

                <p class="contact-title"><strong>{{ translate('feedback.contactTitle') }}</strong></p>
                <p class="contact-subtitle">{{ translate('feedback.contactSubtitle') }}</p>

                <v-btn @click="contactSupport" color="secondary" large class="contact-btn">
                    {{ translate('feedback.contactButton') }}
                </v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import {ref} from 'vue';
import {translate} from "@/store/languageStore.js";

const isFeedbackModalOpen = ref(false);

const openModal = () => {
    isFeedbackModalOpen.value = true;
};

const closeFeedbackModal = () => {
    isFeedbackModalOpen.value = false;
};

const selectedFeedbackType = ref('');
const feedbackTypes = ref([
    translate('feedback.feedbackType1'),
    translate('feedback.feedbackType2'),
    translate('feedback.feedbackType3'),
]);

const selectedFeedbackCategory = ref('');
const feedbackCategories = ref([
    {label: 'feedback.category1', value: 'Experiences'},
    {label: 'feedback.category2', value: 'Hosting'},
    {label: 'feedback.category3', value: 'Guest'},
]);

const submitFeedback = () => {
    alert(t('feedback.submitSuccess'));
};

const contactSupport = () => {
    const url = window.location.href;
    const supportDetails = t('support.contactMessage', {query: selectedFeedbackType.value});

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

defineExpose({openModal});
</script>

<style scoped>
.feedback-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.feedback-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.feedback-content {
    padding: 20px;
    text-align: center;
}

.description {
    font-size: 1rem;
    margin-bottom: 20px;
}

.feedback-question {
    font-size: 1rem;
    margin-bottom: 20px;
}

.submit-btn {
    width: 100%;
    max-width: 300px;
    margin: 20px 0;
}

.contact-title {
    font-size: 1.1rem;
    margin-top: 20px;
    margin-bottom: 10px;
    color: #1976D2;
}

.contact-subtitle {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 20px;
}

.contact-btn {
    width: 100%;
    max-width: 300px;
    margin: 10px 0;
}
</style>
