<template>
    <v-dialog v-model="isHowItWorksModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <v-card-title class="how-it-works-header">
                <v-btn icon @click="closeHowItWorksModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <span class="how-it-works-title">{{ translate('howItWorks.title') }}</span>
                <v-spacer></v-spacer>
            </v-card-title>

            <v-divider></v-divider>

            <v-card-text class="how-it-works-content">
                <p class="description">{{ translate('howItWorks.description') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail" />
                </v-card>

                <p class="step-title"><strong>{{ translate('howItWorks.step1Title') }}</strong></p>
                <p class="step-description">{{ translate('howItWorks.step1Description') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail" />
                </v-card>

                <p class="step-title"><strong>{{ translate('howItWorks.step2Title') }}</strong></p>
                <p class="step-description">{{ translate('howItWorks.step2Description') }}</p>

                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail" />
                </v-card>

                <p class="step-title"><strong>{{ translate('howItWorks.step3Title') }}</strong></p>
                <p class="step-description">{{ translate('howItWorks.step3Description') }}</p>

                <v-divider></v-divider>

                <p class="support-title"><strong>{{ translate('howItWorks.supportTitle') }}</strong></p>
                <p class="support-description">{{ translate('howItWorks.supportDescription') }}</p>

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
import { translate } from '@/store/languageStore';

export default {
    name: 'Report',
    data() {
        return {
            isHowItWorksModalOpen: false,
            faqs: [
                { question: 'howItWorks.faq1Question', answer: 'howItWorks.faq1Answer' },
                { question: 'howItWorks.faq2Question', answer: 'howItWorks.faq2Answer' },
                { question: 'howItWorks.faq3Question', answer: 'howItWorks.faq3Answer' },
                { question: 'howItWorks.faq4Question', answer: 'howItWorks.faq4Answer' },
                { question: 'howItWorks.faq5Question', answer: 'howItWorks.faq5Answer' },
            ],
        };
    },
    methods: {
        translate,
        openModal() {
            try {
                this.isHowItWorksModalOpen = true;
            } catch (err) {
                this.showError('There was a problem opening the modal.');
            }
        },

        closeHowItWorksModal() {
            try {
                this.isHowItWorksModalOpen = false;
            } catch (err) {
                this.showError('There was a problem closing the modal.');
            }
        },

        showError(message) {
            alert(`⚠️ ${message}`);
        },


    },
};
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

