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
                    <v-btn color="primary" @click="isMessageModalOpen = false">{{ translate('OK') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    data() {
        return {
            isModalOpen: false,
            isChangePasswordDialogOpen: false,
            isMessageModalOpen: false,
            lastPasswordUpdate: this.translate('security.oneMonthAgo'),
            isAccountActive: true,
            currentPassword: '',
            newPassword: '',
            confirmNewPassword: '',
            showCurrentPassword: false,
            showNewPassword: false,
            showConfirmPassword: false,
            messageTitle: '',
            messageContent: ''
        };
    },
    methods: {
        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        openChangePasswordDialog() {
            this.isChangePasswordDialogOpen = true;
        },
        closeChangePasswordDialog() {
            this.isChangePasswordDialogOpen = false;
            this.resetPasswordFields();
        },
        resetPasswordFields() {
            this.currentPassword = '';
            this.newPassword = '';
            this.confirmNewPassword = '';
        },
        submitNewPassword() {
            if (this.newPassword !== this.confirmNewPassword) {
                this.showMessage(this.translate('security.error'), this.translate('security.passwordMismatch'));
                return;
            }
            this.lastPasswordUpdate = new Date().toLocaleString('en');
            this.showMessage(this.translate('security.success'), this.translate('security.passwordChanged'));
            this.closeChangePasswordDialog();
        },
        toggleAccountStatus() {
            const action = this.isAccountActive ? this.translate('security.deactivate') : this.translate('security.activate');
            const confirmMessage = this.translate('security.confirmAccountAction').replace('{action}', action);
            if (confirm(confirmMessage)) {
                this.isAccountActive = !this.isAccountActive;
                const successMessage = this.translate('security.accountActionSuccess').replace('{action}', action);
                this.showMessage(this.translate('security.success'), successMessage);
            }
        },
        showMessage(title, content) {
            this.messageTitle = title;
            this.messageContent = content;
            this.isMessageModalOpen = true;
        },
        translate,
    }
};
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
