<!--فایل  verify-email.json در پوشه docs -->

<template>
    <v-app class="back">
        <Header />
        <br>
        <br>
        <br>

        <div class="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
                <VCardText class="text-center">
                    <div class="logo-container form">
                        <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" />
                    </div>
                    <h4 class="mb-1 font fontsize">
                        {{ translate('verifyEmail.greeting') }}
                    </h4>
                    <p class="font fontsize2">
                        {{ translate('verifyEmail.instructions') }}
                    </p>
                </VCardText>
                <div class="mt-4"></div>
                <div class="mt-4"></div>
                <div class="mt-4"></div>

                <VForm @submit.prevent="handleResend" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="form font form_Style">
                            <VTextField
                                v-model="email"
                                :label="translate('verifyEmail.email')"
                                :placeholder="translate('verifyEmail.emailPlaceholder')"
                                outlined
                                dense
                                type="email"
                            />
                        </VCol>

                        <VCol cols="12" class="form2 ">
                            <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                                {{ translate('verifyEmail.resend') }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

                <VCardText class="text-center mt-4 form2 fontsize3 font">
                    <p>
                        {{ translate('verifyEmail.skip') }}
                        <RouterLink to="/" style="color: #4cc8ff" class="fontsize3">
                            {{ translate('verifyEmail.goHome') }}
                        </RouterLink>
                    </p>
                </VCardText>
            </VCard>
        </div>
    </v-app>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { translate } from "../../../store/languageStore";
import Header from '../Header/Header.vue';
import { resendVerificationEmail } from '../../../services/general/authService.js';

const router = useRouter();

const email = ref('');

const handleResend = async () => {
    if (!email.value) {
        alert('Please enter your email.');
        return;
    }
    try {
        await resendVerificationEmail(email.value);
        alert('Confirmation email has been resent.');
    } catch (error) {
        alert('Error sending confirmation email.');
    }
};

const goToHome = () => {
    router.push('/');
};
</script>

<style>
@import './resources/css/@core/template/pages/page-auth.scss';
</style>
