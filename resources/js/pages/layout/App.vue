<template>
    <v-app>
        <v-app-bar elevation="0">

            <!--TODO:v-if="!!user?.email"  -->
            <v-container class="d-flex align-center justify-space-between pr-5" style="width: 100%; height: 100%">
                <div class="d-flex align-center pr-5" >
                    <div class="d-flex align-center">
                        <InertiaLink style="position: absolute; left: 1px;">
                            <v-img
                                :src="logo"
                                max-height="100%"
                                width="220"
                            />
                        </InertiaLink>
                    </div>
                    <v-menu
                        location="bottom"
                        rounded
                        :close-on-content-click="true"
                    >
                        <template v-slot:activator="{ props }">
                            <div class="d-flex justify-end align-center" style="width: 100%;">
                                <v-avatar
                                    color="primary"
                                    size="45"
                                    class="ml-5"
                                    style="cursor: pointer; position: absolute; right: 20px; top: 15px;"
                                    v-bind="props"
                                >
                                    <span class="white--text">
                                         {{ 'javid' }}
                                    </span>
                                </v-avatar>
                            </div>
                        </template>

                        <v-card-main
                            style="width: 250px"
                            border
                        >
                            <div class="justify-center">
                                <div class="mx-auto text-center py-5">
                                    <v-avatar color="primary" class="mb-1">
                            <span class="white--text text-h5">
                                {{ 'JS' }}
                            </span>
                                    </v-avatar>
                                    <h5>{{ 'USERNAME'}}</h5>
                                    <v-divider class="my-3"/>
                                    <InertiaLink href="userProfile" style="text-decoration: none; color: inherit;">
                                        <v-btn
                                            depressed
                                            rounded
                                            flat
                                            style="width: 90%"
                                        >
                                            {{ "PROFILE" }}
                                        </v-btn>
                                    </InertiaLink>
                                    <div style="padding-top: 2px">
                                        <v-btn
                                            depressed
                                            rounded
                                            flat
                                            style="width: 70%"
                                            @click="openRegisterPage"
                                        >
                                            {{ "SIGN_UP" }}
                                        </v-btn>
                                    </div>
                                    <div style="padding-top: 2px">
                                        <v-btn
                                            depressed
                                            rounded
                                            flat
                                            style="width: 70%"
                                            @click="openLoginPage"
                                        >
                                            {{ "LOGIN" }}
                                        </v-btn>
                                    </div>
                                    <v-divider class="my-3"/>
                                    <v-btn
                                        depressed
                                        rounded
                                        flat
                                        @click="logout"
                                        style="width: 90%"
                                    >
                                        {{ 'Logout' }}
                                    </v-btn>
                                    <v-divider class="my-3"/>
                                    <div class="d-flex px-5">
                                        <v-spacer/>
                                    </div>
                                </div>
                            </div>
                        </v-card-main>
                    </v-menu>
                </div>
            </v-container>
        </v-app-bar>
        <login
            v-if="loginPage"
            @closeDialog="closeDialog"
        />
        <Register
            v-if="registerPageIsOpen"
            @closeRegisterDialog="closeRegisterDialog"
        />

        <AppDrawer :isUserLogged="!!user?.email"/>

        <v-main>
            <v-container>
                <slot />
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import AppDrawer from "@/pages/layout/AppDrawer.vue";
import DefaultLogo from "@/assets/images/logo.png"
import Login from "@/pages/Login.vue";
import Register from "@/pages/RegisterUser.vue";
export default {
    components: {Register, Login, AppDrawer},
    data(){
        return {
            registerPageIsOpen:false,
            loginPage:false,
            logo:null,
        }
    },
    methods: {
        openRegisterPage(){
            this.registerPageIsOpen = true;
        },
        closeRegisterDialog(){
            this.registerPageIsOpen = false;
        },
        openLoginPage()
        {
            this.loginPage=true;
        },
        closeDialog(){
            this.loginPage=false;
         }
    },
    created() {
        this.logo=DefaultLogo;
    }
}
</script>

<style scoped lang="scss">
/* TODO :Qui puoi gestire gli stili per la tua app bar e altre parti del layout */
.divider {
    width: 2px;
    background-color: #ccc;
    height: 50%;
    margin-right: 2px;
    margin-left: 5px;
}

.menu-item {
    margin-left: 5px;
    margin-right: 5px;
    font-size: 18px;
    cursor: pointer;
}
.v-avatar {
    width: 45px;
    height: 45px;
}

@media (max-width: 600px) {
    .v-avatar {
        width: 35px;
        height: 35px;
    }
}

.menu-item:hover {
    color: rgb(var(--v-theme-primary));
}

.v-avatar {
    width: 45px;
    height: 45px;
    z-index: 1;
}
</style>
