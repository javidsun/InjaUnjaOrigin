<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { t, currentLanguage } from "../store/languageStore";
import Header from './layout/Header/Header.vue';

const form = ref({
    username: '',
    email: '',
    password: '',
    privacyPolicies: false,
});
const setLanguage = (lang) => {
    t(lang);
};

const isPasswordVisible = ref(false);
const router = useRouter();

const handleRegister = () => {
    if (!form.value.username || !form.value.email || !form.value.password || !form.value.privacyPolicies) {
        alert(messages.value.register.fillAllFields);
        return;
    }
    console.log('Registering user:', form.value);
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
                        {{ t('register.greeting') }}
                    </h4>
                    <p class="font fontsize2">{{ t('register.welcome') }}</p>
                </VCardText>

                <VForm @submit.prevent="handleRegister" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="font">
                            <VTextField
                                v-model="form.username"
                                :label="t('register.username')"
                                :placeholder="t('register.usernamePlaceholder')"
                                outlined
                                dense
                            />
                        </VCol>

                        <VCol cols="12" class="form font form_Style">
                            <VTextField
                                v-model="form.email"
                                :label="t('register.email')"
                                :placeholder="t('register.emailPlaceholder')"
                                outlined
                                dense
                                type="email"
                            />
                        </VCol>

                        <VCol cols="12" class="form font form_Style">
                            <VTextField
                                v-model="form.password"
                                :label="t('register.password')"
                                :placeholder="t('register.passwordPlaceholder')"
                                outlined
                                dense
                                :type="isPasswordVisible ? 'text' : 'password'"
                                :append-inner-icon="isPasswordVisible ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                            />
                        </VCol>

                        <VCol cols="12" class="form font">
                            <div class="d-flex align-items-center">
                                <VCheckbox
                                    v-model="form.privacyPolicies"
                                    dense
                                    class="mr-2"
                                    style="vertical-align: middle;"
                                />
                                <RouterLink
                                    to="/privacy-policy"
                                    class="form2 privacy"
                                >
                                    {{ t('register.privacyPolicy') }}

                                </RouterLink>
                            </div>
                        </VCol>

                        <VCol cols="12" class="form2">
                            <VBtn block type="submit" class="font buttonfont1"  color="light-purple">
                                {{ t('register.register') }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

                <VCardText class="text-center mt-4 form2 fontsize3 font">
                    <p>
                        {{ t('register.alreadyRegistered') }}

                        <RouterLink to="login" style="color: #4cc8ff" class="fontsize3">
                            {{ t('register.login') }}

                        </RouterLink>
                    </p>
                </VCardText>

                <VCardText class="text-center">
                    <v-btn icon="mdi-google" color="red" variant="text" class="mx-2" @click="socialLogin('google')"></v-btn>
                    <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2" @click="socialLogin('facebook')"></v-btn>
                    <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2" @click="socialLogin('twitter')"></v-btn>
                    <v-btn icon="mdi-apple" color="grey-darken-3" variant="text" class="mx-2" @click="socialLogin('apple')"></v-btn>
                </VCardText>


            </VCard>
        </div>
    </v-app>
</template>
<style>
@import '../../css/@core/template/pages/page-auth.scss';

</style>
