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
            <Darkmood class="darkmood" />
            <LanguageSwitcher class="language" />
            <v-badge :content="unreadMessagesCount" color="error" overlap class="notif">
                <v-icon>mdi-bell</v-icon>
            </v-badge>
        </v-app-bar>

        <Sidebar app v-model="drawer" />

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid class="main1">
                <v-row class="mt-4">
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg pa-4">
                            <v-card-title class="text-h5 primary--text sizem">
                                <v-icon class="mr-2">mdi-headset</v-icon>
                                {{ translate('ADMIN_SUPPORT_SUPPORT_MESSAGES') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="searchQuery"
                                            :label="translate('ADMIN_SUPPORT_SEARCH_MESSAGES')"
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-select
                                            v-model="filterStatus"
                                            :items="statusOptions"
                                            item-title="text"
                                            item-value="value"
                                            :label="translate('ADMIN_SUPPORT_FILTER_BY_STATUS')"
                                            outlined
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-btn color="primary" @click="toggleMessageForm">
                                            {{ translate('ADMIN_SUPPORT_NEW_MESSAGE') }}
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-row v-if="showMessageForm">
                                    <v-col cols="12" md="8">
                                        <v-select
                                            v-model="selectedUser"
                                            :items="users"
                                            :label="translate('ADMIN_SUPPORT_SELECT_USER')"
                                            outlined
                                        ></v-select>
                                        <v-textarea
                                            v-model="newMessage"
                                            :label="translate('ADMIN_SUPPORT_YOUR_MESSAGE')"
                                            outlined
                                            rows="4"
                                            auto-grow
                                        ></v-textarea>
                                        <v-btn @click="sendMessage" color="success">
                                            {{ translate('ADMIN_SUPPORT_SEND_MESSAGE') }}
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-row class="mt-6">
                                    <v-col cols="12">
                                        <v-data-table
                                            :headers="messageHeaders"
                                            :items="filteredMessages"
                                            hide-default-footer
                                            class="details-table mt-4"
                                            dense
                                        >
                                            <template v-slot:item.status="{ item }">
                                                <v-chip :color="getStatusColor(item.status)" small>
                                                    {{ item.status }}
                                                </v-chip>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <v-btn small color="primary" @click="replyToMessage(item)">
                                                    {{ translate('ADMIN_SUPPORT_REPLY') }}
                                                </v-btn>
                                                <v-btn small color="success" @click="markAsResolved(item)" class="ml-2">
                                                    {{ translate('ADMIN_SUPPORT_MARK_RESOLVED') }}
                                                </v-btn>
                                                <v-btn small color="error" @click="deleteMessage(item)" class="ml-2">
                                                    {{ translate('Delete') }}
                                                </v-btn>
                                            </template>
                                        </v-data-table>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
//Todo:{messages:id/sender/recipient/date/content/status/created_at/updated_at}
//Todo:{users:id/name/recipient/email/role}
//Todo:{get_messages:id/name/recipient/email/role}

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
            drawer: true,
            isDarkMode: false,
            users: [
                "Ali Alavi",
                "Sara Ahmadi",
                "Majid Reshadat",
            ],
            messages: [
                { sender: "Ali Alavi", date: "2025-03-13", content: "I need help with my account.", status: "unresolved" },
                { sender: "Sara Ahmadi", date: "2025-03-12", content: "How can I reset my password?", status: "resolved" },
            ],
            showMessageForm: false,
            selectedUser: "",
            newMessage: "",
            searchQuery: "",
            filterStatus: "all",
            statusOptions: [
                { text: translate('All'), value: "all" },
                { text: translate('Resolved'), value: "resolved" },
                { text: translate('Unresolved'), value: "unresolved" },
            ],
            messageHeaders: [
                { text: translate('MESSAGE_SENDER'), value: "sender" },
                { text: translate('ADMIN_SUPPORT_DATE'), value: "date" },
                { text: translate('ADMIN_SUPPORT_CONTENT'), value: "content" },
                { text: translate('ADMIN_SUPPORT_STATUS'), value: "status" },
                { text: translate('ADMIN_SUPPORT_ACTIONS'), value: "actions" },
            ]
        }
    },
    computed: {
        unreadMessagesCount() {
            try {
                return this.messages.filter(message => message.status === "unresolved").length;
            } catch (error) {
                this.showError("Failed to count unread messages", error);
                return 0;
            }
        },
        filteredMessages() {
            try {
                return this.messages.filter(message => {
                    const matchesSearch = message.content.toLowerCase().includes(this.searchQuery.toLowerCase());
                    const matchesStatus = this.filterStatus === "all" || message.status === this.filterStatus;
                    return matchesSearch && matchesStatus;
                });
            } catch (error) {
                this.showError("Failed to filter messages", error);
                return [];
            }
        }
    },
    methods: {
        translate,

        toggleMessageForm() {
            this.showMessageForm = !this.showMessageForm;
        },
        async sendMessage() {
            try {
                if (!this.selectedUser || this.newMessage.trim() === "") {
                    this.showWarning("Please fill in all fields.");
                    return;
                }

                const newMsg = {
                    sender: "Admin",
                    recipient: this.selectedUser,
                    date: new Date().toISOString().split("T")[0],
                    content: this.newMessage,
                    status: "unresolved",
                };
                this.messages.push(newMsg);
                this.selectedUser = "";
                this.newMessage = "";
                this.showMessageForm = false;
                this.showSuccess("Message sent successfully!");
            } catch (error) {
                this.showError("Failed to send message", error);
            }
        },
        replyToMessage(message) {
            try {
                this.selectedUser = message.sender;
                this.showMessageForm = true;
            } catch (error) {
                this.showError("Failed to reply to message", error);
            }
        },
        async markAsResolved(message) {
            try {
                message.status = "resolved";
                this.showSuccess("Message marked as resolved!");
            } catch (error) {
                this.showError("Failed to mark message as resolved", error);
            }
        },
        async deleteMessage(message) {
            try {
                this.messages = this.messages.filter(m => m !== message);
                this.showSuccess("Message deleted successfully!");
            } catch (error) {
                this.showError("Failed to delete message", error);
            }
        },
        getStatusColor(status) {
            try {
                switch (status) {
                    case "resolved":
                        return "success";
                    case "unresolved":
                        return "error";
                    default:
                        return "primary";
                }
            } catch (error) {
                this.showError("Failed to get status color", error);
                return "primary";
            }
        },
        showSuccess(message) {
            this.$emit('show-alert', {
                type: 'success',
                message: message,
                show: true
            });
        },
        showWarning(message) {
            this.$emit('show-alert', {
                type: 'warning',
                message: message,
                show: true
            });
        },
        showError(message, error) {
            console.error(message, error);
            this.$emit('show-alert', {
                type: 'error',
                message: `${message}: ${error?.message || 'Unknown error'}`,
                show: true
            });
        }
    }
}
</script>

<style scoped>
.info-card.success {
    background: #d4edda;
    color: #155724;
}

.info-card.warning {
    background: #fff3cd;
    color: #856404;
}

.info-card.error {
    background: #f8d7da;
    color: #721c24;
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

.v-btn {
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
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
    .main-expanded,
    .main-collapsed {
        padding-left: 0;
    }
}
.notif{
    margin-right: 20px;
    margin-left: 20px;
}
</style>
