<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('giftCard.giftCardTitle') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ translate('giftCard.walletBalance') }}: {{ walletBalance }} {{ translate('giftCard.currency') }}</p>

                <v-form @submit.prevent="confirmGiftCardPurchase">
                    <v-text-field
                        v-model="giftCardAmount"
                        :label="translate('giftCard.giftCardAmountLabel')"
                        type="number"
                        :min="1"
                        :max="walletBalance"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-text-field
                        v-model="giftCardRecipient"
                        :label="translate('giftCard.giftCardRecipientLabel')"
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="giftCardMessage"
                        :label="translate('giftCard.giftCardMessageLabel')"
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div class="button-container">
                        <v-btn @click="confirmGiftCardPurchase" color="primary" large>
                            {{ translate('giftCard.confirmPurchase') }}
                        </v-btn>
                        <v-btn @click="closeModal" color="secondary" large class="ml-2">
                            {{ translate('giftCard.cancel') }}
                        </v-btn>
                    </div>

                    <v-card class="gift-card-details">
                        <v-card-title class="gift-card-details">{{ translate('giftCard.giftCardTitle') }}</v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <div class="gift-card-details">
                                <p>{{ translate('giftCard.issueDate') }}: {{ new Date().toLocaleDateString() }}</p>
                                <p>{{ translate('giftCard.amount') }}: {{ giftCardAmount }} {{ translate('giftCard.currency') }}</p>
                                <p>{{ translate('giftCard.giftCardRecipientLabel') }}: {{ giftCardRecipient }}</p>
                                <p>{{ translate('giftCard.giftCardMessageLabel') }}: {{ giftCardMessage }}</p>
                                <p>{{ translate('giftCard.expiryDate') }}: {{ expiryDate }}</p>
                            </div>
                        </v-card-text>
                        <v-divider></v-divider>
                    </v-card>
                </v-form>

                <v-btn @click="viewGiftCardHistory" color="secondary" class="mt-4">
                    {{ translate('giftCard.viewHistory') }}
                </v-btn>
            </v-card-text>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isConfirmationModalOpen" max-width="400px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('giftCard.confirmPurchaseTitle') }}</span>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <p>{{ translate('giftCard.confirmPurchaseMessage') }}</p>
            </v-card-text>

            <v-card-actions>
                <v-btn @click="sendGiftCard" color="primary" large>
                    {{ translate('giftCard.yes') }}
                </v-btn>
                <v-btn @click="cancelPurchase" color="secondary" large>
                    {{ translate('giftCard.no') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="isHistoryModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('giftCard.historyTitle') }}</span>
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
                                    {{ translate('giftCard.amount') }}: {{ card.amount }} {{ translate('giftCard.currency') }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ translate('giftCard.issueDate') }}: {{ new Date(card.date).toLocaleDateString() }} <br/>
                                    {{ translate('giftCard.expiryDate') }}: {{ card.expiryDate }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                    <v-list-item v-if="giftCards.length === 0">
                        <v-list-item-content>
                            <v-list-item-title>{{ translate('giftCard.noCardsIssued') }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    data() {
        return {
            isModalOpen: false,
            isHistoryModalOpen: false,
            isConfirmationModalOpen: false,
            giftCardAmount: 0,
            giftCardRecipient: '',
            giftCardMessage: '',
            walletBalance: 150,
            expiryDate: '',
            giftCards: []
        }
    },
    methods: {
        translate,

        calculateExpiryDate() {
            try {
                const expiry = new Date();
                expiry.setMonth(expiry.getMonth() + 3);

                const year = expiry.getFullYear();
                const month = String(expiry.getMonth() + 1).padStart(2, '0');
                const day = String(expiry.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            } catch (error) {
                console.error('Error calculating expiry date:', error);
                return '';
            }
        },
        openModal() {
            try {
                this.isModalOpen = true;
                this.expiryDate = this.calculateExpiryDate();
            } catch (error) {
                console.error('Error opening modal:', error);
            }
        },
        closeModal() {
            try {
                this.isModalOpen = false;
                this.giftCardAmount = 0;
                this.giftCardRecipient = '';
                this.giftCardMessage = '';
            } catch (error) {
                console.error('Error closing modal:', error);
            }
        },
        confirmGiftCardPurchase() {
            try {
                if (this.giftCardAmount > this.walletBalance) {
                    alert(this.translate('giftCard.insufficientBalance'));
                    return;
                }

                this.isConfirmationModalOpen = true;
            } catch (error) {
                console.error('Error confirming gift card purchase:', error);
            }
        },
        cancelPurchase() {
            try {
                this.isConfirmationModalOpen = false;
            } catch (error) {
                console.error('Error canceling purchase:', error);
            }
        },
        viewGiftCardHistory() {
            try {
                this.isHistoryModalOpen = true;
            } catch (error) {
                console.error('Error viewing gift card history:', error);
            }
        },
        closeHistoryModal() {
            try {
                this.isHistoryModalOpen = false;
            } catch (error) {
                console.error('Error closing history modal:', error);
            }
        },
        async sendGiftCard() {
            try {
                const url = window.location.href;
                const giftCardDetails = `Amount: ${this.giftCardAmount} ${this.translate('giftCard.currency')}, Recipient: ${this.giftCardRecipient}, Expiry Date: ${this.expiryDate}`;

                if (navigator.share) {
                    await navigator.share({
                        title: this.translate('friendInvite.shareTitle'),
                        text: `${this.translate('friendInvite.shareMessage')} - ${giftCardDetails}`,
                        url: url
                    });
                } else {
                    alert(this.translate('friendInvite.shareFallback'));
                }

                this.giftCards.push({
                    amount: this.giftCardAmount,
                    recipient: this.giftCardRecipient,
                    date: new Date().toISOString(),
                    expiryDate: this.expiryDate
                });

                this.closeModal();
                this.isConfirmationModalOpen = false;
            } catch (error) {
                console.error('Error sending gift card:', error);
            }
        }
    }
}
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
