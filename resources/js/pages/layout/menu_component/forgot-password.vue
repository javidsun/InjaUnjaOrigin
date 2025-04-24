<template>
    <div class="layout-blank">
        <div class="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">

                <VForm @submit.prevent="handleForgotPassword" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="form font form_Style mt-2">
                            <VTextField
                                v-model="form.email"
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

            </VCard>
        </div>
    </div>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { translate } from "@/store/languageStore.js";

const form = ref({
    email: '',
});
const router = useRouter();

const handleForgotPassword = () => {
    if (!form.value.email) {
        alert(translate.value.forgotPassword.fillAllFields);
        return;
    }
    console.log('Sending reset link to:', form.value.email);
    alert(translate.value.forgotPassword.resetLinkSent);
};

const goToHome = () => {
    router.push('/');
};
</script>

<style scoped>
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

.home-button-container {
    position: absolute;
    top: 20px;
    left: 20px;
}

.logo-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.fontsize {
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
