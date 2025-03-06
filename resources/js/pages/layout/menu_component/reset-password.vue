<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { t, currentLanguage } from "../../../store/languageStore";
import Header from '../Header/Header.vue';
const setLanguage = (lang) => {
    t(lang);
};

const otp = ref('');
const isOtpInserted = ref(false);
const router = useRouter();

const form = ref({
  newPassword: '',
  confirmPassword: '',
});

const isPasswordVisible = ref(false);
const isConfirmPasswordVisible = ref(false);

const handleResetPassword = () => {
  if (!form.value.newPassword || !form.value.confirmPassword) {
    alert(messages.value.resetPassword.fillAllFields);
    return;
  }
  if (form.value.newPassword !== form.value.confirmPassword) {
    alert(messages.value.resetPassword.passwordMismatch);
    return;
  }
  console.log('Resetting password for user:', form.value);
  router.push({ name: 'login' });
};

const goToHome = () => {
  router.push('/');
};
</script>

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
              {{ t('resetPassword.greeting') }}

          </h4>
          <p class="font fontsize2">
              {{ t('resetPassword.instructions') }}

          </p>
        </VCardText>

        <VForm @submit.prevent="handleResetPassword" class="form_Style">
          <VRow>
            <VCol cols="12" class="font">
              <VTextField
                  v-model="form.newPassword"
                  :label="t('resetPassword.newPassword')"
                  :placeholder="t('resetPassword.newPasswordPlaceholder')"
                  outlined
                  dense
                  :type="isPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
              />
            </VCol>

            <VCol cols="12" class="font">
              <VTextField
                  v-model="form.confirmPassword"
                  :label="t('resetPassword.confirmPassword')"
                  :placeholder="t('resetPassword.confirmPasswordPlaceholder')"
                  outlined
                  dense
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
              />
            </VCol>

            <VCol cols="12" class="form2 mt-0">
              <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                  {{ t('resetPassword.reset') }}
              </VBtn>
            </VCol>
          </VRow>
        </VForm>

        <VCardText class="text-center mt-4 form2 fontsize3 font">
          <p>
              {{ t('resetPassword.backToLogin') }}

            <RouterLink to="/login" style="color: #4cc8ff" class="fontsize3">
                {{ t('resetPassword.loginNow') }}
            </RouterLink>
          </p>
        </VCardText>
      </VCard>
    </div>
    </v-app>
</template>

<style>
@import './resources/css/@core/template/pages/page-auth.scss';
</style>
