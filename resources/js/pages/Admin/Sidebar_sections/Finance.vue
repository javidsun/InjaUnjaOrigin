<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
                </div>
            </v-col>
            <v-spacer />
            <v-spacer />
            <Darkmood class="darkmood" />
            <LanguageSwitcher class="language" />
        </v-app-bar>

        <Sidebar app v-model="drawer" />

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid class="main1">
                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg pa-4">
                            <v-card-title class="text-h5 primary--text sizem">
                                <v-icon class="mr-2">mdi-chart-bar</v-icon>
                                {{ translate('Admin_Finance.user_stats') }}
                            </v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card success" elevation="2" @click="openMessageDialog(bestUserLastMonth)">
                                            <v-card-title class="text-h6">
                                                {{ bestUserLastMonth.user }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Finance.best_user') }} - Last Month</v-card-subtitle>
                                            <v-card-text>
                                                <p>{{ translate('Admin_Finance.successful_attempts') }}: {{ bestUserLastMonth.successfulAttempts }}</p>
                                                <p>{{ translate('Admin_Finance.unsuccessful_attempts') }}: {{ bestUserLastMonth.unsuccessfulAttempts }}</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-col cols="12" md="6" lg="3">
                                        <v-card class="info-card error" elevation="2" @click="openMessageDialog(worstUserLastMonth)">
                                            <v-card-title class="text-h6">
                                                {{ worstUserLastMonth.user }}
                                            </v-card-title>
                                            <v-card-subtitle>{{ translate('Admin_Finance.worst_user') }} - Last Month</v-card-subtitle>
                                            <v-card-text>
                                                <p>{{ translate('Admin_Finance.successful_attempts') }}: {{ worstUserLastMonth.successfulAttempts }}</p>
                                                <p>{{ translate('Admin_Finance.unsuccessful_attempts') }}: {{ worstUserLastMonth.unsuccessfulAttempts }}</p>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                    <v-dialog v-model="messageDialog" max-width="500">
                                        <v-card>
                                            <v-card-title>
                                                {{ translate('Admin_Finance.send_message') }}</v-card-title>
                                            <v-card-text>
                                                <v-textarea
                                                    v-model="messageText"
                                                    :label="translate('Admin_Finance.message')"
                                                    outlined
                                                ></v-textarea>
                                                <v-file-input
                                                    v-model="messageImage"
                                                    :label="translate('Admin_Finance.upload_image')"
                                                    accept="image/*"
                                                ></v-file-input>
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="primary" @click="sendMessage">{{ translate('Admin_Finance.send_message') }}</v-btn>
                                                <v-btn color="error" @click="messageDialog = false">{{ translate('Admin_Finance.cancel') }}</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </v-row>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
                <v-row class="mt-4">
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg pa-4">
                            <v-card-title class="text-h5 primary--text sizem">
                                <v-icon class="mr-2">mdi-cash-multiple</v-icon>
                                {{ translate('Admin_Finance.payments_list') }}
                            </v-card-title>
                            <v-card-text>
                                <v-data-table
                                    :headers="paymentHeaders"
                                    :items="payments"
                                    hide-default-footer
                                    class="details-table mt-4"
                                    dense
                                >
                                    <template v-slot:item.status="{ item }">
                                        <v-chip :color="getStatusColor(item.status)" small>
                                            {{ item.status }}
                                        </v-chip>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-btn small color="error" @click="openBlockUserDialog(item)" v-if="item.failedAttempts > 3">
                                            {{ translate('Admin_Finance.block_user') }}
                                        </v-btn>
                                    </template>
                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row class="mt-4">
                    <v-col cols="12">
                        <v-card class="elevation-4 rounded-lg pa-4">
                            <v-card-title class="text-h5 primary--text sizem">
                                <v-icon class="mr-2">mdi-cash-refund</v-icon>
                                {{ translate('Admin_Finance.refund_requests') }}
                            </v-card-title>
                            <v-card-text>
                                <v-data-table
                                    :headers="refundHeaders"
                                    :items="refundRequests"
                                    hide-default-footer
                                    class="details-table mt-4"
                                    dense
                                >
                                    <template v-slot:item.status="{ item }">
                                        <v-chip :color="getStatusColor(item.status)" small>
                                            {{ item.status }}
                                        </v-chip>
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-btn small color="primary" @click="openApproveRefundDialog(item)">
                                            {{ translate('Admin_Finance.approve_refund') }}
                                        </v-btn>
                                        <v-btn small color="error" @click="openRejectRefundDialog(item)" class="ml-2">
                                            {{ translate('Admin_Finance.reject_refund') }}
                                        </v-btn>
                                    </template>
                                </v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>

        <v-dialog v-model="blockUserDialog" max-width="500">
            <v-card>
                <v-card-title>{{ translate('Admin_Finance.block_user') }}</v-card-title>
                <v-card-text>
                    <v-textarea
                        v-model="blockUserNote"
                        :label="translate('Admin_Finance.add_note')"
                        :placeholder="translate('Admin_Finance.note_placeholder')"
                        outlined
                    ></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="blockUser">{{ translate('Admin_Finance.confirm') }}</v-btn>
                    <v-btn color="error" @click="blockUserDialog = false">{{ translate('Admin_Finance.cancel') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="approveRefundDialog" max-width="500">
            <v-card>
                <v-card-title>{{ translate('Admin_Finance.approve_refund') }}</v-card-title>
                <v-card-text>
                    <v-textarea
                        v-model="approveRefundNote"
                        :label="translate('Admin_Finance.add_note')"
                        :placeholder="translate('Admin_Finance.note_placeholder')"
                        outlined
                    ></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="approveRefund">{{ translate('Admin_Finance.confirm') }}</v-btn>
                    <v-btn color="error" @click="approveRefundDialog = false">{{ translate('Admin_Finance.cancel') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="rejectRefundDialog" max-width="500">
            <v-card>
                <v-card-title>{{ translate('Admin_Finance.reject_refund') }}</v-card-title>
                <v-card-text>
                    <v-textarea
                        v-model="rejectRefundNote"
                        :label="translate('Admin_Finance.add_note')"
                        :placeholder="translate('Admin_Finance.note_placeholder')"
                        outlined
                    ></v-textarea>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" @click="rejectRefund">{{ translate('Admin_Finance.confirm') }}</v-btn>
                    <v-btn color="error" @click="rejectRefundDialog = false">{{ translate('Admin_Finance.cancel') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-app>
</template>

<script>
//Todo:{getUserStats:url/description/response:/{bestUserLastMonth:{user/successfulAttempts/unsuccessfulAttempts}/worstUserLastMonth:{user/successfulAttempts/unsuccessfulAttempts}
//Todo:{getPayments:url/description/response:/{id/user/amount/date/status/failedAttempts/userId}
//Todo:{getRefundRequests:url/description/response:/{id/user/amount/date/status/failedAttempts/userId}
//Todo:{sendMessage:url/description/request:/{userId/message/image}
//Todo:{blockUser:url/description/request:/{userId:note}
//Todo:{processRefund:url/description/request:/{action:note}


import Sidebar from "../Sidebar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "@/store/languageStore";

export default {
    components: {
        Sidebar,
        Darkmood,
        LanguageSwitcher
    },
    data() {
        return {
            drawer: true,
            messageDialog: false,
            messageText: "",
            messageImage: null,
            selectedUserForMessage: null,
            blockUserDialog: false,
            approveRefundDialog: false,
            rejectRefundDialog: false,
            blockUserNote: "",
            approveRefundNote: "",
            rejectRefundNote: "",
            selectedUser: null,
            selectedRefund: null,

            paymentHeaders: [
                { text: translate('Admin_Finance.payments_list'), value: "id" },
                { text: translate('Admin_Finance.user'), value: "user" },
                { text: translate('Admin_Finance.amount'), value: "amount" },
                { text: translate('Admin_Finance.date'), value: "date" },
                { text: translate('Admin_Finance.status'), value: "status" },
                { text: translate('Admin_Finance.actions'), value: "actions" },
            ],

            payments: [
                {
                    id: 1,
                    user: "Ali Alavi",
                    amount: "100 Euro",
                    date: "2023-02-01",
                    status: "Successful",
                    failedAttempts: 0,
                    userId: 101,
                },
                {
                    id: 5,
                    user: "Ali Alavi",
                    amount: "52 Euro",
                    date: "2023-02-01",
                    status: "Successful",
                    failedAttempts: 0,
                    userId: 101,
                },
                {
                    id: 2,
                    user: "Sara Ahmadi",
                    amount: "120 Euro",
                    date: "2023-02-05",
                    status: "Unsuccessful",
                    failedAttempts: 4,
                    userId: 102,
                },
                {
                    id: 3,
                    user: "Majid Reshadat",
                    amount: "158 Euro",
                    date: "2023-02-06",
                    status: "Unsuccessful",
                    failedAttempts: 2,
                    userId: 103,
                },
                {
                    id: 4,
                    user: "Samira rezai",
                    amount: "25 Euro",
                    date: "2023-01-06",
                    status: "Successful",
                    failedAttempts: 5,
                    userId: 104,
                },
                {
                    id: 6,
                    user: "Sara Ahmadi",
                    amount: "120 Euro",
                    date: "2023-02-05",
                    status: "Unsuccessful",
                    failedAttempts: 4,
                    userId: 102,
                },
                {
                    id: 7,
                    user: "Sara Ahmadi",
                    amount: "100 Euro",
                    date: "2023-02-03",
                    status: "Unsuccessful",
                    failedAttempts: 4,
                    userId: 102,
                },
            ],

            refundHeaders: [
                { text: translate('Admin_Finance.refund_requests'), value: "id" },
                { text: translate('Admin_Finance.user'), value: "user" },
                { text: translate('Admin_Finance.amount'), value: "amount" },
                { text: translate('Admin_Finance.requestDate'), value: "requestDate" },
                { text: translate('Admin_Finance.status'), value: "status" },
                { text: translate('Admin_Finance.actions'), value: "actions" },
            ],

            refundRequests: [
                {
                    id: 1,
                    user: "Ali Alavi",
                    amount: "100 Euro",
                    date: "2023-02-05",
                    status: "Waiting",
                    failedAttempts: 0,
                    userId: 101,
                },
                {
                    id: 2,
                    user: "Sara Ahmadi",
                    amount: "120 Euro",
                    date: "2023-02-05",
                    status: "Waiting",
                    failedAttempts: 4,
                    userId: 102,
                },
            ]
        };
    },
    computed: {
        userStats() {
            const stats = {};
            this.payments.forEach(payment => {
                if (!stats[payment.userId]) {
                    stats[payment.userId] = {
                        user: payment.user,
                        successfulAttempts: 0,
                        unsuccessfulAttempts: 0,
                    };
                }
                if (payment.status === "Successful") {
                    stats[payment.userId].successfulAttempts++;
                } else if (payment.status === "Unsuccessful") {
                    stats[payment.userId].unsuccessfulAttempts++;
                }
            });
            return Object.values(stats);
        },

        userStatsByMonth() {
            const statsByMonth = {};
            this.payments.forEach(payment => {
                const month = this.getMonthFromDate(payment.date);
                if (!statsByMonth[month]) {
                    statsByMonth[month] = {};
                }
                if (!statsByMonth[month][payment.userId]) {
                    statsByMonth[month][payment.userId] = {
                        user: payment.user,
                        successfulAttempts: 0,
                        unsuccessfulAttempts: 0,
                    };
                }
                if (payment.status === "Successful") {
                    statsByMonth[month][payment.userId].successfulAttempts++;
                } else if (payment.status === "Unsuccessful") {
                    statsByMonth[month][payment.userId].unsuccessfulAttempts++;
                }
            });
            return statsByMonth;
        },

        bestUserLastMonth() {
            const lastMonth = this.getLastMonth();
            const stats = Object.values(this.userStatsByMonth[lastMonth] || {});
            return stats.reduce((best, current) => {
                return current.successfulAttempts > best.successfulAttempts ? current : best;
            }, { successfulAttempts: 0 });
        },

        worstUserLastMonth() {
            const lastMonth = this.getLastMonth();
            const stats = Object.values(this.userStatsByMonth[lastMonth] || {});
            const worst = stats.reduce((worst, current) => {
                return current.unsuccessfulAttempts > worst.unsuccessfulAttempts ? current : worst;
            }, { unsuccessfulAttempts: 0 });

            if (worst.user === this.bestUserLastMonth.user) {
                return stats
                    .filter(user => user.user !== this.bestUserLastMonth.user)
                    .reduce((worst, current) => {
                        return current.unsuccessfulAttempts > worst.unsuccessfulAttempts ? current : worst;
                    }, { unsuccessfulAttempts: 0 });
            }
            return worst;
        }
    },
    methods: {
        translate,
        getMonthFromDate(dateString) {
            try {
                const date = new Date(dateString);
                return date.getMonth() + 1;
            } catch (error) {
                console.log("Error parsing date:", error);
                return 0;
            }
        },

        getLastMonth() {
            try {
                const now = new Date();
                now.setMonth(now.getMonth() - 1);
                return now.getMonth() + 1;
            } catch (error) {
                console.log("Error getting last month:", error);
                return 0;
            }
        },

        getStatusColor(status) {
            try {
                switch (status) {
                    case "Successful":
                        return "success";
                    case "Unsuccessful":
                        return "error";
                    case "Waiting":
                        return "warning";
                    default:
                        return "primary";
                }
            } catch (error) {
                console.log("Error getting status color:", error);
                return "primary";
            }
        },

        openMessageDialog(user) {
            try {
                this.selectedUserForMessage = user;
                this.messageDialog = true;
            } catch (error) {
                console.log("Error opening message dialog:", error);
            }
        },

        sendMessage() {
            try {
                const message = {
                    text: this.messageText,
                    image: this.messageImage,
                    user: this.selectedUserForMessage.user,
                };
                alert(`Message sent to ${message.user}:\nText: ${message.text}\nImage: ${message.image ? message.image.name : "None"}`);
                this.messageDialog = false;
                this.messageText = "";
                this.messageImage = null;
            } catch (error) {
                console.log("Error sending message:", error);
            }
        },

        openBlockUserDialog(user) {
            try {
                this.selectedUser = user;
                this.blockUserDialog = true;
            } catch (error) {
                console.log("Error opening block user dialog:", error);
            }
        },

        openApproveRefundDialog(refund) {
            try {
                this.selectedRefund = refund;
                this.approveRefundDialog = true;
            } catch (error) {
                console.log("Error opening approve refund dialog:", error);
            }
        },

        openRejectRefundDialog(refund) {
            try {
                this.selectedRefund = refund;
                this.rejectRefundDialog = true;
            } catch (error) {
                console.log("Error opening reject refund dialog:", error);
            }
        },

        blockUser() {
            try {
                alert(`${translate('Admin_Finance.user_blocked')}\n Message: ${this.blockUserNote}`);
                this.blockUserDialog = false;
                this.blockUserNote = "";
            } catch (error) {
                console.log("Error blocking user:", error);
            }
        },

        approveRefund() {
            try {
                const refund = this.selectedRefund;
                refund.status = "Approved";
                this.payments.push({
                    id: this.payments.length + 1,
                    user: refund.user,
                    amount: refund.amount,
                    date: new Date().toISOString().split('T')[0],
                    status: "Successful",
                    failedAttempts: 0,
                    userId: refund.userId,
                });
                this.refundRequests = this.refundRequests.filter(r => r.id !== refund.id);
                alert(`${translate('Admin_Finance.refund_approved')}\n Message: ${this.approveRefundNote}`);
                this.approveRefundDialog = false;
                this.approveRefundNote = "";
            } catch (error) {
                console.log("Error approving refund:", error);
            }
        },

        rejectRefund() {
            try {
                const refund = this.selectedRefund;
                refund.status = "Rejected";
                this.payments.push({
                    id: this.payments.length + 1,
                    user: refund.user,
                    amount: refund.amount,
                    date: new Date().toISOString().split('T')[0],
                    status: "Unsuccessful",
                    failedAttempts: 0,
                    userId: refund.userId,
                });
                this.refundRequests = this.refundRequests.filter(r => r.id !== refund.id);
                alert(`${translate('Admin_Finance.refund_rejected')}\n Message: ${this.rejectRefundNote}`);
                this.rejectRefundDialog = false;
                this.rejectRefundNote = "";
            } catch (error) {
                console.log("Error rejecting refund:", error);
            }
        }
    }
};
</script>

<style scoped>
.info-card.success {
    background: #d4edda;
    color: #155724;
}

.info-card.warning {
    background: #fff3cd;
    color: #856404;
}

.info-card.error {
    background: #f8d7da;
    color: #721c24;
}

.logo-image {
    width: 60px;
}

.header {
    z-index: 1000;
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    background-color: var(--background-color);
}

.v-btn {
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
}

.main-expanded {
    padding-left: 240px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
    padding-top: 64px;
}

.main-collapsed {
    padding-left: 80px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
}

@media (max-width: 600px) {
    .main-expanded,
    .main-collapsed {
        padding-left: 0;
    }
}
</style>
