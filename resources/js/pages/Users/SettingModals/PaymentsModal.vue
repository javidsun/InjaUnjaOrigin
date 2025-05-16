<template>
    <v-dialog v-model="isModalOpen" max-width="600px" transition="dialog-transition">
        <v-card class="modal-container">
            <v-card-title class="header">
                <span>{{ translate('payments.title') }}</span>
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
                            :rules="amountRules"
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
                            :rules="cardNumberRules"
                            mask="####-####-####-####"
                        ></v-text-field>
                        <v-text-field
                            v-model="expiryDate"
                            :label="translate('payments.expiryDate')"
                            outlined
                            dense
                            required
                            :rules="expiryDateRules"
                            mask="##/##"
                        ></v-text-field>
                        <v-text-field
                            v-model="cvv"
                            :label="translate('payments.cvv')"
                            type="password"
                            outlined
                            dense
                            required
                            :rules="cvvRules"
                            mask="###"
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

        <v-snackbar
            v-model="showAlert"
            :color="alertColor"
            timeout="3000"
            top
            right
        >
            {{ alertMessage }}
            <template v-slot:action="{ attrs }">
                <v-btn
                    text
                    v-bind="attrs"
                    @click="showAlert = false"
                >
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </template>
        </v-snackbar>
    </v-dialog>
</template>

<script>
//Todo:walletCharge:amount
//Todo:onlinePayment:cardNumber/expiryDate/cvv/amount/transactionId
//Todo:coupons:code/discount/validUntil/image
//Todo:applyCoupon:code/discountAmount/message
//Todo:validationMessages:amountRequired/cardNumberRequired/cardNumberValid:must be 16 digits/expiryDateRequired/cvvRequired

import { translate } from "@/store/languageStore";

export default {
    name: 'PaymentModal',
    data() {
        return {
            isModalOpen: false,
            isWalletChargeModalOpen: false,
            isOnlinePaymentModalOpen: false,
            isCouponsModalOpen: false,
            chargeAmount: '',
            cardNumber: '',
            expiryDate: '',
            cvv: '',
            coupons: [
                {code: 'SUMMER2023', discount: 5, image: '/coupon1.jpg'},
                {code: 'WINTER2023', discount: 10, image: '/coupon3.jpg'},
            ],
            showAlert: false,
            alertMessage: '',
            alertColor: 'success',
            amountRules: [
                v => !!v || this.translate('payments.amountRequired'),
                v => (v && v > 0) || this.translate('payments.amountPositive')
            ],
            cardNumberRules: [
                v => !!v || this.translate('payments.cardNumberRequired'),
                v => (v && v.length === 19) || this.translate('payments.cardNumberValid')
            ],
            expiryDateRules: [
                v => !!v || this.translate('payments.expiryDateRequired'),
                v => /^\d{2}\/\d{2}$/.test(v) || this.translate('payments.expiryDateValid')
            ],
            cvvRules: [
                v => !!v || this.translate('payments.cvvRequired'),
                v => (v && v.length === 3) || this.translate('payments.cvvValid')
            ]
        }
    },
    methods: {
        translate,

        openModal() {
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        },
        openWalletChargeModal() {
            this.isWalletChargeModalOpen = true;
        },
        closeWalletChargeModal() {
            this.isWalletChargeModalOpen = false;
            this.chargeAmount = '';
        },
        openOnlinePaymentModal() {
            this.isOnlinePaymentModalOpen = true;
        },
        closeOnlinePaymentModal() {
            this.isOnlinePaymentModalOpen = false;
            this.cardNumber = '';
            this.expiryDate = '';
            this.cvv = '';
        },
        openCouponsModal() {
            this.isCouponsModalOpen = true;
        },
        closeCouponsModal() {
            this.isCouponsModalOpen = false;
        },
        applyCoupon(coupon) {
            navigator.clipboard.writeText(coupon.code).then(() => {
                this.showAlertMessage(this.translate('payments.couponCopied'), 'success');
            }).catch(() => {
                this.showAlertMessage(this.translate('payments.copyFailed'), 'error');
            });
            this.closeCouponsModal();
        },
        goToPage(link) {
            this.$inertia.visit(link);
        },
        submitWalletCharge() {
            if (!this.chargeAmount || this.chargeAmount <= 0) {
                this.showAlertMessage(this.translate('payments.amountInvalid'), 'error');
                return;
            }
            this.showAlertMessage(this.translate('payments.walletChargeSuccess'), 'success');
            this.closeWalletChargeModal();
        },
        submitOnlinePayment() {
            if (!this.validateCard()) {
                this.showAlertMessage(this.translate('payments.cardInvalid'), 'error');
                return;
            }

            console.log('Online payment:', this.cardNumber, this.expiryDate, this.cvv);
            this.showAlertMessage(this.translate('payments.paymentSuccess'), 'success');
            this.closeOnlinePaymentModal();
        },
        validateCard() {
            return this.cardNumber && this.cardNumber.length === 19 &&
                this.expiryDate && /^\d{2}\/\d{2}$/.test(this.expiryDate) &&
                this.cvv && this.cvv.length === 3;
        },
        showAlertMessage(message, color) {
            this.alertMessage = message;
            this.alertColor = color;
            this.showAlert = true;
        },

    }
}
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
