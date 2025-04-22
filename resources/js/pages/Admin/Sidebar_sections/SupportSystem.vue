<!--فایل  SupportSystem.js در services      فایل   SupportSystem.json در پوشه docs -->

<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
                </div>
            </v-col>
            <v-spacer />
            <Searchbar />
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
                                {{ translate('Admin_Support.support_messages') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="searchQuery"
                                            :label="translate('Admin_Support.search_messages')"
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-select
                                            v-model="filterStatus"
                                            :items="statusOptions"
                                            item-title="text"
                                            item-value="value"
                                            :label="translate('Admin_Support.filter_by_status')"
                                            outlined
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-btn color="primary" @click="toggleMessageForm">
                                            {{ translate('Admin_Support.new_message') }}
                                        </v-btn>
                                    </v-col>
                                </v-row>

                                <v-row v-if="showMessageForm">
                                    <v-col cols="12" md="8">
                                        <v-select
                                            v-model="selectedUser"
                                            :items="users"
                                            :label="translate('Admin_Support.select_user')"
                                            outlined
                                        ></v-select>
                                        <v-textarea
                                            v-model="newMessage"
                                            :label="translate('Admin_Support.your_message')"
                                            outlined
                                            rows="4"
                                            auto-grow
                                        ></v-textarea>
                                        <v-btn @click="sendMessage" color="success">
                                            {{ translate('Admin_Support.send_message') }}
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
                                                    {{ translate('Admin_Support.reply') }}
                                                </v-btn>
                                                <v-btn small color="success" @click="markAsResolved(item)" class="ml-2">
                                                    {{ translate('Admin_Support.mark_resolved') }}
                                                </v-btn>
                                                <v-btn small color="error" @click="deleteMessage(item)" class="ml-2">
                                                    {{ translate('Admin_Support.delete') }}
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

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import { ref, computed } from 'vue';
import Sidebar from "../Sidebar.vue";
import Searchbar from "../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "@/store/languageStore.js";

const drawer = ref(true);

const users = ref([
    "Ali Alavi",
    "Sara Ahmadi",
    "Majid Reshadat",
]);

const messages = ref([
    { sender: "Ali Alavi", date: "2025-03-13", content: "I need help with my account.", status: "unresolved" },
    { sender: "Sara Ahmadi", date: "2025-03-12", content: "How can I reset my password?", status: "resolved" },
]);

const showMessageForm = ref(false);
const selectedUser = ref("");
const newMessage = ref("");

const searchQuery = ref("");
const filterStatus = ref("all");

const statusOptions = ref([
    { text: translate('All'), value: "all" },
    { text: translate('Resolved'), value: "resolved" },
    { text: translate('Unresolved'), value: "unresolved" },
]);

const messageHeaders = ref([
    { text: translate('Admin_Support.sender'), value: "sender" },
    { text: translate('Admin_Support.date'), value: "date" },
    { text: translate('Admin_Support.content'), value: "content" },
    { text: translate('Admin_Support.status'), value: "status" },
    { text: translate('Admin_Support.actions'), value: "actions" },
]);

const unreadMessagesCount = computed(() => {
    return messages.value.filter(message => message.status === "unresolved").length;
});

function toggleMessageForm() {
    showMessageForm.value = !showMessageForm.value;
}

function sendMessage() {
    if (selectedUser.value && newMessage.value.trim() !== "") {
        const newMsg = {
            sender: "Admin",
            recipient: selectedUser.value,
            date: new Date().toISOString().split("T")[0],
            content: newMessage.value,
            status: "unresolved",
        };
        messages.value.push(newMsg);
        selectedUser.value = "";
        newMessage.value = "";
        showMessageForm.value = false;
    } else {
        alert("Please fill in all fields.");
    }
}

function replyToMessage(message) {
    selectedUser.value = message.sender;
    showMessageForm.value = true;
}

function markAsResolved(message) {
    message.status = "resolved";
}

function deleteMessage(message) {
    messages.value = messages.value.filter(m => m !== message);
}

const filteredMessages = computed(() => {
    return messages.value.filter(message => {
        const matchesSearch = message.content.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesStatus = filterStatus.value === "all" || message.status === filterStatus.value;
        return matchesSearch && matchesStatus;
    });
});

function getStatusColor(status) {
    switch (status) {
        case "resolved":
            return "success";
        case "unresolved":
            return "error";
        default:
            return "primary";
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
