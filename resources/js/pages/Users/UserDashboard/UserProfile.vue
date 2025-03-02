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
                    <UploadAvatar />

                    <h2 class="user-name">{{ userName }}</h2>
                    <p class="user-email">{{ userEmail }}</p>
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

                            <v-list-item v-for="(item, index) in editableInfo" :key="index" class="fade-in profile-info">
                                <v-list-item-content>
                                    <v-list-item-title class="edit">
                                        {{ translate(item.label) }}:
                                        <template v-if="item.label === 'profile.passport'">
                                            <v-file-input
                                                v-model="passportFile"
                                                accept=".jpg,.png,.pdf"
                                                label="Upload Passport"
                                                outlined
                                                dense
                                                :rules="getValidationRules('profile.passport')"
                                                @change="previewPassport"
                                            />
                                            <v-img
                                                v-if="item.preview"
                                                :src="item.preview"
                                                alt="Passport Preview"
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
                        <v-btn color="success" type="submit" >{{ translate('profile.saveChanges') }}</v-btn>
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

<script setup>
import { ref , onMounted } from "vue";
import Layout from "../Layout.vue";
import Footer from "../../layout/Footer.vue";
import { translate } from "../../../store/languageStore";
import UploadAvatar from "../UploadAvatar.vue";

const userProfileImage = ref("/avatar-2.png");
const userName = ref("Zahra Azizi");
const userEmail = ref("zahra@example.com");

const userInfo = ref([
    { label: "profile.username", value: "", icon: "mdi-account", status: "confirmed" },
    { label: "profile.billingEmail", value: "", icon: "mdi-email", status: "confirmed" },
    { label: "profile.passport", value: null, icon: "mdi-card-account-details", status: "not confirmed" },
    { label: "profile.contact", value: "", icon: "mdi-phone", status: "confirmed" },
    { label: "profile.taxId", value: "", icon: "mdi-numeric", status: "confirmed" },
    { label: "profile.language", value: "", icon: "mdi-translate", status: "confirmed" },
    { label: "profile.country", value: "", icon: "mdi-map-marker", status: "confirmed" },
    { label: "profile.address", value: "", icon: "mdi-map-marker", status: "Awaiting confirmation" },
    { label: "profile.emergencyContact", value: "", icon: "mdi-phone", status: "Awaiting confirmation" },
    { label: "profile.idCard", value: "", icon: "mdi-card-account-details", status: "not confirmed" },
]);

const passportFile = ref(null);
const passportPreview = ref(null);
const mandatoryModal = ref(false);

onMounted(() => {
    checkMandatoryFields();
});

const checkMandatoryFields = () => {
    const requiredFields = ["profile.username", "profile.billingEmail", "profile.contact", "profile.passport"];
    const missingFields = userInfo.value.filter(item => requiredFields.includes(item.label) && !item.value);

    if (missingFields.length > 0) {
        mandatoryModal.value = true;
    }
};
const previewProfileImage = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            userProfileImage.value = e.target.result;
        };
        reader.readAsDataURL(file);
    }
};

const previewPassport = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            passportPreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        passportPreview.value = null;
    }
};

const editableInfo = ref([...userInfo.value]);

const isEditing = ref(false);

const editProfile = () => {
    isEditing.value = !isEditing.value;
    if (isEditing.value) {
        editableInfo.value = userInfo.value.map(item => {
            if (item.label === "profile.passport" && item.preview) {
                return { ...item, preview: item.preview };
            }
            return item;
        });
    }
};
const saveProfile = () => {
    const requiredFields = ["profile.username", "profile.billingEmail", "profile.contact"];
    const missingFields = editableInfo.value.filter(item => requiredFields.includes(item.label) && (!item.value || item.value === null));

    if (!passportFile.value) {
        missingFields.push({ label: "profile.passport" });
    }

    if (missingFields.length > 0) {
        mandatoryModal.value = true;
        return;
    }
    userInfo.value = [...editableInfo.value];

    if (passportFile.value) {
        const reader = new FileReader();
        reader.onload = (e) => {
            passportPreview.value = e.target.result;
        };
        reader.readAsDataURL(passportFile.value);
    }

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

const formatDisplayValue = (item) => {
    if (item.label === "profile.contact" || item.label === "profile.emergencyContact") {
        return item.value.replace(/(\d{4})(\d{3})(\d{4})/, "+98$1****$3");
    }
    return item.value;
};

const getValidationRules = (label) => {
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
.passport-preview {
    max-width: 100px;
    max-height: 100px;
    object-fit: cover;
    border-radius: 5px;
    border: 1px solid #ccc;
}
.edit{
    max-width: 250px;
    min-width: 250px;
}
</style>
