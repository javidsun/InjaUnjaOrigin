<template>
    <v-dialog v-model="loginDialogIsOpen" >
        <v-container class="container__login">
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
                        <v-card-text>
                            <v-form @submit.prevent="login" ref="form">
                                <v-text-field
                                    v-model="email"
                                    :rules="emailRules"
                                    label="Email"
                                    prepend-icon="mdi-email"
                                    required
                                    @keyup="resetLoginAttempts"
                                ></v-text-field>
                                <v-text-field
                                    v-model="password"
                                    :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="passwordRules"
                                    :type="showPassword ? 'text' : 'password'"
                                    label="Password"
                                    prepend-icon="mdi-lock"
                                    @click:append="showPassword = !showPassword"
                                    required
                                    @keyup="resetLoginAttempts"
                                ></v-text-field>
                                <v-checkbox
                                    v-model="rememberMe"
                                    label="Ricordami"
                                ></v-checkbox>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn text @click="forgotPassword">Password Dimenticata?</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" @click="login" :loading="loading" :disabled="loginAttempts >= 5">
                                Accedi
                            </v-btn>
                        </v-card-actions>
                        <v-card-text v-if="loginAttempts >= 5" class="text-center red--text">
                            Troppi tentativi di accesso. Riprova più tardi.
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-text class="text-center">
                            <p class="text-body-2 mb-3">Oppure accedi con</p>
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
                    <v-btn color="white" @click="snackbar.show = false">Chiudi</v-btn>
                </template>
            </v-snackbar>
        </v-container>
    </v-dialog>
</template>

<script>
import { ref, reactive } from 'vue';
import { useTheme } from 'vuetify';
import InjaUnjaLogo from "@/assets/images/logo1.png"
import apiService from "@/globalServices/apiService.js";

export default {
    name: "Login",
    props: {

    },
    data() {
        return {
            loginDialogIsOpen: true ,
            email: '',
            password: '',
            showPassword: false,
            loading: false,
            logo: null,
            error: null,
            rememberMe: false,
            loginAttempts: 0,
            theme: useTheme(),
            snackbar: reactive({
                show: false,
                text: '',
                color: '',
                timeout: 3000,
            }),
        };
    },
    created() {
        this.logo = InjaUnjaLogo;
    },
    methods: {
        async login() {
            this.loading = true;
            this.error = null;

            const formData = {
                email: this.email,
                password: this.password,
            };

            try {
                // Richiesta del token CSRF
                await apiService.axiosToBackend().get('/sanctum/csrf-cookie');
                const response = await apiService.axiosToBackend().post('/api/login', formData);

                if (response.data.success) {
                    console.log('Login completato:', response.data);
                    // Redirigi alla dashboard
                    this.$router.push('/dashboard');
                } else {
                    this.error = response.data.message;
                }
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    this.error = 'Credenziali errate. Controlla email e password.';
                } else {
                    this.error = 'Errore durante il login. Riprova più tardi.';
                }
                console.error('Errore durante il login:', error);
            } finally {
                this.loading = false;
            }
        },
        coseDialog(){
            this.$emit('closeDialog');
        },
        toggleTheme() {
            this.theme.global.name.value = this.theme.global.current.value.dark ? 'light' : 'dark';
        },
        resetLoginAttempts() {
            if (this.loginAttempts >= 5) {
                setTimeout(() => {
                    this.loginAttempts = 0;
                }, 300000); // Reset dopo 5 minuti
            }
        },
        /*async login() {
            const { valid } = await this.form.value.validate();

            if (valid) {
                this.loading = true;
                this.loginAttempts++;

                try {
                    await new Promise(resolve => setTimeout(resolve, 1500)); // Simula una richiesta di login
                    if (Math.random() > 0.7) {
                        throw new Error('Login failed');
                    }
                    this.snackbar.text = 'Accesso effettuato con successo!';
                    this.snackbar.color = 'success';
                    this.snackbar.show = true;

                    if (this.rememberMe) {
                        localStorage.setItem('userEmail', this.email);
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    this.snackbar.text = 'Errore durante l\'accesso. Riprova.';
                    this.snackbar.color = 'error';
                    this.snackbar.show = true;
                } finally {
                    this.loading = false;
                }
            }
        },*/
        forgotPassword() {
            this.snackbar.text = 'Istruzioni per il reset della password inviate.';
            this.snackbar.color = 'info';
            this.snackbar.show = true;
        },
        socialLogin(provider) {
            this.snackbar.text = `Accesso con ${provider} iniziato.`;
            this.snackbar.color = 'info';
            this.snackbar.show = true;
        }
    },
    mounted() {
        const savedEmail = localStorage.getItem('userEmail');
        if (savedEmail) {
            this.email = savedEmail;
            this.rememberMe = true;
        }
    },
    computed: {
        emailRules() {
            return [
                v => !!v || 'L\'email è obbligatoria',
                v => /.+@.+\..+/.test(v) || 'L\'email deve essere valida',
            ];
        },
        passwordRules() {
            return [
                v => !!v || 'La password è obbligatoria',
                v => v.length >= 8 || 'La password deve essere lunga almeno 8 caratteri',
            ];
        }
    }
};
</script>

<style scoped lang="scss">
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
