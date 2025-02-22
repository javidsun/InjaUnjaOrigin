<template class="main">
    <Layout>
        <template #sidebar>
            <v-list dense>
                <v-list-item v-for="(item, index) in menuItems" :key="index" :to="item.link">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ t(item.title) }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
        <v-container fluid class="user-profile">
            <v-row class="profile-header">
                <v-col cols="12" class="text-center">
                    <UploadAvatar />
                    <h2 class="user-name">{{ userName }}</h2>
                    <p class="user-email">{{ userEmail }}</p>
                </v-col>
            </v-row>

            <v-row class="profile-actions1">
                <v-col cols="5">
                    <v-btn class="profile-actions" block color="secondary" @click="editProfile">
                        {{ t('profile.editProfile') }}
                    </v-btn>
                </v-col>
            </v-row>

            <v-row class="profile-info" justify="center">
                <v-col cols="12" sm="10" md="8">
                    <h3>{{ t('profile.accountInfo') }}</h3>
                    <v-form v-if="isEditing" @submit.prevent="saveProfile" class="profile-info3">
                        <v-list class="profile-info3">
                            <v-list-item v-for="(item, index) in editableInfo" :key="index" class="fade-in profile-info">
                                <v-list-item-content>
                                    <v-list-item-title>
                                        {{ t(item.label) }}:
                                        <v-text-field
                                            v-model="item.value"
                                            outlined
                                            dense
                                            :style="{ minWidth: '500px' }"
                                            :rules="getValidationRules(item.label)"
                                        />
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                        <v-btn color="success" type="submit" class="btn_success">{{ t('profile.saveChanges') }}</v-btn>
                    </v-form>

                    <v-list v-else class="profile-info3">
                        <v-list-item v-for="(item, index) in userInfo" :key="index" class="fade-in profile-info">
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ t(item.label) }}: <span>{{ formatDisplayValue(item) }}</span>
                                    <v-chip v-if="item.status" :color="getStatusColor(item.status)" small class="ml-2">
                                        {{ item.status }}
                                    </v-chip>
                                </v-list-item-title>
                                <v-list-item-subtitle v-if="(item.label === 'profile.contact' || item.label === 'profile.emergencyContact') && item.status === 'تاییده شده'" class="text-caption">
                                    A verified contact number is required to contact the host, guest and InjaOnja                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action v-if="item.status === 'not confirmed'">
                                <v-icon @click="showRejectionReason('Reason for rejection')">mdi-alert-circle</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>

            <v-dialog v-model="rejectionModal" max-width="500">
                <v-card>
                    <v-card-title class="headline">Reason for rejection</v-card-title>
                    <v-card-text>
                        {{ rejectionReason }}
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" @click="rejectionModal = false">Close</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
        <Footer app class="footer">...</Footer>
    </Layout>
</template>


<script setup>
import { ref } from "vue";
import Layout from "../Layout.vue";
import Footer from "../../layout/Footer.vue";
import { t } from "../../../store/languageStore";
import UploadAvatar from "../UploadAvatar.vue";

const userProfileImage = ref("/avatar-2.png");
const userName = ref("Zahra Azizi");
const userEmail = ref("zahra@example.com");

const userInfo = ref([
    { label: "profile.username", value: "@zahra", icon: "mdi-account", status: "confirmed" },
    { label: "profile.billingEmail", value: "ar****y@yahoo.com", icon: "mdi-email", status: "confirmed" },
    { label: "profile.status", value: "Active", icon: "mdi-check-circle", status: "confirmed" },
    { label: "profile.role", value: "User", icon: "mdi-account-tie", status: "confirmed" },
    { label: "profile.taxId", value: "123-456", icon: "mdi-numeric", status: "confirmed" },
    { label: "profile.contact", value: "+989045123457", icon: "mdi-phone", status: "confirmed" },
    { label: "profile.language", value: "English", icon: "mdi-translate", status: "confirmed" },
    { label: "profile.country", value: "iRAN", icon: "mdi-map-marker", status: "confirmed" },
    { label: "profile.address", value: "تهران، خیابان آزادی", icon: "mdi-map-marker", status: "Awaiting confirmation" },
    { label: "profile.emergencyContact", value: "+989045123458", icon: "mdi-phone", status: "Awaiting confirmation" },
    { label: "profile.idCard", value: "1234567890", icon: "mdi-card-account-details", status: "not confirmed" },
]);

