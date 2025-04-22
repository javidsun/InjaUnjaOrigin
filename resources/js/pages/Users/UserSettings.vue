<!--فایل  UserSettings.js در services      فایل   UserSettings.json در پوشه docs -->


<template>
    <UserSidebar>
        <v-card class="settings-container">
            <v-list>
                <v-list-item @click="goToPage('/UserProfile')" class="profile-section list-item">
                    <v-avatar size="50" class="avatar">
                        <img :src="userProfileImage" alt="Profile Picture"/>
                    </v-avatar>
                    <div class="text-content">
                        <v-list-item-title class="user-name">{{ userName }}</v-list-item-title>
                        <v-list-item-subtitle class="profile-link">{{ translate('setting.showProfile') }}
                        </v-list-item-subtitle>
                    </div>
                </v-list-item>
                <v-divider></v-divider>

                <v-list-subheader class="text1 list-item">{{ translate('setting.settings') }}</v-list-subheader>
                <template v-for="(item, index) in settingsItems" :key="index">
                    <v-list-item @click="handleSettingClick(item.link)" class="list-item">
                        <v-icon class="icon">{{ item.icon }}</v-icon>
                        <span class="text">{{ translate(item.title) }}</span>
                    </v-list-item>
                    <v-divider></v-divider>
                </template>
                <v-list-subheader class="text1 list-item">{{ translate('setting.host') }}</v-list-subheader>
                <v-list-item @click="handleSettingClick('/Guide')" class="list-item">
                    <v-list-item class="text">
                        <v-icon>mdi-book</v-icon>
                        <v-list-item-title>{{ translate('setting.guide') }}</v-list-item-title>
                    </v-list-item>
                </v-list-item>
                <v-divider></v-divider>

                <v-list-subheader class="text1 list-item">{{ translate('setting.referrals') }}</v-list-subheader>
                <template v-for="(item, index) in referralItems" :key="index">
                    <v-list-item @click="handleSettingClick(item.link)" class="list-item">
                        <v-icon class="icon">{{ item.icon }}</v-icon>
                        <span class="text">{{ translate(item.title) }}</span>
                    </v-list-item>
                </template>
                <v-divider></v-divider>

                <v-list-subheader class="text1 list-item">{{ translate('setting.support') }}</v-list-subheader>
                <template v-for="(item, index) in supportItems" :key="index">
                    <v-list-item @click="handleSettingClick(item.link)" class="list-item">
                        <v-icon class="icon">{{ item.icon }}</v-icon>
                        <span class="text">{{ translate(item.title) }}</span>
                    </v-list-item>
                </template>
                <v-divider></v-divider>

                <v-list-subheader class="text1 list-item">{{ translate('setting.policies') }}</v-list-subheader>
                <template v-for="(item, index) in policyItems" :key="index">
                    <v-list-item @click="handleSettingClick(item.link)" class="list-item">
                        <v-icon class="icon">{{ item.icon }}</v-icon>
                        <span class="text">{{ translate(item.title) }}</span>
                    </v-list-item>
                </template>
                <v-divider></v-divider>
                <v-list-item @click="goToPage('/login')" class="logout list-item">
                    <v-icon class="icon">mdi-logout</v-icon>
                    <span class="text">{{ translate('setting.logout') }}</span>
                </v-list-item>

            </v-list>
        </v-card>
        <SettingModal ref="settingModal"/>
        <SecurityModal ref="securityModal"/>
        <PaymentsModal ref="paymentsModal"/>
        <AccessModal ref="accessModal"/>
        <CurrencyModal ref="currencyModal"/>
        <NotificationsModals ref="notificationsModals"/>
        <PrivacySharing ref="privacysharing"/>
        <Guide ref="guide"/>
        <GiftModal ref="giftModal"/>
        <Suggestfriend ref="suggestfriend"/>
        <SupportModal ref="supportModal"/>
        <ReportModal ref="reportModal"/>
        <HowItWorksModal ref="howItWorksModal"/>
        <FeedbackModal ref="feedbackModal"/>
        <Terms ref="terms"/>
        <Policy ref="policy"/>


    </UserSidebar>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import UserSidebar from './Layout.vue';
import SettingModal from './SettingModals/SettingModal.vue';
import {translate} from "@/store/languageStore.js";
import SecurityModal from './SettingModals/SecurityModal.vue';
import PaymentsModal from './SettingModals/PaymentsModal.vue';
import AccessModal from './SettingModals/AccessModal.vue';
import CurrencyModal from './SettingModals/CurrencyModal.vue';
import NotificationsModals from './SettingModals/NotificationsModals.vue';
import PrivacySharing from './SettingModals/privacySharing.vue';
import Guide from './SettingModals/guide.vue';
import GiftModal from './SettingModals/GiftModal.vue';
import Suggestfriend from './SettingModals/Suggestfriend.vue';
import SupportModal from './SettingModals/SupportModal.vue';
import ReportModal from './SettingModals/ReportModal.vue';
import HowItWorksModal from './SettingModals/HowItWorksModal.vue';
import FeedbackModal from './SettingModals/FeedbackModal.vue';
import Terms from './SettingModals/Terms.vue';
import Policy from './SettingModals/Policy.vue';

