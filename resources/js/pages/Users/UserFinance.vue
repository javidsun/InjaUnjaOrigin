<template>
    <UserSidebar class="back">
        <v-container class="payments-container">
            <v-tabs v-model="tab" background-color="primary" dark align-tabs="center">
                <v-tab value="all">{{ translate('Finance.all') }}</v-tab>
                <v-tab value="cancelled">{{ translate('Finance.cancelled') }}</v-tab>
                <v-tab value="processing">{{ translate('Finance.processing') }}</v-tab>
                <v-tab value="successful">{{ translate('Finance.successful') }}</v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item value="all">
                    <v-data-table :headers="headers" :items="filteredPayments" class="elevation-1 payment-table">
                        <template v-slot:item.actions="{ item }">
                            <v-btn color="primary" @click="showDetails(item)">{{ translate('Finance.Details') }}</v-btn>
                        </template>
                        <template v-slot:item.status="{ item }">
                            <span :class="getStatusClass(item.status)">{{ translate('Finance.' + item.status) }}</span>
                        </template>
                    </v-data-table>
                </v-tab-item>
            </v-tabs-items>

            <v-dialog v-model="dialog" max-width="500px">
                <v-card class="payment-details-card modal1">
                    <v-card-title class="details-title">{{ translate('Finance.paymentDetails') }}</v-card-title>
                    <v-card-text>
                        <p><strong>{{ translate('Finance.id') }}:</strong> {{ selectedPayment.id }}</p>
                        <p><strong>{{ translate('Finance.amount') }}:</strong> {{ finalAmount }} {{ translate('housescontent.Euro') }}</p>
                        <p><strong>{{ translate('Finance.status') }}:</strong> <span :class="getStatusClass(selectedPayment.status)">{{ translate('Finance.' + selectedPayment.status) }}</span></p>

                        <v-divider class="my-4"></v-divider>
                        <v-card-title class="details-subtitle">{{ translate('Finance.paymentDetails') }}</v-card-title>

                        <v-card-text>
                            <v-row>
                                <v-col cols="6">{{ translate('Finance.totalAmount') }}:</v-col>
                                <v-col cols="6" class="text-right">{{ totalAmount }} {{ translate('housescontent.Euro') }}</v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6">{{ translate('Finance.extraFee') }}:</v-col>
                                <v-col cols="6" class="text-right">{{ extraFee }} {{ translate('housescontent.Euro') }}</v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6">{{ translate('Finance.tax') }} (10%):</v-col>
                                <v-col cols="6" class="text-right">{{ tax }} {{ translate('housescontent.Euro') }}</v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="6" class="font-weight-bold">{{ translate('Finance.finalAmount') }}:</v-col>
                                <v-col cols="6" class="text-right font-weight-bold">{{ finalAmount }} {{ translate('housescontent.Euro') }}</v-col>
                            </v-row>
                        </v-card-text>

                        <v-divider class="my-4"></v-divider>
                        <v-card-title class="details-subtitle">{{ translate('Finance.paymentMethod') }}</v-card-title>
                        <v-card-text>
                            <p><strong>{{ translate('Finance.paymentMethod') }}:</strong> {{ selectedPaymentMethod }}</p>
                        </v-card-text>

                        <v-divider class="my-4"></v-divider>
                        <v-card-title class="details-subtitle">{{ t('Finance.locationDetails') }}</v-card-title>
                        <v-card-text>
                            <p><strong>{{ translate('Finance.location') }}:</strong> {{ selectedFinance.location }}</p>
                            <p><strong>{{ translate('Finance.host') }}:</strong> {{ selectedFinance.host }}</p>
                            <p><strong>{{ translate('Finance.rating') }}:</strong> {{ selectedFinance.rating }}</p>
                            <p><strong>{{ translate('Finance.type') }}:</strong> {{ selectedFinance.type }}</p>
                            <p><strong>{{ translate('Finance.period') }}:</strong> {{ selectedFinance.period }}</p>
                        </v-card-text>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="primary" @click="dialog = false">{{ translate('Finance.close') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </UserSidebar>
</template>

<script>
import UserSidebar from './Layout.vue';
import jsPDF from 'jspdf';
import autoTable from 'jspdf-autotable';
import { translate } from "../../store/languageStore";

export default {
    setup() {
        return { translate };
    },
    components: {
        UserSidebar,
    },
    data() {
        return {
            dialog: false,
            selectedPayment: {},
            selectedFinance: null,
            selectedPaymentMethod: 'Credit card',
            tab: 'all',
            headers: [
                { text: translate('Finance.id'), value: 'id' },
                { text: translate('Finance.finalAmount'), value: 'finalAmount' },
                { text: translate('Finance.status'), value: 'status' },
                { text: translate('Finance.actions'), value: 'actions', sortable: false }
            ],
            payments: [
                { id: 12554, status: 'successful', financeId: 0 },
                { id: 25462, status: 'cancelled', financeId: 1 },
                { id: 84355, status: 'processing', financeId: 2 },
                { id: 92554, status: 'cancelled', financeId: 3 },
                { id: 98545, status: 'successful', financeId: 4 },
            ],
            Finance: [
                {
                    location: "بروکسل،بلژیک",
                    host: "میزبان آرمین",
                    rating: "4.8",
                    price: "28",
                    period: "شبانه",
                    type: "home",
                    image: "rectangle-720.png",
                    coordinates: [50.8503, 4.3517],
                    extraFee: 5
                },
                {
                    location: "آنتورپ،بلژیک",
                    host: "مالک کامیاب",
                    rating: "5",
                    price: "18",
                    period: "روزانه",
                    type: "apartment",
                    image: "rectangle-750.png",
                    coordinates: [50.8549, 4.3479],
                    extraFee: 8
                },
                {
                    location: "بروکسل،بلژیک",
                    host: "مالک کامیاب",
                    rating: "5",
                    price: "10",
                    period: "روزانه",
                    type: "apartment",
                    image: "rectangle-750.png",
                    coordinates: [50.8549, 4.3479],
                    extraFee: 20
                },
                {
                    location: "بروکسل،بلژیک",
                    host: "میزبان سام",
                    rating: "3.8",
                    price: "22",
                    type: "bed",
                    period: "شبانه",
                    image: "rectangle-2210.png",
                    coordinates: [50.8521, 4.3459],
                    extraFee: 5
                },
                {
                    location: "بروکسل،بلژیک",
                    host: "مالک کامیاب",
                    rating: "5",
                    price: "25",
                    type: "tent",
                    period: "روزانه",
                    image: "rectangle-2200.png",
                    coordinates: [50.8535, 4.3498],
                    extraFee: 10
                },
            ],
        };
    },
    computed: {
        totalAmount() {
            return this.selectedFinance ? parseFloat(this.selectedFinance.price) : 0;
        },
        tax() {
            return (this.totalAmount * 0.1).toFixed(2);
        },
        extraFee() {
            return this.selectedFinance ? this.selectedFinance.extraFee : 0;
        },
        finalAmount() {
            return (parseFloat(this.totalAmount) + parseFloat(this.tax) + parseFloat(this.extraFee)).toFixed(2);
        },
        finalAmountForTable() {
            return this.payments.map(payment => {
                const financeItem = this.Finance[payment.financeId];
                const price = parseFloat(financeItem.price);
                const tax = (price * 0.1).toFixed(2);
                const extraFee = financeItem.extraFee;
                return {
                    ...payment,
                    finalAmount: (parseFloat(price) + parseFloat(tax) + parseFloat(extraFee)).toFixed(2)
                };
            });
        },

        filteredPayments() {
            switch (this.tab) {
                case 'all':
                    return this.finalAmountForTable;
                case 'cancelled':
                    return this.finalAmountForTable.filter(payment => payment.status === 'cancelled');
                case 'processing':
                    return this.finalAmountForTable.filter(payment => payment.status === 'processing');
                case 'successful':
                    return this.finalAmountForTable.filter(payment => payment.status === 'successful');
                default:
                    return [];
            }
        },
    },

    methods: {
        showDetails(payment) {
            this.selectedPayment = payment;
            this.selectedFinance = this.Finance[payment.financeId];
            this.dialog = true;
        },
        getStatusClass(status) {
            switch (status) {
                case 'successful':
                    return 'success';
                case 'processing':
                    return 'processing';
                case 'cancelled':
                    return 'cancelled';
                default:
                    return '';
            }
        },
        generatePDF() {
            const successfulPayments = this.filteredPayments;
            const doc = new jsPDF();

            doc.setFontSize(18);
            doc.text(translate('Finance.successfulPayments'), 10, 10);

            const tableData = successfulPayments.map(payment => [
                payment.id,
                `${payment.finalAmount} یورو`,
                translate('Finance.' + payment.status)
            ]);

            doc.autoTable({
                head: [[translate('Finance.id'), translate('Finance.finalAmount'), translate('Finance.status')]],
                body: tableData,
                startY: 20,
                theme: 'grid',
                styles: { font: 'tahoma', fontStyle: 'normal', halign: 'center' },
                headStyles: { fillColor: [76, 175, 80] },
            });

            doc.save('successful_payments.pdf');
        }
    },
};
</script>



<style scoped>
.v-tabs {
    border-radius: 12px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

.v-tab {
    transition: all 0.3s ease;
    border-radius: 8px;
}

.v-tab:hover {
    background-color: rgba(255, 255, 255, 0.2);
}
.payment-table {
    border-radius: 12px;
    overflow: hidden;
}

.v-btn {
    border-radius: 8px;
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
}
.payment-details-card {
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.payments-container {
    background-color: var(--background-color);
    color: var(--text-color);
    padding: 20px;
}

.payment-table {
    background-color: var(--background-color);
    border-radius: 10px;
    padding: 20px;
    margin: 0 auto;
    max-width: 800px;
}

.payment-details-card {
    border-radius: 10px;
}

.details-title {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.details-subtitle {
    font-size: 1.2rem;
    font-weight: bold;
    color: #4970ff;
    margin-top: 20px;
}

.v-btn {
    margin-top: 10px;
}

.back {
    background-color: var(--background-color);
}

.modal1 {
    border-radius: 5% !important;
    color: white;
}

/* کلاس‌های وضعیت */
.success {
    color: #4CAF50; /* سبز */
    font-weight: bold;
}

.processing {
    color: #FFC107; /* زرد */
    font-weight: bold;
}

.cancelled {
    color: #F44336; /* قرمز */
    font-weight: bold;
}
</style>
<script setup lang="ts">
import UserSidebar from "@/pages/Users/UserSidebar.vue";
</script>
