<template>
    <v-dialog v-model="openRegisterDialog">
        <v-container class="container__register">
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="6" lg="4">
                    <v-card class="elevation-12 rounded-lg" border>
                        <div class="d-flex justify-end align-center" style="padding-top: 10px">
                            <v-icon class="mr-2" @click="coseDialog">mdi-close</v-icon>
                        </div>
                        <div class="d-flex align-center justify-center mt-1">
                            <v-img
                                :src="logo"
                                max-height="140"
                                max-width="140"
                                contain
                            />
                        </div>

                        <v-alert
                            v-if="successMessage"
                            type="success"
                            dismissible
                            class="mt-3"
                        >
                            {{ translate(successMessage) }}
                        </v-alert>
                        <v-alert
                            v-if="error"
                            type="error"
                            dismissible
                            class="mt-3"
                        >
                            {{ translate(error) }}
                        </v-alert>
                        <v-card-text>
                            <v-form @submit.prevent="register" ref="form">
                                <v-text-field
                                    v-model="name"
                                    :rules="[v => !!v || translate('REGISTER_NAME_REQUIRED')]"
                                    :label="translate('REGISTER_NAME')"
                                    prepend-icon="mdi-account"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    v-model="email"
                                    :rules="[
                              v => !!v || translate('REGISTER_EMAIL_REQUIRED'),
                              v => /.+@.+\..+/.test(v) || translate('EMAIL_VALID')]"
                                    :label="translate('REGISTER_EMAIL')"
                                    prepend-icon="mdi-email"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    v-model="confirmEmail"
                                    :rules="[
                              v => !!v || translate('VERIFICATION_EMAIL'),
                              v => v === email || translate('EMAIL_MATCH_WARNING')]"
                                    :label="translate('REGISTER_CONFIRMEMAIL')"
                                    prepend-icon="mdi-email-check"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    v-model="password"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="[v => !!v || translate('PASSWORDREQUIRED')]"
                                    :type="showPassword ? 'text' : 'password'"
                                    :label="translate('REGISTER_PASSWORD')"
                                    prepend-icon="mdi-lock"
                                    @click:append="showPassword = !showPassword"
                                    required
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn-primary color="primary" @click="register" :loading="loading">
                                {{ translate('REGISTER_REGISTER') }}
                            </v-btn-primary>
                        </v-card-actions>
                        <v-card-text class="text-center">
                            <v-divider class="my-3"></v-divider>
                            <div class="text-body-2 mb-3">{{ translate('REGISTER_OR') }}</div>
                            <v-btn icon="mdi-google" color="red" variant="text" class="mx-2"></v-btn>
                            <v-btn icon="mdi-apple" color="black" variant="text" class="mx-2"></v-btn>
                            <v-btn icon="mdi-facebook" color="blue" variant="text" class="mx-2"></v-btn>
                            <v-btn icon="mdi-twitter" color="light-blue" variant="text" class="mx-2"></v-btn>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-dialog>
</template>

<script>
import InjaUnjaLogo from "@/assets/images/logo1.png"
import apiService from "@/globalServices/apiService";
import { translate } from "@/store/languageStore";

export default {
    name: "Register",
    data() {
        return {
            openRegisterDialog: true,
            name: '',
            email: '',
            confirmEmail: '',
            password: '',
            showPassword: false,
            loading: false,
            logo: null,
            error: null,
            successMessage: null
        };
    },
    created() {
        this.logo = InjaUnjaLogo;
    },
    methods: {
        translate,
        coseDialog() {
            this.$emit('closeRegisterDialog');
        },
        async register() {
            this.loading = true;
            this.error = null;

            const formData = {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password,
                provider:'traditional'
            };
            try {
                const response = await apiService.axiosToBackend().post('/api/register', formData);
                if (response.data.success || response.status === 200) {
                    this.successMessage = 'REGISTRATION_SUCCESS';
                    localStorage.setItem('authToken', response.data.token);

                    setTimeout(() => {
                        window.location.href = '/UserProfile';
                    }, 1500);

                } else {
                    this.error = response.data.message;
                }
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.error = error.response.data.message || "EMAIL_ALREADY_REGISTERED";
                    if (error.response.data.errors) {
                        const fieldErrors = Object.values(error.response.data.errors).flat().join(' ');
                        this.error = `${this.error} (${fieldErrors})`;
                    }
                } else if (error.request) {
                    this.error = 'NO_SERVER_RESPONSE';
                } else {
                    this.error = 'REQUEST_CONFIGURATION_ERROR';
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
