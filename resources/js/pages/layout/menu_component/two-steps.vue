<template>
    <v-app className="background">
        <Header/>
        <br><br><br>

        <div className="auth-wrapper d-flex align-center justify-center pa-4">
            <VCard class="auth-card pa-6 purple-background" style="max-width: 400px;">
                <VCardText class="text-center">
                    <div className="logo-container form">
                        <img src="/assets/images/inja-unja.png" alt="Logo" className="logo-image"/>
                    </div>
                    <h4 className="mb-1 font fontsize">
                        {{ translate('twoStep.greeting') }}
                    </h4>
                    <p className="font fontsize2">
                        {{ translate('twoStep.instruction') }}
                    </p>
                </VCardText>

                <div className="mt-4"></div>

                <VForm @submit.prevent="onFinish" class="form_Style">
                    <VRow>
                        <VCol cols="12" class="form font form_Style mt-2">
                            {{ translate('twoStep.enterCode') }}

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
                                {{ translate('twoStep.verifyAccount') }}
                            </VBtn>
                        </VCol>

                        <VCol cols="12">
                            <div className="d-flex justify-center align-center flex-wrap">
                                <span className="me-1">
                                    {{ translate('twoStep.didntGetCode') }}
                                </span>
                                <a href="#">
                                    {{ translate('twoStep.resend') }}
                                </a>
                            </div>
                        </VCol>
                    </VRow>
                </VForm>
            </VCard>
        </div>
    </v-app>
</template>

<script>
import Header from '../Header/Header.vue';
import { translate } from "@/store/languageStore";

//Process the OTP code entered by the user and redirect to the home page after verification.
//This method is called when the verification button is clicked or the OTP code is auto-completed (6-digit input completion).


export
 default {
    components: {
        Header
    },
    data() {
        return {
            otp: '',
            isOtpInserted: false
        };
    },
    methods: {
        translate,

        onFinish() {
            try {
                this.isOtpInserted = true;
                setTimeout(() => {
                    this.isOtpInserted = false;
                    this.$router.push({name: 'home'});
                }, 2000);
            } catch (error) {
                this.isOtpInserted = false;
                //Todo: Handle error
            }
        },
    }
};
</script>

<style scoped>
.background{
    background-color: var(--background-color);
}
</style>
