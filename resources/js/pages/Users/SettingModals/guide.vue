<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span class="headline">{{ translate('GUIDE_GUIDEBOOKS') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p class="description">{{ translate('GUIDE_CREATEGUIDEDESCRIPTION') }}</p>
                <div class="image-container">
                    <v-img src="/icons8-guide-book-98.png" alt="Guide Image" class="guide-image"></v-img>
                </div>

                <div v-if="createdGuide" class="guide-preview">
                    <h3 class="guide-title">{{ createdGuide.title }}</h3>
                    <p class="guide-description">{{ createdGuide.description }}</p>
                    <v-btn @click="editGuide" color="primary" class="mt-4">
                        {{ translate('GUIDE_EDITGUIDE') }}
                    </v-btn>
                </div>

                <div v-else class="button-container">
                    <v-btn @click="openCreateGuideModal" color="primary" large>
                        {{ translate('GUIDE_CREATEGUIDE') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isCreateGuideModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span class="headline">{{ isEditing ? translate('GUIDE_EDITGUIDETITLE') : translate('GUIDE_CREATEGUIDETITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeCreateGuideModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p class="description">{{ translate('GUIDE_GUIDEDESCRIPTION') }}</p>
                <v-form @submit.prevent="saveGuide">
                    <v-text-field
                        v-model="guideTitle"
                        :label="translate('GUIDE_GUIDETITLELABEL')"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="guideDescription"
                        :label="translate('GUIDE_GUIDEDESCRIPTIONLABEL')"
                        required
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div v-if="imagePreview" class="image-preview">
                        <v-img :src="imagePreview" alt="Preview" class="preview-image"></v-img>
                    </div>

                    <div class="button-container">
                        <v-btn type="submit" color="primary" large>
                            {{ isEditing ? translate('GUIDE_SAVECHANGES') : translate('GUIDE_CREATEGUIDEBUTTON') }}
                        </v-btn>
                        <v-btn @click="closeCreateGuideModal" color="secondary" large class="ml-2">
                            {{ translate('CANCEL') }}
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:{title/description/image

import { translate } from '@/store/languageStore';

export default {
    name: 'Guide',

    data() {
        return {
            isModalOpen: false,
            isCreateGuideModalOpen: false,
            isEditing: false,
            guideTitle: '',
            guideDescription: '',
            guideImage: null,
            imagePreview: null,
            createdGuide: null
        };
    },

    methods: {
        translate,

        openModal() {
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
        },

        openCreateGuideModal() {
            this.isCreateGuideModalOpen = true;
        },

        closeCreateGuideModal() {
            this.isCreateGuideModalOpen = false;
            this.isEditing = false;
            this.guideTitle = '';
            this.guideDescription = '';
            this.guideImage = null;
            this.imagePreview = null;
        },

        async saveGuide() {
            try {
                const guideData = {
                    title: this.guideTitle,
                    description: this.guideDescription,
                    imageUrl: this.imagePreview
                };

                this.createdGuide = guideData;

                this.closeCreateGuideModal();
            } catch (error) {
                console.warn("Error saving help:", error);
            }
        },

        editGuide() {
            try {
                if (!this.createdGuide) return;

                this.isEditing = true;
                this.guideTitle = this.createdGuide.title;
                this.guideDescription = this.createdGuide.description;
                this.imagePreview = this.createdGuide.imageUrl;

                this.openCreateGuideModal();
            } catch (error) {
                console.warn("Error saving help:", error);
            }
        }
    }
};
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
