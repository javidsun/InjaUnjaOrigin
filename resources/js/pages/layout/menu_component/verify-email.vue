<template>
    <v-app class="back">
        <Header/>
        <br><br><br>

        <div class="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
                <VCardText class="text-center">
                    <div class="logo-container">
                        <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image"/>
                    </div>
                    <h4 class="mb-1 font fontsiz">
                        {{ translate('VERIFYEMAIL_GREETING') }}
                    </h4>
                    <p class="font fontsize2">
                        {{ translate('VERIFYEMAIL_INSTRUCTIONS') }}
                    </p>
                </VCardText>

                <div class="mt-4"></div>
                <div class="mt-4"></div>
                <div class="mt-4"></div>

                <VForm @submit.prevent="handleResendVerification" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="form font form_Style">
                            <VTextField
                                v-model="email"
                                :label="translate('VERIFYEMAIL_EMAIL')"
                                :placeholder="translate('VERIFYEMAIL_EMAILPLACEHOLDER')"
                                outlined
                                dense
                                type="email"
                            />
                        </VCol>
                        <VCol cols="12" class="form2">
                            <VBtn block type="submit" class="font buttonfont1" color="light-purple">
                                {{ translate('VERIFYEMAIL_RESEND') }}
                            </VBtn>
                        </VCol>
                    </VRow>
                </VForm>

                <VCardText class="text-center mt-4 form2 fontsize3 font">
                    <p>
                        {{ translate('VERIFYEMAIL_SKIP') }}
                        <RouterLink to="/" style="color: #4cc8ff" class="fontsize3">
                            {{ translate('VERIFYEMAIL_GOHOME') }}
                        </RouterLink>
                    </p>
                </VCardText>
            </VCard>
        </div>
    </v-app>
</template>

<script>
import Header from '../Header/Header.vue';
import {translate} from "@/store/languageStore";

export default {
    name: 'VerifyEmail',
    components: {
        Header
    },
    data() {
        return {
            email: ''
        };
    },
    methods: {
        translate,

        async handleResendVerification() {
            if (!this.email) {
                alert(this.translate('VERIFYEMAIL_EMAILREQUIRED'));
                return;
            }

            try {
                // Todo: call your email service
                alert(this.translate('VERIFYEMAIL_RESENDSUCCESS'));
            } catch (error) {
                alert(this.translate('VERIFYEMAIL_RESENDERROR'));
            }
        }
    }
};
</script>

<style>
@import './resources/css/@core/template/pages/page-auth.scss';
</style>
