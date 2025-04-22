<!--فایل  SecurityModal.js در services      فایل   SecurityModal.json در پوشه docs -->


<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card class="modal-container">
            <v-card-title class="header">
                <span>{{ translate('security.title') }}</span>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <div class="password-section">
                    <div class="password-label">{{ translate('security.passwordLabel') }}</div>
                    <div class="last-update">{{ translate('security.lastUpdate') }}: {{ lastPasswordUpdate }}</div>
                    <v-btn color="primary" @click="openChangePasswordDialog" class="change-btn">
                        {{ translate('security.changePassword') }}
                    </v-btn>
                </div>

                <v-divider class="my-4"></v-divider>

                <div class="account-section">
                    <div class="account-label">{{ translate('security.accountLabel') }}</div>
                    <v-btn :color="isAccountActive ? 'error' : 'success'" @click="toggleAccountStatus" class="deactivate-btn">
                        {{ isAccountActive ? translate('security.deactivateAccount') : translate('security.activateAccount') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>

        <v-dialog v-model="isChangePasswordDialogOpen" max-width="500px">
            <v-card>
                <v-card-title class="dialog-header">{{ translate('security.changePassword') }}</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="submitNewPassword">
                        <v-text-field
                            v-model="currentPassword"
                            :label="translate('security.currentPassword')"
                            :type="showCurrentPassword ? 'text' : 'password'"
                            :append-icon="showCurrentPassword ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="showCurrentPassword = !showCurrentPassword"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="newPassword"
                            :label="translate('security.newPassword')"
                            :type="showNewPassword ? 'text' : 'password'"
                            :append-icon="showNewPassword ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="showNewPassword = !showNewPassword"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="confirmNewPassword"
                            :label="translate('security.confirmNewPassword')"
                            :type="showConfirmPassword ? 'text' : 'password'"
                            :append-icon="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"
                            @click:append="showConfirmPassword = !showConfirmPassword"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" type="submit">{{ translate('security.confirm') }}</v-btn>
                            <v-btn color="error" @click="closeChangePasswordDialog">{{ translate('security.cancel') }}</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="isMessageModalOpen" max-width="400px">
            <v-card>
                <v-card-title class="message-header">{{ messageTitle }}</v-card-title>
                <v-card-text class="message-text">{{ messageContent }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="isMessageModalOpen = false">{{ translate('security.ok') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref } from 'vue';
import { translate } from "@/store/languageStore.js";

const isModalOpen = ref(false);
const isChangePasswordDialogOpen = ref(false);
const isMessageModalOpen = ref(false);
const lastPasswordUpdate = ref(translate('security.oneMonthAgo'));
const isAccountActive = ref(true);
const currentPassword = ref('');
const newPassword = ref('');
const confirmNewPassword = ref('');
const showCurrentPassword = ref(false);
const showNewPassword = ref(false);
const showConfirmPassword = ref(false);
const messageTitle = ref('');
const messageContent = ref('');

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const openChangePasswordDialog = () => {
    isChangePasswordDialogOpen.value = true;
};

const closeChangePasswordDialog = () => {
    isChangePasswordDialogOpen.value = false;
    resetPasswordFields();
};

const resetPasswordFields = () => {
    currentPassword.value = '';
    newPassword.value = '';
    confirmNewPassword.value = '';
};

const submitNewPassword = () => {
    if (newPassword.value !== confirmNewPassword.value) {
        showMessage(translate('security.error'), translate('security.passwordMismatch'));
        return;
    }
    lastPasswordUpdate.value = new Date().toLocaleString('en');
    showMessage(translate('security.success'), translate('security.passwordChanged'));
    closeChangePasswordDialog();
};

const toggleAccountStatus = () => {
    const action = isAccountActive.value ? translate('security.deactivate') : translate('security.activate');
    const confirmMessage = translate('security.confirmAccountAction').replace('{action}', action);
    if (confirm(confirmMessage)) {
        isAccountActive.value = !isAccountActive.value;
        const successMessage = translate('security.accountActionSuccess').replace('{action}', action);
        showMessage(translate('security.success'), successMessage);
    }
};

const showMessage = (title, content) => {
    messageTitle.value = title;
    messageContent.value = content;
    isMessageModalOpen.value = true;
};

defineExpose({ openModal });
</script>

<style scoped>
.modal-container {
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    font-weight: bold;
    color: white;
    background-color: #3b3b3b;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.password-section, .account-section {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.password-label, .account-label {
    font-weight: bold;
    margin-bottom: 8px;
}

.last-update {
    color: #666;
    font-size: 14px;
    margin-bottom: 12px;
}

.change-btn, .deactivate-btn {
    margin-left: auto;
}

.dialog-header {
    font-weight: bold;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.v-form {
    padding: 16px;
}

.v-text-field {
    margin-bottom: 16px;
}

.v-card-actions {
    padding: 16px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.message-header {
    font-weight: bold;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.message-text {
    padding: 16px;
    font-size: 16px;
}

@media (max-width: 600px) {
    .password-label, .account-label {
        font-size: 14px;
    }

    .last-update {
        font-size: 12px;
    }

    .change-btn, .deactivate-btn {
        font-size: 0.8rem;
    }
}
</style>
