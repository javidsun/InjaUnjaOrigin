<template class="main">
    <Layout>
        <template #sidebar>
            <v-list dense>
                <v-list-item v-for="(item, index) in menuItems" :key="index" :to="item.link">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>{{ translate(item.title) }}</v-list-item-title>
                </v-list-item>
            </v-list>
        </template>
        <v-container fluid class="user-profile">
            <v-row class="profile-header">
                <v-col cols="12" class="text-center">
                    <UploadAvatar/>
                    <h2 class="user-name">{{ userName }}</h2>
                    <p class="user-email">{{ userEmail }}</p>
                    <p class="tip-text">For more trust, it's better to use your real photo</p>
                </v-col>
            </v-row>

            <v-row class="profile-actions1">
                <v-col cols="5">
                    <v-btn class="profile-actions" block color="secondary" @click="editProfile">
                        {{ translate('profile.editProfile') }}
                    </v-btn>
                </v-col>
            </v-row>

            <v-row class="profile-info" justify="center">
                <v-col cols="12" sm="10" md="8">
                    <h3>{{ translate('profile.accountInfo') }}</h3>
                    <v-form v-if="isEditing" @submit.prevent="saveProfile" class="profile-info3">
                        <v-list class="profile-info3">
                            <v-list-item v-for="(item, index) in editableInfo" :key="index"
                                         class="fade-in profile-info">
                                <v-list-item-content>
                                    <v-list-item-title class="edit">
                                        {{ translate(item.label) }}:
                                        <template v-if="item.label === 'profile.passport'">
                                            <v-btn color="primary" @click="documentDialog = true">
                                                Attach
                                            </v-btn>

                                            <v-dialog v-model="documentDialog" max-width="500">
                                                <v-card>
                                                    <v-card-title>Select Document Type</v-card-title>
                                                    <v-card-actions>
                                                        <v-btn color="primary" @click="selectDocument('passport')">Passport</v-btn>
                                                        <v-btn color="primary" @click="selectDocument('license')">Driver License</v-btn>
                                                        <v-btn color="primary" @click="selectDocument('id')">ID Card</v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>

                                            <v-file-input
                                                v-if="selectedDocumentType"
                                                v-model="passportFile"
                                                :label="`Upload ${selectedDocumentType}`"
                                                accept=".jpg,.png,.pdf"
                                                outlined
                                                dense
                                                @change="previewPassport"
                                            />

                                            <v-img
                                                v-if="passportPreview"
                                                :src="passportPreview"
                                                alt="Document Preview"
                                                max-width="100"
                                                class="passport-preview"
                                            />
                                        </template>
                                        <template v-else>
                                            <v-text-field
                                                v-model="item.value"
                                                outlined
                                                dense
                                                :type="item.label === 'profile.billingEmail' ? 'email' : 'text'"
                                                :rules="getValidationRules(item.label)"
                                            />
                                        </template>
                                    </v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list>
                        <v-btn color="success" type="submit">{{ translate('profile.saveChanges') }}</v-btn>
                    </v-form>
                    <v-list v-else class="profile-info3">
                        <v-list-item v-for="(item, index) in userInfo" :key="index" class="fade-in profile-info">
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ translate(item.label) }}:
                                    <span>{{ formatDisplayValue(item) }}</span>
                                    <v-chip v-if="item.status" :color="getStatusColor(item.status)" small class="ml-2">
                                        {{ item.status }}
                                    </v-chip>
                                </v-list-item-title>
                            </v-list-item-content>
                            <v-img
                                v-if="item.label === 'profile.passport' && passportPreview"
                                :src="passportPreview"
                                alt="Passport Preview"
                                max-width="150"
                                class="passport-preview"
                            />
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>

            <v-dialog v-model="mandatoryModal" max-width="500">
                <v-card>
                    <v-card-title class="headline">Please fill in mandatory fields</v-card-title>
                    <v-card-text>
                        Please upload your passport and other required fields.
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" @click="mandatoryModal = false">OK</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
        <Footer app class="footer">...</Footer>
    </Layout>
</template>

