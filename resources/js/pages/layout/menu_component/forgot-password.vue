<template>
    <v-app className="back">
        <br><br><br>

        <div className="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
                <VCardText class="text-center">
                    <div className="logo-container">
                        <img src="/assets/images/inja-unja.png" alt="Logo" className="logo-image"/>
                    </div>
                    <h4 className="mb-1 font fontsiz">
                        {{ translate('forgotPassword.title') }}
                    </h4>
                    <p className="font fontsize2">
                        {{ translate('forgotPassword.instructions') }}
                    </p>
                </VCardText>

                <div className="mt-4"></div>
                <div className="mt-4"></div>
                <div className="mt-4"></div>

                <VForm @submit.prevent="handleForgotPassword" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="form font form_Style">
                            <VTextField
                                v-model="email"
                                :label="translate('forgotPassword.email')"
                                :placeholder="translate('forgotPassword.emailPlaceholder')"
                                outlined
                                dense
                                type="email"
                            />
                        </VCol>
                        <VCol cols="12" class="form2">
                            <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                                {{ translate('forgotPassword.sendResetLink') }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

                <VCardText class="text-center mt-4 form2 fontsize3 font">
                    <p>
                        {{ translate('forgotPassword.rememberPassword') }}
                        <RouterLink to="/login" style="color: #4cc8ff" class="fontsize3">
                            {{ translate('forgotPassword.login') }}
                        </RouterLink>
                    </p>
                </VCardText>
            </VCard>
        </div>
    </v-app>
    <v-dialog v-model="dialog" max-width="400">
        <v-card :color="dialogColor">
            <v-card-title class="headline white--text">
                {{ dialogColor === 'success' ? translate('general.success') : translate('general.error') }}
            </v-card-title>
            <v-card-text class="white--text">
                {{ dialogMessage }}
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="white" text @click="dialog = false">
                    {{ translate('general.ok') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import {translate} from "@/store/languageStore";

export default {
    name: 'ForgotPasswordView',
    components: {
        Header: () => import('../Header/Header.vue')
    },
    data() {
        return {
            email: '',
            dialog: false,
            dialogMessage: '',
            dialogColor: 'success'
        };
    },
    methods: {
        translate,
        async handleForgotPassword() {
            try {
                if (!this.email) {
                    this.showAlert(this.translate('forgotPassword.emailRequired'));
                    return;
                }

                // would be replaced with actual API call
                await this.sendResetPasswordRequest(this.email);
                this.showAlert(this.translate('forgotPassword.resetLinkSent'));

            } catch (error) {
                this.handleError(error);
            }
        },

        async sendResetPasswordRequest(email) {
            try {
                // Replace with actual API call
                console.log('Sending reset link to:', email);
            } catch (error) {
                throw new Error(this.translate('forgotPassword.errorOccurred'));
            }
        },

        showAlert(message, type) {
            this.dialogMessage = message;
            this.dialogColor = type;
            this.dialog = true;
        },

        handleError(error) {
            console.error('Error:', error.message);
            this.showAlert(error.message || this.translate('forgotPassword.errorOccurred'));
        }
    }
};
</script>

<style>
@import './resources/css/@core/template/pages/page-auth.scss';

.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.auth-card {
    background-color: var(--background-color);
    border-radius: 10px;
}

.logo-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.fontsiz {
    font-size: 24px;
}

.fontsize2 {
    font-size: 16px;
}

.fontsize3 {
    font-size: 14px;
}

.form_Style {
    margin-top: 20px;
}

.buttonfont1 {
    font-weight: bold;
}
</style>
