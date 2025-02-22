<template>
    <v-dialog v-model="isfriendModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ t('friendInvite.title') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ t('friendInvite.shareLink') }}</p>

                <v-row>
                    <v-col cols="12">
                        <v-img src="/Untitled design (20) 28.png" alt="Friend Invite" height="150px"></v-img>
                    </v-col>
                </v-row>

                <div class="button-container">
                    <v-btn @click="shareLink" color="primary" large>
                        {{ t('friendInvite.shareButton') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isfriendModalOpen = ref(false);

const openModal = () => {
    isfriendModalOpen.value = true;
};

const closeModal = () => {
    isfriendModalOpen.value = false;
};

const shareLink = () => {
    const url = window.location.href;
    if (navigator.share) {
        navigator.share({
            title: t('friendInvite.shareTitle'),
            text: t('friendInvite.shareMessage'),
            url: url
        }).catch((error) => console.error("Error sharing:", error));
    } else {
        // Fallback for browsers that do not support the Web Share API
        alert(t('friendInvite.shareFallback'));
    }
};
defineExpose({ openModal });

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
