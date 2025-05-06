<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="dialog-header">
                <span>{{ translate('currency.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text class="modal-content">
                <p>{{ translate('currency.message') }}</p>
            </v-card-text>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="closeModal">
                    {{ translate('currency.closeButton') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:title/ description

import { translate } from "@/store/languageStore";

export default {
    name: 'CurrencyDialog',
    data() {
        return {
            isModalOpen: false
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

        handleError(message, error) {
            console.error(message, error);
        }
    }
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

.modal-content {
    padding: 16px;
    font-size: 1rem;
    color: #adadb0;
}

.v-card-actions {
    padding: 16px;
}
</style>