const editableInfo = ref([...userInfo.value]);

const isEditing = ref(false);
const rejectionModal = ref(false);
const rejectionReason = ref("");

const editProfile = () => {
    isEditing.value = !isEditing.value;
};

const saveProfile = () => {
    editableInfo.value.forEach(item => {
        if (item.value !== userInfo.value.find(i => i.label === item.label)?.value) {
            item.status = "Awaiting confirmation";
        }
    });
    userInfo.value = [...editableInfo.value];
    isEditing.value = false;
};

const getStatusColor = (status) => {
    switch (status) {
        case "confirmed":
            return "green";
        case "Awaiting confirmation":
            return "yellow";
        case "not confirmed":
            return "red";
        default:
            return "grey";
    }
};

const showRejectionReason = (reason) => {
    rejectionReason.value = reason;
    rejectionModal.value = true;
};

const formatDisplayValue = (item) => {
    if (item.label === "profile.contact" || item.label === "profile.emergencyContact") {
        return item.value.replace(/(\d{4})(\d{3})(\d{4})/, "+98$1****$3");
    }
    if (item.label === "profile.email") {
        return item.value.replace(/(.{1})(.*)(@.*)/, "$1****$3");
    }
    return item.value;
};

const getValidationRules = (label) => {
    if (label === "profile.contact" || label === "profile.emergencyContact") {
        return [
            (v) => /^\d+$/.test(v) || "The contact number must be numbers only",
            (v) => v.length === 11 || "The contact number must be 11 digits",
        ];
    }
    if (label === "profile.email") {
        return [
            (v) => /.+@.+\..+/.test(v) || "The email is not valid",
        ];
    }
    return [];
};
</script>

<style scoped>
.main {
    background: var(--liner-background);
}

.user-profile {
    background: var(--liner-background);
    padding: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    animation: fadeIn 1.5s ease-in-out;
}

.profile-header {
    margin-bottom: 20px;
}

.profile-avatar img {
    border-radius: 50%;
    border: 4px solid #fff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s;
}

.profile-avatar img:hover {
    transform: scale(1.1);
}

.user-name {
    font-weight: bold;
    margin: 10px 0;
    font-size: 24px;
    color: #fff;
}

.user-email {
    color: rgba(255, 255, 255, 0.8);
    font-style: italic;
}

.profile-actions1 {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
    width: 70%;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .profile-actions {
        font-size: 14px !important;
        font-family: "2 Baran", serif;
    }
    .profile-info .v-text-field {
        min-width: 100%;
    }
}
@media (max-width: 320px) {
    .profile-actions {
        font-size: 10px !important;
        font-family: "2 Baran", serif;
    }
}

.profile-actions {
    font-family: "2 Baran", serif;
    font-size: 22px;
    height: 70px;
    border-radius: 10px;
    transition: background-color 0.3s, transform 0.3s;
    justify-content: center;
}

.profile-actions:hover {
    background-color: #ffffff !important;
    color: #0101ac !important;
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.profile-info {
    font-weight: bold;
    color: var(--text-color);
    text-align: center;
    background: var(--sidebar-background-color);
    border-radius: 15px;
    padding: 20px;
    border: 2px solid #ffffff;
    width: 70%;
    margin: 0 auto;
}

.profile-info h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: var(--text-color);
}

.profile-info .v-list-item {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin-bottom: 15px;
    padding: 10px;
    background: var(--backgroundcards-color--profile);
    border-radius: 8px;
    transition: background-color 0.3s ease;
    border: 1px solid #ccc;
}

.profile-info .v-list-item-icon {
    margin-right: 10px;
    color: #af4261;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
}

.profile-info .v-list-item-title {
    font-size: 14px;
    color: var(--text-color);
    text-align: left;
    display: flex;
    align-items: center;
}

.profile-info .v-list-item-title span {
    margin-left: 10px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 1s ease-in-out;
}

.profile-info3 {
    background-color: var(--sidebar-background-color);
}

.btn_success {
    max-width: 10% !important;
}
</style>
