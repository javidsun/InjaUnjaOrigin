<template>
    <v-app class="background">
        <Header />
        <br> <br> <br>

        <div class="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
                <VCardText class="text-center">
                    <div class="logo-container form">
                        <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" />
                    </div>
                    <h4 class="mb-1 font fontsize">
                        {{ translate('RESETPASSWORD_GREETING') }}
                    </h4>
                    <p class="font fontsize2">
                        {{ translate('RESETPASSWORD_INSTRUCTIONS') }}
                    </p>
                </VCardText>

                <VForm @submit.prevent="handleResetPassword" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="font">
                            <VTextField
                                v-model="form.newPassword"
                                :label="translate('RESETPASSWORD_NEWPASSWORD')"
                                :placeholder="translate('RESETPASSWORD_NEWPASSWORDPLACEHOLDER')"
                                outlined
                                dense
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="isPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="togglePasswordVisibility"
                            />
                        </VCol>

                        <VCol cols="12" class="font">
                            <VTextField
                                v-model="form.confirmPassword"
                                :label="translate('RESETPASSWORD_CONFIRMPASSWORD')"
                                :placeholder="translate('RESETPASSWORD_CONFIRMPASSWORDPLACEHOLDER')"
                                outlined
                                dense
                                :type="isConfirmPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="isConfirmPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="toggleConfirmPasswordVisibility"
                            />
                        </VCol>

                        <VCol cols="12" class="form2 mt-0">
                            <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                                {{ translate('RESETPASSWORD_RESET') }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

                <VCardText class="text-center mt-4 form2 fontsize3 font">
                    <p>
                        {{ translate('RESETPASSWORD_BACKTOLOGIN') }}
                        <RouterLink to="/Login" style="color: #4cc8ff" class="fontsize3">
                            {{ translate('RESETPASSWORD_LOGINNOW') }}
                        </RouterLink>
                    </p>
                </VCardText>
            </VCard>
        </div>
    </v-app>
</template>

<script>
import Header from '../Header/Header.vue';
import { translate } from "@/store/languageStore";

export default {
    name: 'ResetPassword',
    components: {
        Header
    },
    data() {
        return {
            form: {
                newPassword: '',
                confirmPassword: ''
            },
            isPasswordVisible: false,
            isConfirmPasswordVisible: false,
            messages: {
                resetPassword: {
                    fillAllFields: 'Please fill all fields',
                    passwordMismatch: 'Passwords do not match'
                }
            }
        };
    },
    methods: {
        translate,
        async handleResetPassword() {
            try {
                if (!this.form.newPassword || !this.form.confirmPassword) {
                    alert(this.messages.resetPassword.fillAllFields);
                    return;
                }
                if (this.form.newPassword !== this.form.confirmPassword) {
                    alert(this.messages.resetPassword.passwordMismatch);
                    return;
                }
                //TODO: After successful backend response, redirect to login

                await this.$router.push({ name: 'login' });
            } catch (error) {
                this.showErrorNotification('Failed to reset password. Please try again.');
            }
        },

        showErrorNotification(message) {
            alert(message);
        },

        togglePasswordVisibility() {
            this.isPasswordVisible = !this.isPasswordVisible;
        },

        toggleConfirmPasswordVisibility() {
            this.isConfirmPasswordVisible = !this.isConfirmPasswordVisible;
        },


    }
};
</script>
<style scoped>
.background{
    background-color: var(--background-color);
}
</style>

//TODO:for backend:
{
"newPassword",
"confirmPassword": " must match newPassword",
"token": " reset token received in email"
}
