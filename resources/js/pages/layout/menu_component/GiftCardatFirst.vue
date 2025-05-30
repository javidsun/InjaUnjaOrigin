<template>
    <v-dialog v-model="isModalOpen" max-width="500px" @click:outside="closeDialog">

        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('giftCard.giftCardTitle') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="handleCloseModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <div class="modal-image">
                    <v-img src="/Untitled design (20) 29.png" alt="Gift Card Image" height="150px"></v-img>
                </div>

                <p class="description">
                    {{ translate('giftCard.giftCardDescription') }}
                </p>

                <v-form @submit.prevent="handleGiftCardPurchase">
                    <v-text-field
                        v-model="giftCardData.amount"
                        :label="translate('giftCard.giftCardAmountLabel')"
                        type="number"
                        required
                        outlined
                        class="mb-4"
                        min="1"
                    ></v-text-field>

                    <v-text-field
                        v-model="giftCardData.recipient"
                        :label="translate('giftCard.giftCardRecipientLabel')"
                        type="email"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="giftCardData.message"
                        :label="translate('giftCard.giftCardMessageLabel')"
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div class="button-container">
                        <v-btn type="submit" color="primary" large>
                            {{ translate('giftCard.confirmPurchase') }}
                        </v-btn>
                        <v-btn @click="handleCloseModal" color="secondary" large class="ml-2">
                            {{ translate('giftCard.cancel') }}
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo: { "amount": "number (the gift card value)", "recipient": "string (recipient's email address)", "message": "string (optional gift message)","purchase_date": "string (date in ISO format)", "sender_id": "number (optional - if authenticated user)"}

import { translate } from "@/store/languageStore";

export default {
    name: 'GiftCardModal',
    data() {
        return {
            isModalOpen: true,
            giftCardData: {
                amount: '',
                recipient: '',
                message: ''
            },
            giftCards: []
        }
    },
    methods: {
        translate,

        openModal() {
            this.isModalOpen = true;

        },

        closeDialog() {
            this.isModalOpen = false;
            this.$emit("close");
        },

        handleCloseModal() {
            try {
                this.isModalOpen = false;
                this.resetFormData();
                this.$emit("close");
            } catch (error) {
                this.handleError('Failed to close modal', error);
            }
        },

        resetFormData() {
            this.giftCardData = {
                amount: '',
                recipient: '',
                message: ''
            };
        },
        async handleGiftCardPurchase() {
            try {
                if (!this.validateForm()) {
                    return;
                }
                const newGiftCard = this.prepareGiftCardData();
                this.giftCards.push(newGiftCard);

                await this.processPurchase(newGiftCard);
                this.handleCloseModal();

            } catch (error) {
                this.handleError('Failed to process gift card purchase', error);
            }
        },

        validateForm() {
            if (!this.giftCardData.amount || Number(this.giftCardData.amount) <= 0) {
                this.showError('Please enter a valid amount');
                return false;
            }

            if (!this.giftCardData.recipient || !this.validateEmail(this.giftCardData.recipient)) {
                this.showError('Please enter a valid email address');
                return false;
            }

            return true;
        },

        prepareGiftCardData() {
            return {
                amount: Number(this.giftCardData.amount),
                recipient: this.giftCardData.recipient.trim(),
                message: this.giftCardData.message.trim(),
                date: new Date().toISOString()
            };
        },

        async processPurchase(giftCardData) {
            //  would be an API call
            console.log('Processing gift card purchase:', giftCardData);
            // Example: await api.post('/gift-cards', giftCardData);
        },


        validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },

        showError(message) {
            //  would show this to the user
            console.warn('Validation error:', message);
        },


        handleError(context, error) {
            // would log this to an error tracking service
            console.warn(`${context}:`, error.message);
            // optionally show a user-friendly message
            this.showError('An error occurred. Please try again.');
        }
    }
}
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
    color: white;
}

.close-btn:hover {
    transform: rotate(90deg);
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

.modal-image {
    margin-bottom: 1rem;
    text-align: center;
}
</style>
