<template>
    <v-dialog v-model="isHowItWorksModalOpen" max-width="800px" transition="dialog-transition">
        <v-card>
            <!-- هدر مودال -->
            <v-card-title class="how-it-works-header">
                <v-btn icon @click="closeHowItWorksModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
                <span class="how-it-works-title">{{ t('howItWorks.title') }}</span>
                <v-spacer></v-spacer>
            </v-card-title>
            <v-divider></v-divider>

            <!-- محتوای مودال -->
            <v-card-text class="how-it-works-content">
                <!-- پیام توضیحی -->
                <p class="description">{{ t('howItWorks.description') }}</p>

                <!-- ویدیوی آموزشی ۱ -->
                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <!-- مرحله ۱: جستجو -->
                <p class="step-title"><strong>{{ t('howItWorks.step1Title') }}</strong></p>
                <p class="step-description">{{ t('howItWorks.step1Description') }}</p>

                <!-- ویدیوی آموزشی ۲ -->
                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <!-- مرحله ۲: رزرو -->
                <p class="step-title"><strong>{{ t('howItWorks.step2Title') }}</strong></p>
                <p class="step-description">{{ t('howItWorks.step2Description') }}</p>

                <!-- ویدیوی آموزشی ۳ -->
                <v-card class="video-card mx-auto">
                    <v-img src="/injaunjalogin.mp4" alt="Video Thumbnail" class="video-thumbnail"></v-img>
                </v-card>

                <!-- مرحله ۳: رفتن -->
                <p class="step-title"><strong>{{ t('howItWorks.step3Title') }}</strong></p>
                <p class="step-description">{{ t('howItWorks.step3Description') }}</p>

                <v-divider></v-divider>

                <!-- بخش پشتیبانی -->
                <p class="support-title"><strong>{{ t('howItWorks.supportTitle') }}</strong></p>
                <p class="support-description">{{ t('howItWorks.supportDescription') }}</p>

                <!-- سوالات متداول -->
                <v-expansion-panels>
                    <v-expansion-panel v-for="(faq, index) in faqs" :key="index">
                        <v-expansion-panel-header>
                            {{ t(faq.question) }}
                        </v-expansion-panel-header>
                        <v-expansion-panel-content>
                            {{ t(faq.answer) }}
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isHowItWorksModalOpen = ref(false);

const openModal = () => {
    isHowItWorksModalOpen.value = true;
};

const closeHowItWorksModal = () => {
    isHowItWorksModalOpen.value = false;
};

const faqs = ref([
    { question: 'howItWorks.faq1Question', answer: 'howItWorks.faq1Answer' },
    { question: 'howItWorks.faq2Question', answer: 'howItWorks.faq2Answer' },
    { question: 'howItWorks.faq3Question', answer: 'howItWorks.faq3Answer' },
    { question: 'howItWorks.faq4Question', answer: 'howItWorks.faq4Answer' },
    { question: 'howItWorks.faq5Question', answer: 'howItWorks.faq5Answer' },
]);

defineExpose({ openModal });
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
    color: #1976D2; /* رنگ آبی */
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
