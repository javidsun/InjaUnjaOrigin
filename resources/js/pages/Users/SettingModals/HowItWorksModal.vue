<template>
    <v-dialog v-model="isHowItWorksModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="how-it-works-header">
                <span>{{ translate('GUIDE_HOWITWORKS_TITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeHowItWorksModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="how-it-works-content">
                <p class="description">{{ translate('GUIDE_HOWITWORKS_DESCRIPTION') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img :src="videoThumbnail" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <p class="step-title"><strong>{{ translate('GUIDE_HOWITWORKS_STEP1TITLE') }}</strong></p>
                <p class="step-description">{{ translate('GUIDE_HOWITWORKS_STEP1DESCRIPTION') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img :src="videoThumbnail" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <p class="step-title"><strong>{{ translate('GUIDE_HOWITWORKS_STEP2TITLE') }}</strong></p>
                <p class="step-description">{{ translate('GUIDE_HOWITWORKS_STEP2DESCRIPTION') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img :src="videoThumbnail" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <p class="step-title"><strong>{{ translate('GUIDE_HOWITWORKS_STEP3TITLE') }}</strong></p>
                <p class="step-description">{{ translate('GUIDE_HOWITWORKS_STEP3DESCRIPTION') }}</p>

                <v-divider></v-divider>

                <p class="support-title"><strong>{{ translate('GUIDE_HOWITWORKS_SUPPORTTITLE') }}</strong></p>
                <p class="support-description">{{ translate('GUIDE_HOWITWORKS_SUPPORTDESCRIPTION') }}</p>

                <v-expansion-panels>
                    <v-expansion-panel v-for="(faq, index) in faqs" :key="index">
                        <v-expansion-panel-header>
                            {{ translate(faq.question) }}
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            {{ translate(faq.answer) }}
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:question/answer

import { translate } from "@/store/languageStore";

export default {
    name: 'HowItWorksModal',

    data() {
        return {
            isHowItWorksModalOpen: false,
            videoThumbnail: '/injaunjalogin.mp4',
            faqs: [
                {question: 'GUIDE_HOWITWORKS_FAQ1QUESTION', answer: 'GUIDE_HOWITWORKS_FAQ1ANSWER'},
                {question: 'GUIDE_HOWITWORKS_FAQ2QUESTION', answer: 'GUIDE_HOWITWORKS_FAQ2ANSWER'},
                {question: 'GUIDE_HOWITWORKS_FAQ3QUESTION', answer: 'GUIDE_HOWITWORKS_FAQ3ANSWER'},
                {question: 'GUIDE_HOWITWORKS_FAQ4QUESTION', answer: 'GUIDE_HOWITWORKS_FAQ4ANSWER'},
                {question: 'GUIDE_HOWITWORKS_FAQ5QUESTION', answer: 'GUIDE_HOWITWORKS_FAQ5ANSWER'},
            ]
        }
    },

    methods: {
        translate,

        openModal() {
            try {
                this.isHowItWorksModalOpen = true;
            } catch (error) {
                this.handleError('Failed to open modal', error);
            }
        },

        closeHowItWorksModal() {
            try {
                this.isHowItWorksModalOpen = false;
            } catch (error) {
                this.handleError('Failed to close modal', error);
            }
        },

        handleError(message, error) {
            console.error(message, error);
        },

    }
}
</script>

<style scoped>
.how-it-works-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.how-it-works-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.how-it-works-content {
    padding: 20px;
    text-align: center;
}

.description {
    font-size: 1rem;
    margin-bottom: 20px;
}

.video-card {
    border-radius: 10px;
    margin-bottom: 20px;
    max-width: 500px;
}

.video-thumbnail {
    border-radius: 10px;
}

.step-title {
    font-size: 1.1rem;
    margin-top: 20px;
    margin-bottom: 10px;
}

.step-description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 20px;
}

.support-title {
    font-size: 1.1rem;
    margin-top: 20px;
    margin-bottom: 10px;
    color: #1976D2;
}

.support-description {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 20px;
}

.v-expansion-panels {
    margin-top: 20px;
}
</style>
