<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card class="modal-container">
            <v-card-title class="header">
                <span>{{ translate ('payments.title') }}</span>
                <v-btn icon @click="closeModal" class="close-btn">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-card-title>

            <v-card-text>
                <div class="payment-methods">
                    <h3 class="section-title">{{ translate('payments.paymentMethods') }}</h3>
                    <v-divider class="my-2"></v-divider>
                    <v-list>
                        <v-list-item @click="openWalletChargeModal">
                            <v-list-item-title>
                                <v-icon class="icon">mdi-wallet</v-icon>
                                {{ translate('payments.walletCharge') }}
                            </v-list-item-title>
                        </v-list-item>
                        <v-list-item @click="openOnlinePaymentModal">

                            <v-list-item-title>
                                <v-icon class="icon">mdi-credit-card</v-icon>

                                {{ translate('payments.onlinePayment') }}
                            </v-list-item-title>
                        </v-list-item>
                    </v-list>
                </div>

                <div class="your-payments">

                    <h3 class="section-title">{{ translate('payments.yourPayments') }}</h3>
                    <v-divider class="my-2"></v-divider>
                    <v-btn block @click="goToPage('/UserFinance')" class="action-btn">
                        {{ translate('payments.viewFinance') }}
                    </v-btn>
                </div>

                <div class="credits-coupons">
                    <h3 class="section-title">{{ translate('payments.creditsCoupons') }}</h3>
                    <v-divider class="my-2"></v-divider>
                    <v-btn block @click="openCouponsModal" class="action-btn">
                        {{ translate('payments.viewCoupons') }}
                    </v-btn>
                </div>
            </v-card-text>
        </v-card>

        <v-dialog v-model="isWalletChargeModalOpen" max-width="500px">
            <v-card>
                <v-card-title class="dialog-header">{{ translate('payments.walletCharge') }}</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="submitWalletCharge">
                        <v-text-field
                            v-model="chargeAmount"
                            :label="translate('payments.amount')"
                            type="number"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" type="submit">{{ translate('payments.confirm') }}</v-btn>
                            <v-btn color="error" @click="closeWalletChargeModal">{{ translate('payments.cancel') }}
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="isOnlinePaymentModalOpen" max-width="500px">
            <v-card>
                <v-card-title class="dialog-header">{{ translate('payments.onlinePayment') }}</v-card-title>
                <v-card-text>
                    <v-form @submit.prevent="submitOnlinePayment">
                        <v-text-field
                            v-model="cardNumber"
                            :label="translate('payments.cardNumber')"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="expiryDate"
                            :label="translate('payments.expiryDate')"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="cvv"
                            :label="translate('payments.cvv')"
                            type="password"
                            outlined
                            dense
                            required
                        ></v-text-field>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" type="submit">{{ translate('payments.confirm') }}</v-btn>
                            <v-btn color="error" @click="closeOnlinePaymentModal">{{ translate('payments.cancel') }}
                            </v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="isCouponsModalOpen" max-width="500px">
            <v-card>
                <v-card-title class="dialog-header">{{ translate('payments.coupons') }}</v-card-title>
                <v-card-text>
                    <v-list>
                        <v-list-item v-for="(coupon, index) in coupons" :key="index">
                            <v-list-item-avatar>
                                <v-img :src="coupon.image" alt="Coupon Image"></v-img>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title>{{ coupon.code }}</v-list-item-title>
                                <v-list-item-subtitle>{{ coupon.discount }}% {{ translate('payments.discount') }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-action>
                                <v-btn color="primary" @click="applyCoupon(coupon)">{{ translate('payments.Copy') }}
                                </v-btn>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                </v-card-text>
            </v-card>
        </v-dialog>
    </v-dialog>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import {ref} from 'vue';
import {useRouter} from 'vue-router';
import {translate} from "@/store/languageStore.js";
import {Inertia} from "@inertiajs/inertia";

const isModalOpen = ref(false);
const isWalletChargeModalOpen = ref(false);
const isOnlinePaymentModalOpen = ref(false);
const isCouponsModalOpen = ref(false);
const chargeAmount = ref('');
const cardNumber = ref('');
const expiryDate = ref('');
const cvv = ref('');
const coupons = ref([
    {code: 'SUMMER2023', discount: 5, image: '/coupon1.jpg'},
    {code: 'WINTER2023', discount: 10, image: '/coupon3.jpg'},
]);

const applyCoupon = (coupon) => {
    console.log('Coupon applied:', coupon.code);
    closeCouponsModal();
};

const router = useRouter();

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const openWalletChargeModal = () => {
    isWalletChargeModalOpen.value = true;
};

const closeWalletChargeModal = () => {
    isWalletChargeModalOpen.value = false;
};

const openOnlinePaymentModal = () => {
    isOnlinePaymentModalOpen.value = true;
};

const closeOnlinePaymentModal = () => {
    isOnlinePaymentModalOpen.value = false;
};

const openCouponsModal = () => {
    isCouponsModalOpen.value = true;
};

const closeCouponsModal = () => {
    isCouponsModalOpen.value = false;
};

const goToPage = (link) => {
    Inertia.visit(link);
};

const submitWalletCharge = () => {
    console.log('شارژ کیف پول:', chargeAmount.value);
    closeWalletChargeModal();
};

const submitOnlinePayment = () => {
    console.log('پرداخت آنلاین:', cardNumber.value, expiryDate.value, cvv.value);
    closeOnlinePaymentModal();
};

defineExpose({openModal});
</script>
<style scoped>
.modal-container {
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px;
    font-weight: bold;
    color: white;
    background-color: #3b3b3b;
}

.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

.section-title {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 8px;
}

.action-btn {
    margin-top: 8px;
    background-color: #1976d2;
    color: white;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.action-btn:hover {
    background-color: #1565c0;
    transform: translateY(-2px);
}

.dialog-header {
    font-weight: bold;
    background-color: #3b3b3b;
    color: white;
    padding: 16px;
}

.v-form {
    padding: 16px;
}

.v-text-field {
    margin-bottom: 16px;
}

.v-card-actions {
    padding: 16px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.icon {
    color: #8c9eff;
    size: 120px;
}


@media (max-width: 600px) {
    .section-title {
        font-size: 1rem;
    }

    .action-btn {
        font-size: 0.8rem;
    }
}
</style>
