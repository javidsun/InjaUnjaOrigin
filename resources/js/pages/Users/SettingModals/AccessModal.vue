<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ translate('ACCESS_TITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <div class="control-section">
                    <div class="control-label">{{ translate('ACCESS_ZOOMCONTROL') }}</div>
                    <v-slider v-model="zoomLevel" :min="1" :max="10" @input="updateZoom" thumb-label></v-slider>
                </div>

                <div class="hint-text">
                    {{ translate('ACCESS_ZOOMHINT') }}
                </div>

                <div class="control-section">
                    <div class="control-label">{{ translate('ACCESS_PANCONTROL') }}</div>
                    <v-slider v-model="panDirection" :min="0" :max="3" @input="updatePan" thumb-label>
                        <template v-slot:thumb-label="{ value }">
                            {{ panLabels[value] }}
                        </template>
                    </v-slider>
                </div>

                <div class="hint-text">
                    {{ translate('ACCESS_PANHINT') }}
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:{zoomLevel/panDirection

import { translate } from "@/store/languageStore";

export default {
    name: 'Access',

    data() {
        return {
            isModalOpen: false,
            zoomLevel: 5,
            panDirection: 0,
            panLabels: ['Up', 'Right', 'Down', 'Left']
        }
    },

    methods: {
        translate,

        openModal() {
            try {
                this.isModalOpen = true;
            } catch (error) {
                this.handleError('Failed to open modal', error);
            }
        },

        closeModal() {
            try {
                this.isModalOpen = false;
            } catch (error) {
                this.handleError('Failed to close modal', error);
            }
        },

        updateZoom() {
            try {
                //Todo: Send zoom level to backend
                console.log(`Zoom Level: ${this.zoomLevel}`);
            } catch (error) {
                this.handleError('Failed to update zoom', error);
            }
        },

        updatePan() {
            try {
                //Todo: Send pan direction to backend
                console.log(`Pan Direction: ${this.panLabels[this.panDirection]}`);
            } catch (error) {
                this.handleError('Failed to update pan', error);
            }
        },

        handleError(message, error) {
            console.error(message, error);
            this.$emit('error', { message, error });
        }
    },

}
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
