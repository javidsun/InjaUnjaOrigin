<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { messages } from "../../../store/languageStore";

const form = ref({
  email: '',
});
const router = useRouter();

const handleForgotPassword = () => {
  if (!form.value.email) {
    alert(messages.value.forgotPassword.fillAllFields);
    return;
  }
  console.log('Sending reset link to:', form.value.email);

  alert(messages.value.forgotPassword.resetLinkSent);
};

const goToHome = () => {
  router.push('/');
};
</script>

<template>
  <div class="layout-blank">
    <div class="home-button-container">
      <v-btn icon class="home-button" @click="goToHome"><v-icon >mdi-home</v-icon></v-btn>

    </div>

    <div class="auth-wrapper d-flex align-center justify-center pa-4">
      <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
        <VCardText class="text-center">
          <div class="logo-container form">
              <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" />
          </div>
          <h4 class="mb-1 font fontsize">
            {{ messages.forgotPassword.greeting }}
          </h4>
          <p class="font fontsize2">
            {{ messages.forgotPassword.instruction }}
          </p>
        </VCardText>

        <VForm @submit.prevent="handleForgotPassword" class="form_Style">
          <VRow>
            <VCol cols="12" class="form font form_Style mt-2">
              <VTextField
                  v-model="form.email"
                  :label="messages.forgotPassword.email"
                  :placeholder="messages.forgotPassword.emailPlaceholder"
                  outlined
                  dense
                  type="email"
              />
            </VCol>

            <VCol cols="12" class="form2">
              <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                {{ messages.forgotPassword.sendResetLink }}
              </VBtn>
            </VCol>
          </VRow>
        </VForm>

        <VCardText class="text-center mt-4 form2 fontsize3 font">
          <RouterLink to="/login" style="color: #4cc8ff" class="fontsize3">
            {{ messages.forgotPassword.backToLogin }}
          </RouterLink>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>
