<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
                </div>
            </v-col>
            <v-spacer />
            <v-spacer />
            <Darkmood class="darkmood"/>
            <LanguageSwitcher class="language" />
        </v-app-bar>

        <Sidebar app v-model="drawer" :temporary="isMobile" />

        <v-main :class="{ 'main-expanded': drawer && !isMobile, 'main-collapsed': !drawer }">
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-2 rounded-lg border1">
                            <v-card-title class="text-h5 primary--text">
                                <v-icon class="mr-2">mdi-account-multiple</v-icon>
                                {{ translate('Admin_UserManagment.user_management') }}
                            </v-card-title>
                            <v-card-subtitle class="text-body2">
                                {{ translate('Admin_UserManagment.user_list_and_roles') }}
                            </v-card-subtitle>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-2 rounded-lg border1">
                            <v-card-title>
                                <v-btn color="primary" @click="openUserDialog" elevation="2" rounded>
                                    {{ translate('Admin_UserManagment.add_new_user') }}
                                </v-btn>
                            </v-card-title>
                            <v-data-table
                                :headers="userHeaders"
                                :items="users"
                                item-key="id"
                                disable-pagination
                                class="elevation-1"
                            >
                                <template v-slot:item.actions="{ item }">
                                    <v-btn icon @click="toggleUserStatus(item)">
                                        <v-icon>{{ item.active ? 'mdi-check-circle' : 'mdi-cancel' }}</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="editUserRole(item)">
                                        <v-icon>mdi-account-edit</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="viewUserHistory(item)">
                                        <v-icon>mdi-history</v-icon>
                                    </v-btn>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-col>
                </v-row>

                <v-dialog v-model="userDialog" max-width="600px">
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline text-center">
                            {{ editingUser ? translate('Admin_UserManagment.edit_user') : translate('Admin_UserManagment.add_new_user') }}
                        </v-card-title>
                        <v-card-text>
                            <v-form ref="form" v-model="valid">
                                <v-text-field v-model="userForm.name" :label="translate('Admin_UserManagment.user_name')" :rules="[rules.required]" outlined dense />
                                <v-text-field v-model="userForm.email" :label="translate('Admin_UserManagment.user_email')" :rules="[rules.required, rules.email]" outlined dense />
                                <v-select
                                    v-model="userForm.role"
                                    :items="roles"
                                    :label="translate('Admin_UserManagment.user_role')"
                                    :rules="[rules.required]"
                                    outlined dense
                                />
                                <v-switch v-model="userForm.active" :label="translate('Admin_UserManagment.user_active')" color="primary" />
                            </v-form>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn @click="userDialog = false" color="grey" outlined rounded>
                                {{ translate('Admin_UserManagment.close') }}
                            </v-btn>
                            <v-btn @click="saveUser" color="primary" :disabled="!valid" rounded>
                                {{ translate('Admin_UserManagment.save') }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="historyDialog" max-width="800px">
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline">
                            {{ translate('Admin_UserManagment.activity_history') }} {{ selectedUser.name }}
                        </v-card-title>
                        <v-card-text>
                            <v-data-table
                                :headers="activityHeaders"
                                :items="userActivities"
                                item-key="id"
                                disable-pagination
                                class="elevation-1"
                            >
                                <template v-slot:item.status="{ item }">
                                    <v-chip :color="item.status === translate('Admin_UserManagment.statuses.completed') ? 'green' : 'red'" dark outlined>
                                        {{ item.status }}
                                    </v-chip>
                                </template>
                            </v-data-table>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn @click="historyDialog = false" color="grey" outlined rounded>
                                {{ translate('Admin_UserManagment.close') }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
//Todo:id/name/email/role/active/created_at/updated_at
//Todo:create_user & update_user : description/name/email/role/active

import Sidebar from "../Sidebar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "@/store/languageStore";

export default {
    components: {
        Sidebar,
        Darkmood,
        LanguageSwitcher
    },

    data() {
        return {
            isDarkMode: true,
            drawer: true,
            userDialog: false,
            historyDialog: false,
            editingUser: false,
            valid: false,
            selectedUser: { name: '' },

            users: [
                { id: 1, name: 'Ali Reza', email: 'ali@example.com', role: 'Normal User', active: true },
                { id: 2, name: 'Fatemeh', email: 'fatemeh@example.com', role: 'Host', active: false },
            ],

            userForm: {
                name: '',
                email: '',
                role: '',
                active: false
            },

            userHeaders: [
                { text: translate('Admin_UserManagment.user_name'), align: 'start', key: 'name', sortable: true },
                { text: translate('Admin_UserManagment.user_email'), key: 'email' },
                { text: translate('Admin_UserManagment.user_role'), key: 'role' },
                { text: translate('Admin_UserManagment.user_active'), key: 'active' },
                { text: translate('Admin_UserManagment.actions'), key: 'actions', sortable: false }
            ],

            activityHeaders: [
                { text: translate('Admin_UserManagment.activity'), align: 'start', key: 'activity' },
                { text: translate('Admin_UserManagment.date'), key: 'date' },
                { text: translate('Admin_UserManagment.status'), key: 'status' }
            ],

            rules: {
                required: value => !!value || translate('Admin_UserManagment.validation.required'),
                email: value => /.+@.+\..+/.test(value) || translate('Admin_UserManagment.validation.invalid_email')
            }
        };
    },

    computed: {
        isMobile() {
            return window.innerWidth <= 600;
        },

        roles() {
            return ['Normal User', 'Host', 'Admin'];
        },

        userActivities() {
            return [
                { id: 1, activity: translate('Admin_UserManagment.activities.house_reservation'), date: '2025-03-10', status: translate('Admin_UserManagment.statuses.completed') },
                { id: 2, activity: translate('Admin_UserManagment.activities.payment'), date: '2025-03-09', status: translate('Admin_UserManagment.statuses.pending') },
                { id: 3, activity: translate('Admin_UserManagment.activities.comment'), date: '2025-03-08', status: translate('Admin_UserManagment.statuses.completed') }
            ];
        }
    },

    methods: {
        translate,
        toggleUserStatus(user) {
            try {
                const userIndex = this.users.findIndex(u => u.id === user.id);
                if (userIndex !== -1) {
                    this.users[userIndex].active = !this.users[userIndex].active;
                    this.showSuccessMessage(translate('Admin_UserManagment.status_updated'));
                }
            } catch (error) {
                this.showErrorMessage(translate('Admin_UserManagment.status_update_failed'));
            }
        },

        openUserDialog() {
            this.userForm = { name: '', email: '', role: '', active: false };
            this.editingUser = false;
            this.userDialog = true;
        },

        saveUser() {
            try {
                if (!this.valid) return;

                if (this.editingUser) {
                    const userIndex = this.users.findIndex(u => u.id === this.userForm.id);
                    if (userIndex !== -1) {
                        this.users[userIndex] = { ...this.userForm };
                        this.showSuccessMessage(translate('Admin_UserManagment.user_updated'));
                    }
                } else {
                    const newUser = {
                        ...this.userForm,
                        id: this.users.length > 0 ? Math.max(...this.users.map(u => u.id)) + 1 : 1
                    };
                    this.users.push(newUser);
                    this.showSuccessMessage(translate('Admin_UserManagment.user_added'));
                }

                this.userDialog = false;
            } catch (error) {
                this.showErrorMessage(translate('Admin_UserManagment.save_failed'));
            }
        },

        editUserRole(user) {
            try {
                this.userForm = { ...user };
                this.editingUser = true;
                this.userDialog = true;
            } catch (error) {
                this.showErrorMessage(translate('Admin_UserManagment.edit_failed'));
            }
        },

        viewUserHistory(user) {
            try {
                this.selectedUser = user;
                this.historyDialog = true;
            } catch (error) {
                this.showErrorMessage(translate('Admin_UserManagment.history_load_failed'));
            }
        },

        showSuccessMessage(message) {
            this.$root.$emit('show-alert', {
                type: 'success',
                message: message
            });
        },

        showErrorMessage(message) {
            this.$root.$emit('show-alert', {
                type: 'error',
                message: message
            });
        },

        toggleDarkMode() {
            this.isDarkMode = !this.isDarkMode;
        }
    }
};
</script>

<style scoped>
/* Styles remain the same as original */
.v-data-table th {
    background-color: #f0f0f0;
    font-weight: bold;
    color: #333;
}

.v-data-table td {
    text-align: center;
    padding: 12px;
}

.v-btn {
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
}

.v-card {
    border-radius: 12px;
}

.v-chip {
    font-weight: bold;
}
.language {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}
.darkmood {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}

* {
    box-sizing: border-box;
}
body {
    overflow-x: hidden;
}

.footer {
    background-color: var(--background-color);
}
.language{
    margin-right: 80px!important;
}
.darkmood{
    margin-right: 20px!important;
}

@media (max-width: 600px) {
    .main {
        margin-bottom: 100px;
    }
    .border1{
        margin-left: 0;
    }

}
@media (max-width: 960px) {
    .main {
        margin-bottom: 70px;
    }
}

v-container {
    max-width: 100%;
    padding: 0;
}

.logo-container {
    display: flex;
    align-items: center;
    overflow: visible;
    filter: brightness(var(--logo-brightness, 1));
}
.logo-image {
    width: 60px;
}
.header {
    z-index: 1000;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: var(--background-color);
}

.border1{
    margin-left: 20px;
}
.main-expanded {
    padding-left: 240px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
    padding-top: 64px;
}

.main-collapsed {
    padding-left: 80px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
}

@media (max-width: 600px) {
    .main {
        padding-left: 0;
        margin-left: 0;
        margin-bottom: 100px;
    }
    .v-app-bar {
        position: fixed;
    }
    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .logo-image {
        width: 50px;
    }
}
</style>
