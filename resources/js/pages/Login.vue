<template>
    <v-dialog v-model="loginDialogIsOpen" max-width="640px" @click:outside="closeDialog" aria-label="Login dialog">
        <v-container class="container__login pa-0" style="min-width: 320px;">
            <v-row align="center" justify="center" no-gutters>
                <v-col cols="12" sm="10" md="8" lg="8">
                    <v-card class="elevation-12 rounded-lg pa-5" border>
                        <div class="d-flex justify-end align-center mb-2">
                            <v-btn icon class="close-btn" @click="closeDialog" aria-label="Close login dialog" variant="text">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </div>
                        <div class="d-flex align-center justify-center mb-4 mt-2">
                            <v-img
                                :src="logo"
                                max-height="110"
                                max-width="110"
                                contain
                                alt="App logo"
                            />
                        </div>
                        <v-alert
                            v-if="successMessage"
                            type="success"
                            dismissible
                            class="mb-3"
                            aria-live="polite"
                        >
                            {{ successMessage }}
                        </v-alert>
                        <v-alert
                            v-if="error"
                            type="error"
                            dismissible
                            class="mb-3"
                            aria-live="assertive"
                        >
                            {{ error }}
                        </v-alert>
                        <v-card-text class="pa-0">
                            <v-form @submit.prevent="handleLogin" ref="form" class="d-flex flex-column gap-3">
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
                                    autocomplete="email"
                                    aria-label="Email address"
                                    class="mb-2"
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
                                    autocomplete="current-password"
                                    aria-label="Password"
                                    class="mb-2"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="form.remember"
                                    :label="translate('login.rememberMe')"
                                    class="mb-1"
                                    aria-label="Remember me"
                                ></v-checkbox>
                            </v-form>
                        </v-card-text>
                        <v-list-item @click="goToForgotPassword" class="px-0 mb-2" style="cursor:pointer;">
                            <v-list-item-title class="text-primary text-caption font-weight-medium" tabindex="0" aria-label="Forgot password">
                                {{ translate("login.forgotPassword") }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-card-text class="pa-0 mt-2">
                            <v-btn
                                color="primary"
                                class="login-btn font-weight-bold text-body-1"
                                @click="handleLogin"
                                :loading="loading"
                                :disabled="loginAttempts >= 5"
                                block
                                large
                                aria-label="Login"
                            >
                                {{ translate('login.login') }}
                            </v-btn>
                        </v-card-text>
                        <v-card-text v-if="loginAttempts >= 5" class="text-center red--text mt-2" aria-live="assertive">
                            {{ translate('login.tooManyAttempts') }}
                        </v-card-text>
                        <v-card-text class="text-center mt-4 form2 fontsize3 font pa-0">
                            <p class="mb-0">
                                {{ translate('login.newUser') }}
                                <v-btn @click="openModal(goToRegister)" style="color: #4cc8ff" class="fontsize3 font-weight-bold text-capitalize" variant="text" aria-label="Create account">
                                    {{ translate('login.createAccount') }}
                                </v-btn>
                            </p>
                        </v-card-text>
                        <v-divider class="my-4"></v-divider>
                        <v-card-text class="text-center pa-0">
                            <p class="text-body-2 mb-3 font-weight-medium" style="color: #757575;">{{ translate('login.or') }}</p>
                            <v-btn icon="mdi-google" color="red" variant="text" class="mx-2 social-btn" @click="socialLogin('google')" aria-label="Login with Google"></v-btn>
                            <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2 social-btn" @click="socialLogin('facebook')" aria-label="Login with Facebook"></v-btn>
                            <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2 social-btn" @click="socialLogin('twitter')" aria-label="Login with Twitter"></v-btn>
                            <v-btn icon="mdi-apple" color="grey-darken-3" variant="text" class="mx-2 social-btn" @click="socialLogin('apple')" aria-label="Login with Apple"></v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";
import apiService from "@/globalServices/apiService";
import forgot_password from "./layout/menu_component/forgot-password.vue";

export default {
    name: "Login",
    data() {
        return {
            forgot_password,
            userLogged: undefined,
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
            emailErrors: "",
            passwordErrors: "",
            modalActive: false,
            selectedComponent: null,
            ForgotPassword: null,
            Register: null,
            successMessage: null,
            error: null
        };
    },
    methods: {
        translate,

        loginDialogIsOpen() {
            this.loginDialogIsOpen = true;
        },

        async handleLogin() {
            try {
                this.loading = true;
                this.error = null;
                this.successMessage = null;
                this.emailErrors = "";
                this.passwordErrors = "";

                if (!this.form.email) {
                    this.emailErrors = this.translate("login.emailRequired");
                    throw new Error('Email is required');
                }
                if (!this.form.password) {
                    this.passwordErrors = this.translate("login.passwordRequired");
                    throw new Error('Password is required');
                }

                const userLoginData = {
                    email: this.form.email,
                    password: this.form.password,
                    provider: 'traditional'
                };

                const loginResponse = await apiService.axiosToBackend().post('/api/login', userLoginData);

                if (loginResponse.data.success || loginResponse.status === 200) {
                    this.userLogged = loginResponse.data;
                    this.successMessage = this.translate('Login successful! Redirecting...');

                    localStorage.setItem('authToken', loginResponse.data.token);
                    setTimeout(() => {
                        window.location.href = '/UserDashboard';
                    }, 1500);
                } else {
                    this.error = loginResponse.data.message || this.translate('login.loginFailed');
                    this.loginAttempts++;
                }

            } catch (error) {
                console.error('Login error:', error);

                if (error.response) {
                    if (error.response.status === 401) {
                        this.error = this.translate('login.invalidCredentials');
                    } else if (error.response.status === 422) {
                        this.error = error.response.data.message || "Invalid input data";
                    } else {
                        this.error = this.translate('login.loginFailed');
                    }
                } else if (error.request) {
                    this.error = this.translate('login.noServerResponse');
                } else {
                    this.error = this.translate('login.unexpectedError');
                }

                this.loginAttempts++;
            } finally {
                this.loading = false;
            }
        },

        closeDialog() {
            this.loginDialogIsOpen = false;
            this.$emit("close");
        },

        async openModal(component) {
            this.modalActive = false;
            this.selectedComponent = component;
            this.modalActive = true;
        },
        async goToForgotPassword() {
            this.selectedComponent = forgot_password;
            this.modalActive = true;
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

};
</script>

<style scoped>
.close-btn {
    transition: transform 0.2s, background 0.2s;
    border-radius: 50%;
}
.close-btn:hover, .close-btn:focus {
    transform: rotate(90deg) scale(1.1);
    background: #1c1919;
    outline: none;
}
.login-btn {
    width: 100%;
    margin-top: 10px;
    min-height: 44px;
    letter-spacing: 0.5px;
    border-radius: 8px;
    transition: box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(76, 200, 255, 0.08);
}
.login-btn:hover:not([disabled]), .login-btn:focus:not([disabled]) {
    box-shadow: 0 4px 16px rgba(76, 200, 255, 0.18);
    outline: none;
}
.red--text {
    color: #ff5252 !important;
    font-weight: bold;
    animation: pulse 1.5s infinite;
    font-size: 1rem;
}
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
.fontsize3 {
    font-size: 1rem;
}
.v-card {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
    border-radius: 16px;
}
.social-btn {
    transition: background 0.2s, transform 0.2s;
    border-radius: 50%;
}
.social-btn:hover, .social-btn:focus {
    background: #f5f5f5;
    transform: scale(1.1);
    outline: none;
}
.v-text-field input,
.v-text-field label {
    font-size: 1rem;
}
.v-alert {
    font-size: 0.98rem;
    border-radius: 8px;
}
.v-list-item-title {
    cursor: pointer;
    text-decoration: underline;
    font-size: 0.95rem;
}
.v-list-item-title:focus {
    outline: 2px solid #4cc8ff;
    outline-offset: 2px;
}
@media (max-width: 600px) {
    .v-card {
        padding: 8px !important;
    }
    .v-card-text {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .container__login {
        padding: 0 !important;
    }
}
</style>
