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

const onFinish = () => {
  isOtpInserted.value = true;
  setTimeout(() => {
    isOtpInserted.value = false;
    router.push({ name: 'home' });
  }, 2000);
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
              {{ t('twoStep.greeting') }}
          </h4>
          <p class="font fontsize2">
              {{ t('twoStep.instruction') }}

             </p>
        </VCardText>

        <div class="mt-4"></div>

        <VForm @submit.prevent="onFinish" class="form_Style">
          <VRow>
            <VCol cols="12" class="form font form_Style mt-2">
                {{ t('twoStep.enterCode') }}

              <VOtpInput
                  v-model="otp"
                  :disabled="isOtpInserted"
                  type="number"
                  class="pa-0"
                  @finish="onFinish"
              />
            </VCol>

            <VCol cols="12">
              <VBtn
                  block
                  :loading="isOtpInserted"
                  :disabled="isOtpInserted"
                  type="submit"
                  class="font buttonfont1"
                  color="light-purple"
              >
                  {{ t('twoStep.verifyAccount') }}

              </VBtn>
            </VCol>

            <VCol cols="12">
              <div class="d-flex justify-center align-center flex-wrap">
                <span class="me-1">
                    {{ t('twoStep.didntGetCode') }}
                </span>
                <a href="#">
                    {{ t('twoStep.resend') }}
                </a>
              </div>
            </VCol>
          </VRow>
        </VForm>
      </VCard>
    </div>

    </v-app>
</template>

<style scoped>
@import './resources/css/@core/template/pages/page-auth.scss';
</style>