<script>
//Todo:username/billingEmail/passport/contact/taxId/address/image

import Layout from "../Layout.vue";
import Footer from "../../layout/Footer.vue";
import UploadAvatar from "../UploadAvatar.vue";
import { translate } from "@/store/languageStore";

export default {
    components: {
        Layout,
        Footer,
        UploadAvatar
    },
    data() {
        return {

            userProfileImage: "/avatar-2.png",
            userName: "Zahra Azizi",
            userEmail: "zahra@example.com",
            passportFile: null,
            passportPreview: null,
            mandatoryModal: false,
            isEditing: false,
            documentDialog: false,
            selectedDocumentType:null,
            menuItems: [
            ],
            userInfo: [
                {label: "profile.username", value: "", status: "confirmed"},
                {label: "profile.billingEmail", value: "", status: "confirmed"},
                {label: "profile.passport", value: null, status: "not confirmed"},
                {label: "profile.contact", value: "", status: "confirmed"},
                {label: "profile.taxId", value: "", status: "confirmed"},
                {label: "profile.address", value: "", status: "Awaiting confirmation"},
            ],
            editableInfo: []
        }
    },
    mounted() {
        this.checkMandatoryFields();
        this.editableInfo = [...this.userInfo];
    },
    methods: {
        translate,

        openDocumentDialog() {
            this.documentDialog = true;
        },
        selectDocument(type) {
            this.selectedDocumentType = type;
            this.documentDialog = false;
        },
        previewPassport() {
            if (!this.passportFile) {
                this.passportPreview = null;
                return;
            }

            const file = this.passportFile instanceof File ? this.passportFile : this.passportFile[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.passportPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                this.passportPreview = null;
            }
        },

        checkMandatoryFields() {
            const requiredFields = ["profile.username", "profile.billingEmail", "profile.contact", "profile.passport"];
            const missingFields = this.userInfo.filter(item => requiredFields.includes(item.label) && !item.value);

            if (missingFields.length > 0) {
                this.mandatoryModal = true;
            }
        },
        editProfile() {
            this.isEditing = !this.isEditing;
            if (this.isEditing) {
                this.editableInfo = this.userInfo.map(item => {
                    if (item.label === "profile.passport" && item.preview) {
                        return {...item, preview: item.preview};
                    }
                    return item;
                });
            }
        },
        saveProfile() {
            const requiredFields = ["profile.username", "profile.billingEmail", "profile.contact"];
            const missingFields = this.editableInfo.filter(item => requiredFields.includes(item.label) && (!item.value || item.value === null));

            if (!this.passportFile) {
                missingFields.push({label: "profile.passport"});
            }

            if (missingFields.length > 0) {
                this.mandatoryModal = true;
                return;
            }
            this.userInfo = [...this.editableInfo];

            if (this.passportFile) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.passportPreview = e.target.result;
                };
                reader.readAsDataURL(this.passportFile);
            }

            this.isEditing = false;
        },
        getStatusColor(status) {
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
        },
        formatDisplayValue(item) {
            if (item.label === "profile.contact") {
                return item.value.replace(/(\d{4})(\d{3})(\d{4})/, "+98$1****$3");
            }
            return item.value;
        },
        getValidationRules(label) {
            if (label === "profile.username") {
                return [(v) => !!v || "Username is required"];
            }
            if (label === "profile.billingEmail") {
                return [
                    (v) => !!v || "Email is required",
                    (v) => /.+@.+\..+/.test(v) || "Invalid email format",
                ];
            }
            if (label === "profile.contact") {
                return [
                    (v) => !!v || "Contact number is required",
                    (v) => /^\d+$/.test(v) || "The contact number must be numbers only",
                    (v) => v.length === 11 || "The contact number must be 11 digits",
                ];
            }
            if (label === "profile.passport") {
                return [(v) => !!v || "Passport upload is required"];
            }
            return [];
        },


    }
}
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

.tip-text {
    color: #ff9800;
    font-style: italic;
    margin-top: 10px;
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

.passport-preview {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ccc;
}

.edit {
    max-width: 250px;
    min-width: 250px;
}
</style>
