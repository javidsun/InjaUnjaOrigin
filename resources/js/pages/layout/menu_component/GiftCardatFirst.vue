<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card>
            <v-card-title class="gift-card-section">
                <span>{{ translate('giftCardTitle') }}</span>
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
                    {{ translate('giftCardDescription') }}
                </p>

                <v-form @submit.prevent="confirmGiftCardPurchase">
                    <v-text-field
                        v-model="giftCardAmount"
                        :label="translate('giftCardAmountLabel')"
                        type="number"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-text-field
                        v-model="giftCardRecipient"
                        :label="translate('giftCardRecipientLabel')"
                        type="email"
                        required
                        outlined
                        class="mb-4"
                    ></v-text-field>

                    <v-textarea
                        v-model="giftCardMessage"
                        :label="translate('giftCardMessageLabel')"
                        outlined
                        class="mb-4"
                    ></v-textarea>

                    <div class="button-container">
                        <v-btn type="submit" color="primary" large>
                            {{ translate('confirmPurchase') }}
                        </v-btn>
                        <v-btn @click="closeModal" color="secondary" large class="ml-2">
                            {{ translate('cancel') }}
                        </v-btn>
                    </div>
                </v-form>
            </v-card-text>
        </v-card>
    </v-dialog>

    <div class="gift-card-section">
        <h2 class="gift-card-title">{{ translate('giftCardTitle') }}</h2>
        <v-divider></v-divider>
        <p class="gift-card-subtitle">{{ translate('giftCardSubtitle') }}</p>

        <div class="image-container">
            <v-img src="/icons8-gift-card-98.png" alt="Gift Card Image" class="gift-card-image"></v-img>
        </div>

        <div class="button-container">
            <v-btn @click="openModal" color="primary" large>
                {{ translate('buyGiftCard') }}
            </v-btn>
        </div>


    </div>
</template>

<script setup>
import {ref} from 'vue';
import {translate} from "../../store/languageStore";
import {Inertia} from "@inertiajs/inertia";

const isModalOpen = ref(false);

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    giftCardAmount.value = '';
    giftCardRecipient.value = '';
    giftCardMessage.value = '';
};

const giftCardAmount = ref('');
const giftCardRecipient = ref('');
const giftCardMessage = ref('');
const giftCards = ref([]);

const confirmGiftCardPurchase = () => {
    const newGiftCard = {
        amount: giftCardAmount.value,
        recipient: giftCardRecipient.value,
        message: giftCardMessage.value,
        date: new Date().toLocaleDateString(),
    };

    giftCards.value.push(newGiftCard);

    console.log('Gift card purchased:', newGiftCard);
    closeModal();
};


defineExpose({openModal});
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
