<template>
    <v-navigation-drawer
        v-model="localValue"
        expand-on-hover
        rail
        permanent
    >

        <v-list
            v-if="isUserLogged"
            nav
        >
            <template
                v-for="item in this.menuItems"
            >
                <v-list-item
                    :prepend-icon=item.icon
                    :title=item.title
                    :value="item.title"
                    @click="() => !!item.routeName ? goTo(item.routeName) : null"
                />
            </template>
        </v-list>

    </v-navigation-drawer>
</template>

<script>
import {router} from "@inertiajs/vue3";
//import userService from "@/globalServices/UserService.js";
//import UserPermissions from "@/enums/UserPermissions.js";
import apiService from "@/globalServices/apiService.js";
//import utilsFunctions from "@/globalServices/utilsFunctions.js";

export default {
    name: "AppDrawer",
    components: {},
    props: {
        value: {
            type: Boolean,
            default: false
        },
        currentInstance: {
            type: String,
            default: ''
        },
        isUserLogged: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            localValue: true,
            menuItems: [],
            appleOrAndroidConfigured: false,
        };
    },
    methods: {
        goTo(routeName) {
            router.visit(routeName);
        },
        /*async getConfigs() {
            try {
                const response = await apiService.axiosToBackend().get('api/uem/configuration/get_configs/show_welcome_page')
                if (response?.data?.success) {
                    this.appleOrAndroidConfigured = response.data.payload;

                    if (!this.appleOrAndroidConfigured && (this.user?.rolesUser[UserPermissions.CONFIGURATION] || this.user?.rolesUser[UserPermissions.DEVICE_MANAGEMENT]) ) {
                        this.menuItems.unshift(
                            {
                                title: "WELCOME",
                                routeName: "welcome",
                                icon: 'mdi-human-greeting',
                            });
                    }
                }
            } catch (e) {
                utilsFunctions.handleServerResponseException(e);
            }
        },*/
    },
    watch: {
        value(newVal) {
            this.localValue = newVal;
        }
    },
    created() {
       /* this.user = userService.getUser();
        if(this.user)
            this.getConfigs();

        this.menuItems.push(
            {
                title: "DASHBOARD",
                routeName: "dashboard",
                icon: 'mdi-gauge',
            });

        if (this.user?.rolesUser[UserPermissions.IAM]) {
            this.menuItems.push(
                {
                    title: "USERS",
                    routeName: "users",
                    icon: 'mdi-account-multiple',
                });
        }

        if (this.user?.rolesUser[UserPermissions.DEVICE_MANAGEMENT]) {
            this.menuItems.push(
                {
                    title: "DEVICES",
                    routeName: "devices",
                    icon: 'mdi-devices',
                });
        }

        this.menuItems.push(
            {
                title: "GROUPS",
                routeName: "groups",
                icon: 'mdi-rhombus-split',
            });

        if (this.user?.rolesUser[UserPermissions.PAYLOAD]) {
            this.menuItems.push(
                {
                    title: "PROFILES",
                    routeName: "profiles",
                    icon: 'mdi-card-text',
                });
        }

        this.menuItems.push(
            {
                title: "AUTOMATED_WORKFLOWS",
                routeName: "automatedWorkflows",
                icon: 'mdi-tools',
            },
            {
                title: "GEOFENCING",
                routeName: "geofence",
                icon: 'mdi-map-marker-outline',
            },
            // // TODO AFTER 30th june
            // {
            //   title: "PRIVATE_STORE",
            //   routeName: "privateStore",
            //   icon: 'mdi-storefront-outline',
            // },
            {
                title: "SUPPORT",
                routeName: "support",
                icon: 'mdi-headset',
            },
        )*/
    }
};
</script>

<style scoped lang="scss">
.v-list-item:hover {
    background-color: rgb(var(--v-theme-primary));
    color: rgb(var(--v-theme-on-primary));
}

.v-navigation-drawer--left {
    border-right: 0 !important;
}
</style>
