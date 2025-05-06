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
import { translate } from "@/store/languageStore";

export default {
    name: "Login",
    data() {
        return {
            loginDialogIsOpen: true,
            form: {
                email: "",
                password: "",
                remember: false,
            },
            isPasswordVisible: false,
            loading: false,
            logo: new URL('../../../public/inja-unja.png', import.meta.url).href,
            loginAttempts: 0,
            snackbar: {
                show: false,
                text: "",
                color: "",
                timeout: 3000,
            },
            emailErrors: "",
            passwordErrors: "",
            modalActive: false,
            selectedComponent: null,
            ForgotPassword: null,
            Register: null
        };
    },
    methods: {
        translate,

        openLoginDialog() {
            this.loginDialogIsOpen = true;
        },
        handleLogin() {
            this.emailErrors = "";
            this.passwordErrors = "";

            if (!this.form.email) {
                this.emailErrors = this.translate("login.emailRequired");
            }
            if (!this.form.password) {
                this.passwordErrors = this.translate("login.passwordRequired");
            }

            if (this.emailErrors || this.passwordErrors) {
                return;
            }

            this.loading = true;
            setTimeout(() => {
                this.snackbar.text = this.translate("login.loginSuccess");
                this.snackbar.color = "success";
                this.snackbar.show = true;
                this.loading = false;
            }, 1500);
        },
        closeDialog() {
            this.loginDialogIsOpen = false;
        },
        async openModal(component) {
            this.modalActive = false;
            this.selectedComponent = component;
            this.modalActive = true;
        },
        async goToForgotPassword() {
            try {
                const module = await import('./layout/menu_component/forgot-password.vue');
                this.ForgotPassword = module.default;
                this.selectedComponent = this.ForgotPassword;
                this.modalActive = true;
            } catch (error) {
                console.error("Failed to load ForgotPassword component:", error);
            }
        },
        async goToRegister() {
            try {
                const module = await import('./RegisterUser.vue');
                this.Register = module.default;
                this.selectedComponent = this.Register;
                this.modalActive = true;
            } catch (error) {
                console.error("Failed to load Register component:", error);
            }
        },
        clearEmailError() {
            this.emailErrors = "";
        },
        clearPasswordError() {
            this.passwordErrors = "";
        },
        socialLogin(provider) {
            console.log(`Logging in with ${provider}`);
        },
    },
    created() {
        this.goToForgotPassword().catch(() => {});
        this.goToRegister().catch(() => {});
    }
};
</script>
<style scoped>
.login-btn {
    width: 100%;
    margin-top: 10px;
}

.red--text {
    color: #ff5252 !important;
    font-weight: bold;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}


.fontsize3 {
    font-size: 0.9rem;
}

.v-card {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}
</style>

