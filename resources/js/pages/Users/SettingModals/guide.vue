<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span class="headline">{{ t('guide.guideBooks') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p class="description">
                    {{ t('guide.createGuideDescription') }}
                </p>

                <div class="image-container">
                    <v-img src="\icons8-guide-book-98.png" alt="Guide Image" class="guide-image"></v-img>
                </div>

                <div v-if="createdGuide" class="guide-preview">
                    <h3 class="guide-title">{{ createdGuide.title }}</h3>
                    <p class="guide-description">{{ createdGuide.description }}</p>
                    <v-btn @click="editGuide" color="primary" class="mt-4">
                        {{ t('guide.editGuide') }}
                    </v-btn>
                </div>

                <div v-else class="button-container">
                    <v-btn @click="openCreateGuideModal" color="primary" large>
                        {{ t('guide.createGuide') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isCreateGuideModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span class="headline">{{ isEditing ? t('guide.editGuideTitle') : t('guide.createGuideTitle') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeCreateGuideModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p class="description">
                    {{ t('guide.guideDescription') }}
                </p>

                <v-form @submit.prevent="saveGuide">
                    <v-text-field
                        v-model="guideTitle"
                        :label="t('guide.guideTitleLabel')"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="guideDescription"
                        :label="t('guide.guideDescriptionLabel')"
                        required
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div v-if="imagePreview" class="image-preview">
                        <v-img :src="imagePreview" alt="Preview" class="preview-image"></v-img>
                    </div>

                    <div class="button-container">
                        <v-btn type="submit" color="primary" large>
                            {{ isEditing ? t('guide.saveChanges') : t('guide.createGuideButton') }}
                        </v-btn>
                        <v-btn @click="closeCreateGuideModal" color="secondary" large class="ml-2">
                            {{ t('cancel') }}
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>v
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isModalOpen = ref(false);
const isCreateGuideModalOpen = ref(false);
const isEditing = ref(false);
const guideTitle = ref('');
const guideDescription = ref('');
const guideImage = ref(null);
const imagePreview = ref(null);
const createdGuide = ref(null);

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const openCreateGuideModal = () => {
    isCreateGuideModalOpen.value = true;
};

const closeCreateGuideModal = () => {
    isCreateGuideModalOpen.value = false;
    isEditing.value = false;
    guideTitle.value = '';
    guideDescription.value = '';
    guideImage.value = null;
    imagePreview.value = null;
};

const saveGuide = () => {
    const guideData = {
        title: guideTitle.value,
        description: guideDescription.value,
        imageUrl: imagePreview.value,
    };

    createdGuide.value = guideData;
    console.log('Guide saved:', guideData);

    closeCreateGuideModal();
};

const editGuide = () => {
    isEditing.value = true;
    guideTitle.value = createdGuide.value.title;
    guideDescription.value = createdGuide.value.description;
    imagePreview.value = createdGuide.value.imageUrl;
    openCreateGuideModal();
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
    font-size: 1rem;
    color: #666;
    margin-bottom: 1rem;
    text-align: center;
}

.image-container {
    display: flex;
    justify-content: center;
    margin: 1.5rem 0;
}

.guide-image {
    max-width: 20%;
    height: auto;
    border-radius: 8px;
}

.button-container {
    display: flex;
    justify-content: center;
    margin-top: 1.5rem;
}

.ml-2 {
    margin-left: 8px;
}

.guide-preview {
    text-align: center;
}

.guide-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-top: 1rem;
}

.guide-description {
    font-size: 1rem;
    color: #666;
    margin-top: 0.5rem;
}

.image-preview {
    display: flex;
    justify-content: center;
    margin: 1rem 0;
}

.preview-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}
</style>
