<template>
    <v-dialog v-model="openRegisterDialog" max-width="640px" @click:outside="closeDialog" aria-label="Register dialog">
        <v-container class="container__register pa-0" style="min-width: 320px;">
            <v-row align="center" justify="center" no-gutters>
                <v-col cols="12" sm="10" md="8" lg="8">
                    <v-card class="elevation-12 rounded-lg pa-5" border>
                        <div class="d-flex justify-end align-center mb-2">
                            <v-btn icon class="close-btn" @click="closeDialog" aria-label="Close registration dialog" variant="text">
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
                            <v-form @submit.prevent="register" ref="form" class="d-flex flex-column gap-3">
                                <v-text-field
                                    v-model="name"
                                    :rules="[v => !!v || translate('register.name') + ' is required']"
                                    :label="translate('register.name')"
                                    prepend-icon="mdi-account"
                                    required
                                    class="mb-2"
                                />
                                <v-text-field
                                    v-model="email"
                                    :rules="[
                                        v => !!v || 'Email is required',
                                        v => /.+@.+\..+/.test(v) || 'Email must be valid']"
                                    :label="translate('register.email')"
                                    prepend-icon="mdi-email"
                                    required
                                    class="mb-2"
                                ></v-text-field>
                                <v-text-field
                                    v-model="confirmEmail"
                                    :rules="[
                                        v => !!v || 'Email confirmation is required',
                                        v => v === email || 'Emails do not match']"
                                    :label="translate('register.confirmEmail')"
                                    prepend-icon="mdi-email-check"
                                    required
                                    class="mb-2"
                                ></v-text-field>
                                <v-text-field
                                    v-model="password"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="[v => !!v || 'Password is required']"
                                    :type="showPassword ? 'text' : 'password'"
                                    :label="translate('register.password')"
                                    prepend-icon="mdi-lock"
                                    @click:append="showPassword = !showPassword"
                                    required
                                    class="mb-2"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions class="pt-0 pb-2">
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="register" :loading="loading" class="register-btn font-weight-bold text-body-1" block large aria-label="Register">
                                {{ translate('register.register') }}
                            </v-btn>
                        </v-card-actions>
                        <v-divider class="my-4"></v-divider>
                        <v-card-text class="text-center pa-0">
                            <p class="text-body-2 mb-3 font-weight-medium" style="color: #757575;">  {{ translate('register.or') }}</p>
                            <v-btn icon="mdi-google" color="red" variant="text" class="mx-2 social-btn" aria-label="Register with Google"></v-btn>
                            <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2 social-btn" aria-label="Register with Facebook"></v-btn>
                            <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2 social-btn" aria-label="Register with Twitter"></v-btn>
                            <v-btn icon="mdi-apple" color="grey-darken-3" variant="text" class="mx-2 social-btn" aria-label="Register with Apple"></v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script>
import apiService from "@/globalServices/apiService";
import { translate } from "@/store/languageStore";

export default {
    name: "RegisterUser",
    data() {
        return {
            openRegisterDialog: true,
            name: '',
            email: '',
            confirmEmail: '',
            password: '',
            showPassword: false,
            loading: false,
            error: null,
            successMessage: null,
            logo: new URL('../../../public/inja-unja.png', import.meta.url).href,


        };
    },

    methods: {
        translate,

        closeDialog() {
            this.openRegisterDialog = false;
            this.$emit("close");
        },

        async register() {
            this.loading = true;
            this.error = null;

            const formData = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password, // Corretto per la regola 'confirmed' di Laravel
                provider:'traditional'
            };
            try {
                const response = await apiService.axiosToBackend().post('/api/register', formData);
                if (response.data.success || response.status === 200) {
                    this.successMessage = 'Registration successful! Redirecting...';
                    localStorage.setItem('authToken', response.data.token);

                    setTimeout(() => {
                        window.location.href = '/UserProfile';
                    }, 1500);

                } else {
                    this.error = response.data.message;
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.error = error.response.data.message || "This email is already registered. Please use a different email or login.";
                    if (error.response.data.errors) {
                        const fieldErrors = Object.values(error.response.data.errors).flat().join(' ');
                        this.error = `${this.error} (${fieldErrors})`;
                    }
                } else if (error.request) {
                    this.error = 'Nessuna risposta dal server. Controlla la connessione.';
                } else {
                    this.error = 'Errore imprevisto nella configurazione della richiesta.';
                }

            }
            finally {
                this.loading = false;
            }

        },
    }
};
</script>

<style scoped lang="scss">
.close-btn {
    transition: transform 0.2s, background 0.2s;
    border-radius: 50%;
}
.close-btn:hover, .close-btn:focus {
    transform: rotate(90deg) scale(1.1);
    background: #1c1919;
    outline: none;
}
.register-btn {
    width: 100%;
    min-height: 44px;
    letter-spacing: 0.5px;
    border-radius: 8px;
    transition: box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(76, 200, 255, 0.08);
    margin-top: 10px;
}
.register-btn:hover:not([disabled]), .register-btn:focus:not([disabled]) {
    box-shadow: 0 4px 16px rgba(76, 200, 255, 0.18);
    outline: none;
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
.v-card {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
    border-radius: 16px;
}
.text-center {
    text-align: center;
}
.mb-3 {
    margin-bottom: 1rem;
}
.font-weight-medium {
    font-weight: 500;
}
@media (max-width: 600px) {
    .v-card {
        padding: 8px !important;
    }
    .v-card-text {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    .container__register {
        padding: 0 !important;
    }
}
</style>
