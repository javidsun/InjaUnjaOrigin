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
            <v-badge :content="unreadNotificationsCount" color="error" overlap class="notif">
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
                                <v-icon class="mr-2">mdi-bell</v-icon>
                                {{ translate('ADMIN_NOTIFICATIONS_NOTIFICATIONS') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="6">
                                        <v-card class="pa-4">
                                            <v-card-title class="text-h6">
                                                {{ translate('ADMIN_NOTIFICATIONS_RESERVATION_STATUS') }}
                                            </v-card-title>
                                            <v-card-text>
                                                <v-select
                                                    v-model="reservationNotification.users"
                                                    :items="users"
                                                    :label="translate('ADMIN_NOTIFICATIONS_USER')"
                                                    multiple
                                                    outlined
                                                ></v-select>
                                                <v-textarea
                                                    v-model="reservationNotification.message"
                                                    :label="translate('ADMIN_NOTIFICATIONS_ALERT_MESSAGE')"
                                                    outlined
                                                ></v-textarea>
                                                <v-btn color="primary" @click="sendReservationNotification">
                                                    {{ translate('ADMIN_NOTIFICATIONS_SEND_NOTIFICATION') }}
                                                </v-btn>
                                                <v-btn color="secondary" @click="saveDraft" class="ml-2">
                                                    {{ translate('ADMIN_NOTIFICATIONS_SAVE_DRAFT') }}
                                                </v-btn>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <v-card class="pa-4">
                                            <v-card-title class="text-h6">
                                                {{ translate('ADMIN_NOTIFICATIONS_SYSTEM_ALERTS') }}
                                            </v-card-title>
                                            <v-card-text>
                                                <v-select
                                                    v-model="systemAlert.hosts"
                                                    :items="hosts"
                                                    :label="translate('ADMIN_NOTIFICATIONS_HOST')"
                                                    multiple
                                                    outlined
                                                ></v-select>
                                                <v-textarea
                                                    v-model="systemAlert.message"
                                                    :label="translate('ADMIN_NOTIFICATIONS_ALERT_MESSAGE')"
                                                    outlined
                                                ></v-textarea>
                                                <v-btn color="primary" @click="sendSystemAlert">
                                                    {{ translate('ADMIN_NOTIFICATIONS_SEND_ALERT') }}
                                                </v-btn>
                                                <v-btn color="secondary" @click="saveDraft" class="ml-2">
                                                    {{ translate('ADMIN_NOTIFICATIONS_SAVE_DRAFT') }}
                                                </v-btn>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                </v-row>

                                <v-row class="mt-4">
                                    <v-col cols="12">
                                        <v-card class="pa-4">
                                            <v-card-title class="text-h6">
                                                {{ translate('ADMIN_NOTIFICATIONS_FILTER_NOTIFICATIONS') }}
                                            </v-card-title>
                                            <v-card-text>
                                                <v-row>
                                                    <v-col cols="12" md="4">
                                                        <v-text-field
                                                            v-model="searchQuery"
                                                            :label="translate('ADMIN_NOTIFICATIONS_SEARCH_MESSAGE')"
                                                            outlined
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col cols="12" md="4">
                                                        <v-select
                                                            v-model="filterType"
                                                            :items="notificationTypes"
                                                            :label="translate('ADMIN_NOTIFICATIONS_FILTER_BY_TYPE')"
                                                            outlined
                                                        ></v-select>
                                                    </v-col>
                                                    <v-col cols="12" md="4">
                                                        <v-menu
                                                            v-model="datePickerMenu"
                                                            :close-on-content-click="false"
                                                            transition="scale-transition"
                                                            offset-y
                                                            min-width="auto"
                                                        >
                                                        </v-menu>
                                                    </v-col>
                                                </v-row>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                </v-row>

                                <v-row class="mt-4">
                                    <v-col cols="12">
                                        <v-card class="pa-4">
                                            <v-card-text>
                                                <v-tabs v-model="tab">
                                                    <v-tab>{{ translate('ADMIN_NOTIFICATIONS_ALL') }}</v-tab>
                                                    <v-tab>{{ translate('ADMIN_NOTIFICATIONS_RESERVATION') }}</v-tab>
                                                    <v-tab>{{ translate('ADMIN_NOTIFICATIONS_SYSTEM_ALERT') }}</v-tab>
                                                    <v-tab>{{ translate('ADMIN_NOTIFICATIONS_DRAFTS') }}</v-tab>
                                                </v-tabs>
                                                <v-tabs-items v-model="tab">
                                                    <v-tab-item>
                                                        <v-data-table
                                                            :headers="notificationHeaders"
                                                            :items="filteredNotifications"
                                                            hide-default-footer
                                                            class="details-table mt-4"
                                                            dense
                                                        >
                                                            <template v-slot:item.timestamp="{ item }">
                                                                {{ formatDate(item.timestamp) }}
                                                            </template>
                                                            <template v-slot:item.actions="{ item }">
                                                                <v-btn small color="primary" @click="markAsRead(item)">
                                                                    {{ translate('ADMIN_NOTIFICATIONS_MARK_AS_READ') }}
                                                                </v-btn>
                                                                <v-btn small color="error" @click="deleteNotification(item)" class="ml-2">
                                                                    {{ translate('ADMIN_NOTIFICATIONS_DELETE') }}
                                                                </v-btn>
                                                            </template>
                                                        </v-data-table>
                                                    </v-tab-item>
                                                    <v-tab-item>
                                                        <v-data-table
                                                            :headers="draftHeaders"
                                                            :items="drafts"
                                                            hide-default-footer
                                                            class="details-table mt-4"
                                                            dense
                                                        >
                                                            <template v-slot:item.actions="{ item }">
                                                                <v-btn small color="primary" @click="editDraft(item)">
                                                                    {{ translate('EDIT') }}
                                                                </v-btn>
                                                                <v-btn small color="success" @click="sendDraft(item)" class="ml-2">
                                                                    {{ translate('SEND') }}
                                                                </v-btn>
                                                                <v-btn small color="error" @click="deleteDraft(item)" class="ml-2">
                                                                    {{ translate('Delete') }}
                                                                </v-btn>
                                                            </template>
                                                        </v-data-table>
                                                    </v-tab-item>
                                                </v-tabs-items>
                                            </v-card-text>
                                        </v-card>
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
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "@/store/languageStore";

let drawer = ref(true);

const users = ref([
    "Ali Alavi",
    "Sara Ahmadi",
    "Majid Reshadat",
]);

const hosts = ref([
    "Host 1",
    "Host 2",
    "Host 3",
]);

const reservationNotification = ref({
    users: [],
    message: "",
});

const systemAlert = ref({
    hosts: [],
    message: "",
});

const sentNotifications = ref([]);

const drafts = ref([]);

const searchQuery = ref("");
const filterType = ref("all");
const dateRange = ref([]);
const datePickerMenu = ref(false);
const tab = ref(0);

const unreadNotificationsCount = computed(() => {
    return sentNotifications.value.filter(notification => !notification.read).length;
});

const notificationHeaders = ref([
    { text: translate('ADMIN_NOTIFICATIONS_RECIPIENT'), value: "recipient" },
    { text: translate('ADMIN_NOTIFICATIONS_MESSAGE'), value: "message" },
    { text: translate('ADMIN_NOTIFICATIONS_TIMESTAMP'), value: "timestamp" },
    { text: translate('ADMIN_NOTIFICATIONS_ACTIONS'), value: "actions" },
]);

const draftHeaders = ref([
    { text: translate('ADMIN_NOTIFICATIONS_TYPE'), value: "type" },
    { text: translate('ADMIN_NOTIFICATIONS_RECIPIENTS'), value: "recipients" },
    { text: translate('ADMIN_NOTIFICATIONS_MESSAGE'), value: "message" },
    { text: translate('ADMIN_NOTIFICATIONS_ACTIONS'), value: "actions" },
]);

function sendReservationNotification() {
    if (reservationNotification.value.users.length && reservationNotification.value.message) {
        reservationNotification.value.users.forEach(user => {
            const notification = {
                type: "reservation",
                recipient: user,
                message: reservationNotification.value.message,
                timestamp: new Date(),
                read: false,
            };
            sentNotifications.value.push(notification);
        });
        alert(`Notifications sent to ${reservationNotification.value.users.join(", ")}`);
        reservationNotification.value.users = [];
        reservationNotification.value.message = "";
    } else {
        alert("Please fill in all fields.");
    }
}

function sendSystemAlert() {
    if (systemAlert.value.hosts.length && systemAlert.value.message) {
        systemAlert.value.hosts.forEach(host => {
            const notification = {
                type: "system_alert",
                recipient: host,
                message: systemAlert.value.message,
                timestamp: new Date(),
                read: false,
            };
            sentNotifications.value.push(notification);
        });
        alert(`System alerts sent to ${systemAlert.value.hosts.join(", ")}`);
        systemAlert.value.hosts = [];
        systemAlert.value.message = "";
    } else {
        alert("Please fill in all fields.");
    }
}

function saveDraft() {
    if (reservationNotification.value.message || systemAlert.value.message) {
        const draft = {
            type: reservationNotification.value.users.length ? "reservation" : "system_alert",
            recipients: reservationNotification.value.users.length ? reservationNotification.value.users : systemAlert.value.hosts,
            message: reservationNotification.value.message || systemAlert.value.message,
        };
        drafts.value.push(draft);
        alert("Draft saved successfully.");
    } else {
        alert("Please fill in the message.");
    }
}

function markAsRead(notification) {
    notification.read = true;
}

function deleteNotification(notification) {
    sentNotifications.value = sentNotifications.value.filter(n => n !== notification);
}

function editDraft(draft) {
    if (draft.type === "reservation") {
        reservationNotification.value.users = draft.recipients;
        reservationNotification.value.message = draft.message;
    } else {
        systemAlert.value.hosts = draft.recipients;
        systemAlert.value.message = draft.message;
    }
    deleteDraft(draft);
}

function sendDraft(draft) {
    if (draft.type === "reservation") {
        reservationNotification.value.users = draft.recipients;
        reservationNotification.value.message = draft.message;
        sendReservationNotification();
    } else {
        systemAlert.value.hosts = draft.recipients;
        systemAlert.value.message = draft.message;
        sendSystemAlert();
    }
    deleteDraft(draft);
}

function deleteDraft(draft) {
    drafts.value = drafts.value.filter(d => d !== draft);
}

const filteredNotifications = computed(() => {
    return sentNotifications.value.filter(notification => {
        const matchesSearch = notification.message.toLowerCase().includes(searchQuery.value.toLowerCase());
        const matchesType = filterType.value === "all" || notification.type === filterType.value;
        const matchesDate = dateRange.value.length === 0 || (
            new Date(notification.timestamp) >= new Date(dateRange.value[0]) &&
            new Date(notification.timestamp) <= new Date(dateRange.value[1])
        );
        return matchesSearch && matchesType && matchesDate;
    });
});

function formatDate(date) {
    return new Intl.DateTimeFormat('en', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
    }).format(date);
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
.notif{
    margin-right: 20px;
    margin-left: 20px ;
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
</style>
