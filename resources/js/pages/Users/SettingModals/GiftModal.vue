<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ t('giftCard.giftCardTitle') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ t('giftCard.walletBalance') }}: {{ walletBalance }} {{ t('giftCard.currency') }}</p>

                <v-form @submit.prevent="confirmGiftCardPurchase">
                    <v-text-field
                        v-model="giftCardAmount"
                        :label="t('giftCard.giftCardAmountLabel')"
                        type="number"
                        :min="1"
                        :max="walletBalance"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-text-field
                        v-model="giftCardRecipient"
                        :label="t('giftCard.giftCardRecipientLabel')"
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="giftCardMessage"
                        :label="t('giftCard.giftCardMessageLabel')"
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div class="button-container">
                        <v-btn @click="confirmGiftCardPurchase" color="primary" large>
                            {{ t('giftCard.confirmPurchase') }}
                        </v-btn>
                        <v-btn @click="closeModal" color="secondary" large class="ml-2">
                            {{ t('giftCard.cancel') }}
                        </v-btn>
                    </div>

                    <v-card class="gift-card-details">
                        <v-card-title class="gift-card-details">{{ t('giftCard.giftCardTitle') }}</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div class="gift-card-details">
                                <p>{{ t('giftCard.issueDate') }}: {{ new Date().toLocaleDateString() }}</p>
                                <p>{{ t('giftCard.amount') }}: {{ giftCardAmount }} {{ t('giftCard.currency') }}</p>
                                <p>{{ t('giftCard.giftCardRecipientLabel') }}: {{ giftCardRecipient }}</p>
                                <p>{{ t('giftCard.giftCardMessageLabel') }}: {{ giftCardMessage }}</p>
                                <p>{{ t('giftCard.expiryDate') }}: {{ expiryDate }}</p>
                            </div>
                        </v-card-text>
                        <v-divider></v-divider>
                    </v-card>
                </v-form>

                <v-btn @click="viewGiftCardHistory" color="secondary" class="mt-4">
                    {{ t('giftCard.viewHistory') }}
                </v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isConfirmationModalOpen" max-width="400px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ t('giftCard.confirmPurchaseTitle') }}</span>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ t('giftCard.confirmPurchaseMessage') }}</p>
            </v-card-text>

            <v-card-actions>
                <v-btn @click="sendGiftCard" color="primary" large>
                    {{ t('giftCard.yes') }}
                </v-btn>
                <v-btn @click="cancelPurchase" color="secondary" large>
                    {{ t('giftCard.no') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isHistoryModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ t('giftCard.historyTitle') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeHistoryModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <v-list>
                    <v-list-item-group v-if="giftCards.length > 0">
                        <v-list-item v-for="(card, index) in giftCards" :key="index">
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ t('giftCard.amount') }}: {{ card.amount }} {{ t('giftCard.currency') }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ t('giftCard.issueDate') }}: {{ new Date(card.date).toLocaleDateString() }} <br />
                                    {{ t('giftCard.expiryDate') }}: {{ card.expiryDate }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-if="giftCards.length === 0">
                        <v-list-item-content>
                            <v-list-item-title>{{ t('giftCard.noCardsIssued') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { ref } from 'vue';
import { t } from "../../../store/languageStore";

const isModalOpen = ref(false);
const isHistoryModalOpen = ref(false);
const isConfirmationModalOpen = ref(false);
const giftCardAmount = ref(0);
const giftCardRecipient = ref('');
const giftCardMessage = ref('');
const walletBalance = ref(150);
const expiryDate = ref('');
const giftCards = ref([]);

const calculateExpiryDate = () => {
    const expiry = new Date();
    expiry.setMonth(expiry.getMonth() + 3);

    const year = expiry.getFullYear();
    const month = String(expiry.getMonth() + 1).padStart(2, '0');
    const day = String(expiry.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
};

const openModal = () => {
    isModalOpen.value = true;
    expiryDate.value = calculateExpiryDate();
};

const closeModal = () => {
    isModalOpen.value = false;
    giftCardAmount.value = 0;
    giftCardRecipient.value = '';
    giftCardMessage.value = '';
};

const confirmGiftCardPurchase = () => {
    if (giftCardAmount.value > walletBalance.value) {
        alert(t('giftCard.insufficientBalance'));
        return;
    }

    isConfirmationModalOpen.value = true;
};

const cancelPurchase = () => {
    isConfirmationModalOpen.value = false;
};

const viewGiftCardHistory = () => {
    isHistoryModalOpen.value = true;
};

const closeHistoryModal = () => {
    isHistoryModalOpen.value = false;
};

const sendGiftCard = () => {
    const url = window.location.href;
    const giftCardDetails = `Amount: ${giftCardAmount.value} ${t('giftCard.currency')}, Recipient: ${giftCardRecipient.value}, Expiry Date: ${expiryDate.value}`;

    if (navigator.share) {
        navigator.share({
            title: t('friendInvite.shareTitle'),
            text: `${t('friendInvite.shareMessage')} - ${giftCardDetails}`,
            url: url
        }).catch((error) => console.error("Error sharing:", error));
    } else {
        alert(t('friendInvite.shareFallback'));
    }
};

defineExpose({ openModal });
</script>


<style scoped>
    .gift-card-details {
        background-color: #28282f !important;
    }
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


    .image-container {
        margin-bottom: 1rem;
    }

    .button-container {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
    }

    .modal-content {
        padding: 2rem;
        background-color: #3b3b3b;
    }

    </style>
