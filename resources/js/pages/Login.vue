<template>
    <v-dialog v-model="loginDialogIsOpen" max-width="500px" @click:outside="closeDialog">
        <v-container class="container__login">
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
                            <v-form @submit.prevent="handleLogin" ref="form">
                                <v-text-field
                                    v-model="form.email"
                                    :label="translate('login.email')"
                                    :placeholder="translate('login.emailPlaceholder')"
                                    prepend-icon="mdi-email"
                                    required
                                    outlined
                                    dense
                                    :error-messages="emailErrors"
                                    @input="clearEmailError"
                                ></v-text-field>

                                <v-text-field
                                    v-model="form.password"
                                    :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                    :type="isPasswordVisible ? 'text' : 'password'"
                                    :label="translate('login.password')"
                                    :placeholder="translate('login.passwordPlaceholder')"
                                    prepend-icon="mdi-lock"
                                    @click:append="isPasswordVisible = !isPasswordVisible"
                                    required
                                    outlined
                                    dense
                                    :error-messages="passwordErrors"
                                    @input="clearPasswordError"
                                ></v-text-field>

                                <v-checkbox
                                    v-model="form.remember"
                                    :label="translate('login.rememberMe')"
                                ></v-checkbox>
                            </v-form>
                        </v-card-text>

                        <v-card-text>
                            <v-dialog v-model="modalActive" max-width="500px">
                                <component :is="selectedComponent" @close="modalActive = false"></component>
                            </v-dialog>
                            <v-list-item @click="openModal(goToForgotPassword)">
                                <v-list-item-title>{{ translate("login.forgotPassword") }}</v-list-item-title>
                            </v-list-item>
                            <v-btn
                                color="primary"
                                class="login-btn"
                                @click="handleLogin"
                                :loading="loading"
                                :disabled="loginAttempts >= 5"
                            >
                                {{ translate('login.login') }}
                            </v-btn>
                        </v-card-text>

                        <v-card-text v-if="loginAttempts >= 5" class="text-center red--text">
                            {{ translate('login.tooManyAttempts') }}
                        </v-card-text>

                        <v-card-text class="text-center mt-4 form2 fontsize3 font">
                            <p>
                                {{ translate('login.newUser') }}
                                <v-btn @click="openModal(goToRegister)" style="color: #4cc8ff" class="fontsize3">
                                    {{ translate('login.createAccount') }}
                                </v-btn>
                            </p>
                        </v-card-text>

                        <v-divider></v-divider>
                        <v-card-text class="text-center">
                            <p class="text-body-2 mb-3">{{ translate('login.or') }}</p>
                            <v-btn icon="mdi-google" color="red" variant="text" class="mx-2" @click="socialLogin('google')"></v-btn>
                            <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2" @click="socialLogin('facebook')"></v-btn>
                            <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2" @click="socialLogin('twitter')"></v-btn>
                            <v-btn icon="mdi-apple" color="grey-darken-3" variant="text" class="mx-2" @click="socialLogin('apple')"></v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>

            <v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="snackbar.timeout">
                {{ snackbar.text }}
                <template v-slot:actions>
                    <v-btn color="white" @click="snackbar.show = false">
                        {{ translate('login.close') }}
                    </v-btn>
                </template>
            </v-snackbar>
        </v-container>
    </v-dialog>
</template>

<script>
import { ref, reactive } from "vue";
import InjaUnjaLogo from "../../../public/inja-unja.png";
import { translate } from "../store/languageStore";
import Register from "./RegisterUser.vue";
import ForgotPassword from "./layout/menu_component/forgot-password.vue";

export default {
    name: "Login",
    setup(_, { emit }) {
        const modalActive = ref(false);
        const selectedComponent = ref(null);
        const form = ref({
            email: "",
            password: "",
            remember: false,
        });
        const loginDialogIsOpen = ref(true);
        const isPasswordVisible = ref(false);
        const loading = ref(false);
        const logo = ref(InjaUnjaLogo);
        const loginAttempts = ref(0);
        const snackbar = reactive({
            show: false,
            text: "",
            color: "",
            timeout: 3000,
        });

        const emailErrors = ref("");
        const passwordErrors = ref("");

        const openLoginDialog = () => {
            loginDialogIsOpen.value = true;
        };

        const handleLogin = () => {
            emailErrors.value = "";
            passwordErrors.value = "";

            if (!form.value.email) {
                emailErrors.value = translate("login.emailRequired");
            }
            if (!form.value.password) {
                passwordErrors.value = translate("login.passwordRequired");
            }

            if (emailErrors.value || passwordErrors.value) {
                return;
            }

            loading.value = true;
            setTimeout(() => {
                snackbar.text = translate("login.loginSuccess");
                snackbar.color = "success";
                snackbar.show = true;
            }, 1500);

            loading.value = false;
        };

        const closeDialog = () => {
            loginDialogIsOpen.value = false;
        };
        const openModal = (component) => {
            modalActive.value = false;
            selectedComponent.value = component;
            modalActive.value = true;
        };

        const goToForgotPassword = () => {
            selectedComponent.value = ForgotPassword;
            modalActive.value = true;
        };

        const goToRegister = () => {
            selectedComponent.value = Register;
            modalActive.value = true;
        };

        return {
            loginDialogIsOpen,
            openLoginDialog,
            form,
            isPasswordVisible,
            loading,
            logo,
            loginAttempts,
            snackbar,
            emailErrors,
            passwordErrors,
            handleLogin,
            closeDialog,
            goToForgotPassword,
            goToRegister,
            openModal,
            translate,
            modalActive,
            selectedComponent,
        };
    },
};
</script>

<style scoped lang="scss">
.login-btn {
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

.container__login {
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
