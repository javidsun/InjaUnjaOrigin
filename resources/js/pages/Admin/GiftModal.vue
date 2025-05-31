<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('GUIDE_GIFTCARD_GIFTCARDTITLE') }}</span>
                <v-spacer></v-spacer>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>
            <v-divider></v-divider>

            <v-card-text class="modal-content">
                <div class="modal-image">
                    <v-img src="/Untitled design (20) 29.png" alt="Gift Card Image" height="150px"></v-img>
                </div>

                <p class="description">
                    {{ translate('GUIDE_GIFTCARD_GIFTCARDDESCRIPTION') }}
                </p>

                <v-form @submit.prevent="handleGiftCardPurchase">
                    <v-text-field
                        v-model="formData.amount"
                        :label="translate('GUIDE_GIFTCARD_GIFTCARDAMOUNTLABEL')"
                        type="number"
                        required
                        outlined
                        class="mb-4"
                        :rules="amountRules"
                    ></v-text-field>

                    <v-text-field
                        v-model="formData.recipient"
                        :label="translate('GUIDE_GIFTCARD_GIFTCARDRECIPIENTLABEL')"
                        type="email"
                        required
                        outlined
                        class="mb-4"
                        :rules="emailRules"
                    ></v-text-field>

                    <v-textarea
                        v-model="formData.message"
                        :label="translate('GUIDE_GIFTCARD_GIFTCARDMESSAGELABEL')"
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div class="button-container">
                        <v-btn type="submit" color="primary" large :loading="isSubmitting">
                            {{ translate('GUIDE_GIFTCARD_CONFIRMPURCHASE') }}
                        </v-btn>
                        <v-btn @click="closeModal" color="secondary" large class="ml-2">
                            {{ translate('CANCEL') }}
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>

    <div class="gift-card-section">
        <h2 class="gift-card-title">{{ translate('GUIDE_GIFTCARD_GIFTCARDTITLE') }}</h2>
        <v-divider></v-divider>
        <p class="gift-card-subtitle">{{ translate('GUIDE_GIFTCARD_GIFTCARDSUBTITLE') }}</p>

        <div class="image-container">
            <v-img src="/icons8-gift-card-98.png" alt="Gift Card Image" class="gift-card-image"></v-img>
        </div>

        <div class="button-container">
            <v-btn @click="openModal" color="primary" large>
                {{ translate('GUIDE_GIFTCARD_BUYGIFTCARD') }}
            </v-btn>
        </div>
    </div>
</template>

<script>
//Todo:{create_gift_card:amount/recipient_email/message/purchase_date}
//Todo:{id/code/amount/recipient_email/message/purchase_date/expiration_date/status}
//Todo:{validation_messages: amount_required/amount_positive/email_required/email_valid}
//Todo:{business_rules: minimum_amount/maximum_amount/expiration_days/currency}

import { translate } from "@/store/languageStore";

export default {
    name: 'GiftCardComponent',

    data() {
        return {
            isModalOpen: false,
            isSubmitting: false,
            formData: {
                amount: '',
                recipient: '',
                message: ''
            },
            amountRules: [
                value => !!value || this.translate('AMOUNT_REQUIRED'),
                value => (value && value > 0) || this.translate('AMOUNT_MOST_BE_POSITIVE')
            ],
            emailRules: [
                value => !!value || this.translate('EMAIL_REQUIRED'),
                value => /.+@.+\..+/.test(value) || this.translate('EMAIL_MOST_BE_VALID')
            ]
        };
    },

    methods: {
        translate,
        openModal() {
            this.isModalOpen = true;
        },

        closeModal() {
            this.isModalOpen = false;
            this.resetForm();
        },

        resetForm() {
            this.formData = {
                amount: '',
                recipient: '',
                message: ''
            };
        },

        async handleGiftCardPurchase() {
            if (!this.validateForm()) {
                this.showError(this.translate('FROM_VALIDATION_FAILED'));
                return;
            }

            this.isSubmitting = true;

            try {
                const response = await this.submitGiftCardPurchase();
                this.showSuccess(this.translate('PURCHASE_SUCCESSFUL'));
                this.closeModal();
            } catch (error) {
                this.showError(this.translate('PURCHASE_FAILED') + ': ' + error.message);
            } finally {
                this.isSubmitting = false;
            }
        },

        validateForm() {
            return this.formData.amount > 0 &&
                this.formData.recipient &&
                /.+@.+\..+/.test(this.formData.recipient);
        },

        async submitGiftCardPurchase() {
            const payload = {
                amount: parseFloat(this.formData.amount),
                recipient_email: this.formData.recipient,
                message: this.formData.message,
                purchase_date: new Date().toISOString()
            };

            return await Inertia.post('/api/gift-cards', payload);
        },

        showSuccess(message) {
            this.$root.$emit('show-alert', {
                type: 'success',
                message: message,
                duration: 5000
            });
        },

        showError(message) {
            this.$root.$emit('show-alert', {
                type: 'error',
                message: message,
                duration: 8000
            });
        }
    }
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

.gift-card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.gift-card-subtitle {
    font-size: 1rem;
    color: #666;
    margin-bottom: 1rem;
}

.gift-card-image {
    max-width: 20%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
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

.dialog-header {
    background-color: #3f51b5;
    color: white;
    padding: 1rem;
}

.close-btn {
    color: white;
}

.modal-image {
    margin-bottom: 1rem;
    text-align: center;
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