const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const settingModal = ref(null);
const securityModal = ref(null);
const paymentsModal = ref(null);
const accessModal = ref(null);
const currencyModal = ref(null);
const notificationsModals = ref(null);
const privacysharing = ref(null);
const guide = ref(null);
const giftModal = ref(null);
const suggestfriend = ref(null);
const supportModal = ref(null);
const reportModal = ref(null);
const howItWorksModal = ref(null);
const feedbackModal = ref(null);
const terms = ref(null);
const policy = ref(null);

const goToPage = (link) => {
    Inertia.visit(link);
};


const handleSettingClick = (link) => {
    if (link === '/SettingModal') {
        settingModal.value.openModal();
    } else if (link === '/SecurityModal') {
        securityModal.value.openModal();
    } else if (link === '/PaymentsModal') {
        paymentsModal.value.openModal();
    } else if (link === '/AccessModal') {
        accessModal.value.openModal();
    } else if (link === '/CurrencyModal') {
        currencyModal.value.openModal();
    } else if (link === '/NotificationsModals') {
        notificationsModals.value.openModal();
    } else if (link === '/PrivacySharing') {
        privacysharing.value.openModal();
    } else if (link === '/Guide') {
        guide.value.openModal();
    } else if (link === '/GiftModal') {
        giftModal.value.openModal();
    } else if (link === '/Suggestfriend') {
        suggestfriend.value.openModal();
    } else if (link === '/SupportModal') {
        supportModal.value.openModal();
    } else if (link === '/ReportModal') {
        reportModal.value.openModal();
    } else if (link === '/HowItWorksModal') {
        howItWorksModal.value.openModal();
    } else if (link === '/FeedbackModal') {
        feedbackModal.value.openModal();
    } else if (link === '/Terms') {
        terms.value.openModal();
    } else if (link === '/Policy') {
        policy.value.openModal();
    } else {
        goToPage(link);
    }
};
const userProfileImage = ref('/avatar-2.png');
const userName = ref('Zahra Azizi');

const settingsItems = [
    {title: "setting.personalInfo", icon: "mdi-account", link: "/SettingModal"},
    {title: "setting.loginSecurity", icon: "mdi-security", link: "/SecurityModal"},
    {title: "setting.payments", icon: "mdi-credit-card", link: "/PaymentsModal"},
    {title: "setting.access", icon: "mdi-lock", link: "/AccessModal"},
    {title: "setting.currency", icon: "mdi-currency-eur", link: "/CurrencyModal"},
    {title: "setting.notifications", icon: "mdi-bell", link: "/NotificationsModals"},
    {title: "setting.privacySharing", icon: "mdi-lock-outline", link: "/PrivacySharing"}
];

const referralItems = [
    {title: "setting.giftCard", icon: "mdi-gift", link: "/GiftModal"},
    {title: "setting.referHost", icon: "mdi-account-group", link: "/Suggestfriend"}
];

const supportItems = [
    {title: "setting.supportCenter", icon: "mdi-headset", link: "/SupportModal"},
    {title: "setting.reportIssues", icon: "mdi-alert", link: "/ReportModal"},
    {title: "setting.howItWorks", icon: "mdi-information", link: "/HowItWorksModal"},
    {title: "setting.feedback", icon: "mdi-comment", link: "/FeedbackModal"}
];

const policyItems = [
    {title: "setting.termsOfService", icon: "mdi-file-document", link: "/Terms"},
    {title: "setting.privacyPolicy", icon: "mdi-lock-check", link: "/Policy"}
];
</script>

<style scoped>
.settings-container {
    max-width: 800px;
    margin: auto;
    border-radius: 12px;
    overflow: hidden;
    padding: 16px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    gap: 10px;
    padding: 20px;
    background-color: #b7b5b5;
    border-radius: 15px !important;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 100%;

}

.avatar {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 60px;
    height: 60px;
    margin-left: 25px;
}

.list-item {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    transition: none;
}

.list-item:hover {
    background-color: unset;
}

.text1:hover {
    color: #0076ff;
}

.icon {
    font-size: 24px;
    color: #858585;
}

.text {
    flex-grow: 1;
    text-align: center;
    font-size: 16px;
    color: #eaeaea;
    padding-left: 25px;
}

.text-content {
    text-align: center;
    width: 100%;
}

.user-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
}

.profile-link {
    color: #0101ac;
    cursor: pointer;
    font-size: 14px;
}

.text1 {
    color: #0076ff;
    font-size: 22px;
    font-weight: bold;
    padding: 10px 0;
    text-align: center !important;

}

.logout {
    display: flex;
    align-items: center;
    gap: 8px;
    color: red;
    font-weight: bold;
    padding: 12px;
    margin-bottom: 100px;
}

.logout .icon {
    font-size: 24px;
    color: red;
}

.logout .text {
    font-size: 16px;
    color: red;
}

</style>
