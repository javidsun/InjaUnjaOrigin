<template>
    <v-dialog v-model="registerDialogIsOpen" max-width="500px" @click:outside="closeDialog" persistent>
        <v-container class="container__register">
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="6" lg="12">
                    <v-card class="elevation-12 rounded-lg" border>
                        <div class="d-flex justify-end align-center" style="padding-top: 10px">
                            <v-icon class="mr-2" @click="closeDialog">mdi-close</v-icon>
                        </div>

                        <div class="d-flex align-center justify-center mt-1">
                            <v-img
                                :src="logo"
                                max-height="140"
                                max-width="140"
                                contain
                            />
                        </div>

                        <v-card-text>
                            <v-form @submit.prevent="handleRegister" ref="form">
                                <v-text-field
                                    v-model="form.name"
                                    :label="translate('register.name')"
                                    :placeholder="translate('register.namePlaceholder')"
                                    prepend-icon="mdi-account"
                                    required
                                    outlined
                                    dense
                                    :error-messages="nameErrors"
                                    @input="clearNameError"
                                ></v-text-field>

                                <v-text-field
                                    v-model="form.email"
                                    :label="translate('register.email')"
                                    :placeholder="translate('register.emailPlaceholder')"
                                    prepend-icon="mdi-email"
                                    required
                                    outlined
                                    dense
                                    :error-messages="emailErrors"
                                    @input="clearEmailError"
                                ></v-text-field>

                                <v-text-field
                                    v-model="form.confirmEmail"
                                    :label="translate('register.confirmEmail')"
                                    :placeholder="translate('register.confirmEmailPlaceholder')"
                                    prepend-icon="mdi-email-check"
                                    required
                                    outlined
                                    dense
                                    :error-messages="confirmEmailErrors"
                                    @input="clearConfirmEmailError"
                                ></v-text-field>

                                <v-text-field
                                    v-model="form.password"
                                    :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="isPasswordVisible ? 'text' : 'password'"
                                    :label="translate('register.password')"
                                    :placeholder="translate('register.passwordPlaceholder')"
                                    prepend-icon="mdi-lock"
                                    @click:append="isPasswordVisible = !isPasswordVisible"
                                    required
                                    outlined
                                    dense
                                    :error-messages="passwordErrors"
                                    @input="clearPasswordError"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>

                        <v-card-text>
                            <v-btn
                                color="primary"
                                class="register-btn"
                                @click="handleRegister"
                                :loading="loading"
                            >
                                {{ translate('register.register') }}
                            </v-btn>
                        </v-card-text>

                        <v-card-text class="text-center mt-4 form2 fontsize3 font">
                            <p>
                                {{ translate('register.alreadyRegistered') }}
                                <v-btn @click="goToLogin" style="color: #4cc8ff" class="fontsize3">
                                    {{ translate('register.login') }}
                                </v-btn>
                            </p>
                        </v-card-text>

                        <v-divider></v-divider>
                        <v-card-text class="text-center">
                            <p class="text-body-2 mb-3">{{ translate('register.or') }}</p>
                            <v-btn icon="mdi-google" color="red" variant="text" class="mx-2" @click="socialRegister('google')"></v-btn>
                            <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2" @click="socialRegister('facebook')"></v-btn>
                            <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2" @click="socialRegister('twitter')"></v-btn>
                            <v-btn icon="mdi-apple" color="grey-darken-3" variant="text" class="mx-2" @click="socialRegister('apple')"></v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
    <v-dialog v-model="loginDialogIsOpen" max-width="500px" @click:outside="closeLoginDialog" persistent>
        <Login @close="closeLoginDialog" />
    </v-dialog>
</template>

<script>
import { ref, reactive } from "vue";
import InjaUnjaLogo from "../../../public/inja-unja.png";
import { translate } from "../store/languageStore";
import Login from "./Login.vue";

export default {
    name: "Register",
    components: {
        Login,
    },
    setup(_, { emit }) {
        const registerDialogIsOpen = ref(true);
        const loginDialogIsOpen = ref(false);
        const form = reactive({
            name: "",
            email: "",
            confirmEmail: "",
            password: "",
        });
        const isPasswordVisible = ref(false);
        const loading = ref(false);
        const logo = ref(InjaUnjaLogo);
        const snackbar = reactive({
            show: false,
            text: "",
            color: "",
            timeout: 3000,
        });

        const nameErrors = ref("");
        const emailErrors = ref("");
        const confirmEmailErrors = ref("");
        const passwordErrors = ref("");

        const handleRegister = () => {
            nameErrors.value = "";
            emailErrors.value = "";
            confirmEmailErrors.value = "";
            passwordErrors.value = "";

            if (!form.name) {
                nameErrors.value = translate("register.nameRequired");
            }
            if (!form.email) {
                emailErrors.value = translate("register.emailRequired");
            }
            if (!form.confirmEmail) {
                confirmEmailErrors.value = translate("register.confirmEmailRequired");
            }
            if (form.email !== form.confirmEmail) {
                confirmEmailErrors.value = translate("register.emailsDoNotMatch");
            }
            if (!form.password) {
                passwordErrors.value = translate("register.passwordRequired");
            }

            if (nameErrors.value || emailErrors.value || confirmEmailErrors.value || passwordErrors.value) {
                return;
            }

            loading.value = true;
            setTimeout(() => {
                snackbar.text = translate("register.registerSuccess");
                snackbar.color = "success";
                snackbar.show = true;
            }, 1500);

            loading.value = false;
        };

        const closeDialog = () => {
            registerDialogIsOpen.value = false;
        };

        const closeLoginDialog = () => {
            loginDialogIsOpen.value = false;
        };

        const goToLogin = () => {
            closeDialog();
            loginDialogIsOpen.value = true;
        };

        const clearNameError = () => {
            nameErrors.value = "";
        };

        const clearEmailError = () => {
            emailErrors.value = "";
        };

        const clearConfirmEmailError = () => {
            confirmEmailErrors.value = "";
        };

        const clearPasswordError = () => {
            passwordErrors.value = "";
        };

        return {
            registerDialogIsOpen,
            loginDialogIsOpen,
            form,
            isPasswordVisible,
            loading,
            logo,
            snackbar,
            nameErrors,
            emailErrors,
            confirmEmailErrors,
            passwordErrors,
            handleRegister,
            closeDialog,
            closeLoginDialog,
            goToLogin,
            clearNameError,
            clearEmailError,
            clearConfirmEmailError,
            clearPasswordError,
            translate,
        };
    },
};
</script>

<style scoped lang="scss">
.register-btn {
    width: 70%;
    height: 50px;
    font-size: 16px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    margin-left: 70px;
    &:hover {
        background-color: #1e88e5 !important;
        transform: scale(1.05);
    }

    &:active {
        transform: scale(0.98);
    }
}

.container__register {
    .v-card {
        transition: all 0.3s ease-in-out;
    }

    .v-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }

    .v-btn {
        transition: all 0.2s ease-in-out;
    }

    .v-btn:hover {
        transform: scale(1.05);
    }

    .text-center {
        text-align: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
}
</style>
