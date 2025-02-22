<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ t('access.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <div class="control-section">
                    <div class="control-label">{{ t('access.zoomControl') }}</div>
                    <v-slider v-model="zoomLevel" :min="1" :max="10" @input="updateZoom" thumb-label></v-slider>
                </div>

                <div class="hint-text">
                    {{ t('access.zoomHint') }}
                </div>

                <div class="control-section">
                    <div class="control-label">{{ t('access.panControl') }}</div>
                    <v-slider v-model="panDirection" :min="0" :max="3" @input="updatePan" thumb-label>
                        <template v-slot:thumb-label="{ value }">
                            {{ panLabels[value] }}
                        </template>
                    </v-slider>
                </div>

                <div class="hint-text">
                    {{ t('access.panHint') }}
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { t } from "../../../store/languageStore";
import { Inertia } from "@inertiajs/inertia";

const isModalOpen = ref(false);
const router = useRouter();

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const goToPage = (link) => {
    Inertia.visit(link);
};

const zoomLevel = ref(5);
const panDirection = ref(0);

const updateZoom = () => {
    console.log(`Zoom Level: ${zoomLevel.value}`);
};

const panLabels = ['Up', 'Right', 'Down', 'Left'];

const updatePan = () => {
    console.log(`Pan Direction: ${panLabels[panDirection.value]}`);
};

defineExpose({ openModal });
</script>

<style scoped>
.dialog-header {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.control-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}

.control-label {
    font-weight: bold;
}

.hint-text {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 16px;
}

.v-slider {
    width: 100%;
}
</style>
