<template>
    <v-dialog v-model="isfriendModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('GUIDE_FRIENDINVITE_TITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ translate('GUIDE_FRIENDINVITE_SHARELINK') }}</p>

                <v-row>
                    <v-col cols="12">
                        <v-img src="/Untitled design (20) 28.png" alt="Friend Invite" height="150px"></v-img>
                    </v-col>
                </v-row>

                <div class="button-container">
                    <v-btn @click="shareLink" color="primary" large>
                        {{ translate('GUIDE_FRIENDINVITE_SHAREBUTTON') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:title/shareLink/shareButton/shareTitle/shareMessage/shareFallback

import { translate } from "@/store/languageStore";

export default {
    name: 'SuggestFriend',

    data() {
        return {
            isfriendModalOpen: false,
        };
    },

    methods: {
        translate,

        openModal() {
            this.isfriendModalOpen = true;
        },
        closeModal() {
            this.isfriendModalOpen = false;
        },
        shareLink() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: translate('GUIDE_FRIENDINVITE_SHARETITLE'),
                    text: translate('GUIDE_FRIENDINVITE_SHAREMESSAGE'),
                    url: url
                }).catch((error) => console.error("❌ Error sharing:", error));
            } else {
                alert(translate('GUIDE_FRIENDINVITE_SHAREFALLBACK'));
            }
        }
    },

    expose: ['openModal']
};
</script>

<style scoped>
.gift-card-section {
    display: flex;
    align-items: center;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.modal-content {
    padding: 2rem;
    background-color: #3b3b3b;
}

.v-dialog--active {
    z-index: 9999;
}

.dialog-transition-enter-active,
.dialog-transition-leave-active {
    transition: opacity 0.3s ease;
}

.dialog-transition-enter, .dialog-transition-leave-to {
    opacity: 0;
}
</style>
