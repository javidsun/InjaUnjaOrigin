<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { t, currentLanguage } from "../../../store/languageStore";
import Header from '../Header/Header.vue';
const setLanguage = (lang) => {
    t(lang);
};


const router = useRouter();

const email = ref('');

const handleResend = () => {
  if (!email.value) {
    alert(messages.value.verifyEmail.enterEmail);
    return;
  }
  console.log('Resending verification email to:', email.value);
  // اینجا می‌توانید API ارسال ایمیل را فراخوانی کنید.
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
              {{ t('verifyEmail.greeting') }}

          </h4>
          <p class="font fontsize2">
              {{ t('verifyEmail.instructions') }}
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
                  :label="t('verifyEmail.email')"
                  :placeholder="t('verifyEmail.emailPlaceholder')"
                  outlined
                  dense
                  type="email"
              />
            </VCol>

            <VCol cols="12" class="form2 ">
              <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                  {{ t('verifyEmail.resend') }}

              </VBtn>
            </VCol>
          </VRow>
        </VForm>

        <VCardText class="text-center mt-4 form2 fontsize3 font">
          <p>
              {{ t('verifyEmail.skip') }}

            <RouterLink to="/" style="color: #4cc8ff" class="fontsize3">
                {{ t('verifyEmail.goHome') }}

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
