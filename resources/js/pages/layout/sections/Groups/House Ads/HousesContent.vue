<template>
    <v-container :class="{ 'expanded-container': isExpanded }">
        <v-row>
            <v-col cols="12" class="d-flex justify-end">
                <v-btn icon @click="toggleExpand">
                    <v-icon>{{ isExpanded ? 'mdi-arrow-collapse' : 'mdi-arrow-expand' }}</v-icon>
                </v-btn>
                <v-btn icon @click="closeHousesContent">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-col>
            <v-col cols="12">
                <v-tabs vertical v-model="tab" class="pt-1">
                    <v-tab>
                        <v-icon left>mdi-home</v-icon>
                        {{ translate('housescontent.list') }}
                    </v-tab>
                    <v-tab>
                        <v-icon left>mdi-map</v-icon>
                        {{ translate('housescontent.map') }}
                    </v-tab>
                </v-tabs>
            </v-col>
        </v-row>

        <v-row class="ad-container">
            <v-col cols="12" v-show="tab === 0">
                <v-row class="mb-4">
                    <v-col v-for="(icon, index) in icons" :key="index" cols="2">
                        <v-btn
                            class="d-flex justify-center align-center icon-btn"
                            tile
                            @click="filterApartments(icon.name)"
                        >
                            <img :src="icon.src" alt="Icon" class="icon-img" />
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row class="d-flex flex-wrap">
                    <v-col
                        v-for="(item, index) in filteredApartments"
                        :key="index"
                        class="apartment-card-container"
                    >
                        <v-card class="apartment-card" @click="openApartmentDetail(item)">
                            <v-img :src="item.image" height="200px" class="apartment-img"></v-img>
                            <v-card-title class="apartment-title">
                                {{ item.location }}
                            </v-card-title>
                            <v-card-subtitle class="apartment-subtitle">
                                {{ item.host }}
                            </v-card-subtitle>
                            <v-card-text class="apartment-text">
                                <br />
                                {{ item.price }} {{ item.period }}
                            </v-card-text>
                            <v-btn color="primary" @click.stop="openReservationModal(item)">
                                {{ translate('housescontent.Quick_booking') }}
                            </v-btn>
                            <v-btn color="secondary" @click.stop="openChatModal(item)">
                                {{ translate('Ad.Chat') }}
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
                <v-dialog v-model="showChatModal" max-width="600px">
                    <v-card>
                        <v-card-title class="headline">
                            {{ translate('Ad.Chat') }}: {{ selectedHost }}
                        </v-card-title>
                        <v-card-text>
                            <div v-for="(message, index) in chatMessages[selectedApartmentId]" :key="index" class="message">
                                <strong>{{ message.sender }}:</strong> {{ message.text }}
                            </div>
                            <v-textarea
                                v-model="newMessage"
                                label="Write your message...."
                                outlined
                                @keyup.enter="sendMessage"
                            ></v-textarea>
                        </v-card-text>
                        <v-card-actions>
                            <v-btn color="primary" @click="sendMessage">Send</v-btn>
                            <v-btn color="error" @click="closeChatModal">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-row v-if="filteredApartments.length === 0">
                    <v-col cols="12" class="d-flex justify-center">
                        <v-alert type="error" outlined>
                            There are currently no ads available.
                        </v-alert>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="d-flex justify-center">
                        <v-btn
                            class="more-button"
                            color="primary"
                            @click="loadMoreApartments"
                        >
                            {{ translate('housescontent.seeMore') }}
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="12" v-if="tab === 1">
                <v-card>
                    <v-card-title>Map</v-card-title>
                    <HousesMap :apartments="filteredApartments" />
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="localShow" max-width="600px">
            <v-card class="Ads">
                <v-card-title class="headline primary--text text-center">
                    {{ translate('housescontent.Reservation_request') }}
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="4">
                            <v-img :src="selectedApartment?.image" height="200px" class="rounded-lg"></v-img>
                        </v-col>
                        <v-col cols="8" class="AdsSetting">
                            <v-card-subtitle class="AdsSetting2 text-h6 text-right">{{ selectedApartment?.host || "Uncertain" }}</v-card-subtitle>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('housescontent.Location') }}</strong> {{ selectedApartment?.location || "نامشخص" }}</p>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('housescontent.Owner') }}</strong> {{ selectedApartment?.host || "نامشخص" }}</p>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('housescontent.Price') }} </strong> {{ selectedApartment?.price || "0" }} یورو</p>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>
                    <h3 class="font-weight-bold mt-4 text-h5 text-center">{{ translate('housescontent.Your_details') }}</h3>
                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ reservation?.startDate || "?" }} to {{ reservation?.endDate || "?" }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <v-btn @click="showCalendar = true"  outlined>{{ translate('housescontent.Edit_date') }}</v-btn>
                        </v-col>

                    </v-row>

                    <v-dialog v-model="showCalendar" max-width="400px" centered persistent class="custom-dialog">
                        <v-card>
                            <v-card-title class="headline primary--text">{{ translate('Ad.available_dates') }}</v-card-title>
                            <v-card-text>
                                <v-date-picker v-model="selectedDates" multiple></v-date-picker>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="saveDates">{{ translate('Ad.SaveExit') }}</v-btn>
                                <v-btn color="grey" text @click="showCalendar = false">{{ translate('Ad.Back') }}</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ reservation?.guests || 1 }} {{ translate('housescontent.Guest') }} - {{ reservation?.name || "?" }}</p>
                        </v-col>
                        <v-col cols="6" class="d-flex justify-end">
                            <v-btn @click="editGuests" outlined> {{ translate('housescontent.Edit') }}</v-btn>
                        </v-col>
                    </v-row>

                    <v-dialog v-model="showEditGuestsModal" max-width="400px">
                        <v-card>
                            <v-card-title class="headline primary--text text-center">{{ translate('housescontent.Edit_guest2') }}</v-card-title>
                            <v-card-text>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="reservation.name"
                                            :label="translate('housescontent.Guest_name')"
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="reservation.guests"
                                            :label="translate('housescontent.Guest_number')"
                                            type="number"
                                            min="1"
                                            outlined
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn color="primary" @click="saveGuestInfo">{{ translate('housescontent.Save') }}</v-btn>
                                <v-btn color="error" @click="showEditGuestsModal = false">{{ translate('housescontent.close') }}</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>


                    <v-divider class="my-4"></v-divider>
                    <h3 class="font-weight-bold mt-4 text-h5 text-center AdsSetting">
                        {{ translate('housescontent.Payment_Details') }}
                    </h3>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ translate('housescontent.Project_Cost') }} * {{ translate('housescontent.Reserved_Days') }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="text-body-1">{{ basePrice || "0" }} {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ translate('housescontent.Extra_Fee_Owner') }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="text-body-1">{{ selectedApartment?.extraFee || 0 }} {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ translate('housescontent.Tax_10') }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="text-body-1">{{ tax }} {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <p class="font-weight-bold text-h6">{{ translate('housescontent.Total_Amount') }} ({{ translate('housescontent.Euro') }})</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="font-weight-bold text-h6">{{ total }} {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>


                    <v-divider class="my-4"></v-divider>
                    <h3 class="font-weight-bold mt-4 text-h5 AdsSetting text-center">{{ translate('housescontent.Pay_with') }}</h3>
                    <v-row>
                        <v-col cols="4">
                            <v-btn @click="selectedPayment = 'credit'" class="d-flex align-center" color="primary" outlined>
                                <v-icon left>mdi-credit-card</v-icon>Credit card
                            </v-btn>
                        </v-col>
                        <v-col cols="4">
                            <v-btn @click="selectedPayment = 'paypal'" class="d-flex align-center" color="primary" outlined>
                                <v-icon left>mdi-paypal</v-icon>PayPal
                            </v-btn>
                        </v-col>
                        <v-col cols="4">
                            <v-btn @click="selectedPayment = 'maestro'" class="d-flex align-center" color="primary" outlined>
                                <v-icon left>mdi-bank</v-icon>Maestro
                            </v-btn>
                        </v-col>
                    </v-row>
                    <v-divider class="my-4"></v-divider>
                    <p class="text-body-1 text-center">{{ translate('housescontent.Free') }}</p>
                    <v-divider class="my-4"></v-divider>
                    <v-row>
                        <v-col cols="6" class="text-left">
                            <v-btn color="primary">{{ translate('housescontent.Payment') }}</v-btn>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <v-btn color="error" @click="closeModal">{{ translate('housescontent.close') }}</v-btn>
                        </v-col>
                    </v-row>

                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="showDetail" max-width="800px" >
            <v-card class="Ads">
                <v-card-title class="headline">{{ translate('housescontent.Ad_details') }}</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <v-img :src="selectedApartment?.image" height="200px"></v-img>
                        </v-col>
                        <v-col cols="6" class="AdsSetting">
                            <p><strong>Owner's name:</strong> {{ selectedApartment?.host || "Uncertain" }}</p>
                            <p><strong>Price:</strong> {{ selectedApartment?.price || "Uncertain" }} {{ selectedApartment?.period || "Uncertain" }}</p>
                            <p><strong>Location:</strong> {{ selectedApartment?.location || "Uncertain" }}</p>
                            <p><strong>Property type:</strong> {{ selectedApartment?.type || "Uncertain" }}</p>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="error" @click="showDetail = false">{{ translate('housescontent.close') }}</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </v-container>
</template>


<script>
import { translate } from "@/store/languageStore";
import HousesMap from "./HousesMap.vue";
import UserSidebar from '../../../../Users/Layout.vue';

export default {
    setup() {
        return { translate };
    },

    components: {
        HousesMap,
        UserSidebar,
    },
    data() {
        return {
            selectedApartmentId: null,
            showChatModal: false,
            chatMessages: [],
            newMessage: '',
            selectedHost: '',
            showEditGuestsModal: false,
            isExpanded: false,
            showCalendar: false,
            selectedDates: [],
            reservation: {
                startDate: "2023-10-01",
                endDate: "2023-10-05",
                guests: 2,
                name: "نام رزرو کننده",
                days: 4,
            },
            showReservationModal: {},
            selectedApartment: null,
            tab: 0,
            selectedType: null,
            icons: [
                { name: 'home', src: '/home-icon.png' },
                { name: 'apartment', src: '/apartment-icon.png' },
                { name: 'furniture', src: '/furniture-icon.png' },
                { name: 'bed', src: '/bed-icon.png' },
                { name: 'car', src: '/car-icon.png' },
                { name: 'tent', src: '/tent-icon.png' },
            ],
            apartments: [
                {
                    id: 1,
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
                    id: 2,
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
                    id: 3,
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
                    id:4,
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
                    id: 5,
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
                    id: 6,
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
            filteredApartments: [],
            loading: false,
            showDetail: false,
            MyReservations: [],
            localShow: false,
            selectedPayment: null,
        };
    },
    computed: {
        isLoggedIn() {
            return !!this.$store.state.user;
        },
        total() {
            let basePrice = parseFloat(this.selectedApartment?.price.replace('€', '').trim()) || 0;
            let days = this.reservation?.days || 0;
            let extraFee = this.selectedApartment?.extraFee || 0;
            let tax = (basePrice * days + extraFee) * 0.10;
            let totalPrice = (basePrice * days) + extraFee + tax;
            return totalPrice.toFixed(2);
        },
        basePrice() {
            let basePrice = parseFloat(this.selectedApartment?.price.replace('€', '').trim()) || 0;
            let days = this.reservation?.days || 0;
            return (basePrice * days).toFixed(2);
        },
        tax() {
            let basePrice = parseFloat(this.selectedApartment?.price.replace('€', '').trim()) || 0;
            let days = this.reservation?.days || 0;
            let extraFee = this.selectedApartment?.extraFee || 0;
            return ((basePrice * days + extraFee) * 0.10).toFixed(2);
        }
    },
    methods: {
        openChatModal(item) {
            this.selectedHost = item.host;
            this.selectedApartmentId = item.id;
            if (!this.chatMessages[item.id]) {
                this.chatMessages[item.id] = [];
            }
            this.showChatModal = true;
        },
        closeChatModal() {
            this.showChatModal = false;
            this.newMessage = '';
        },
        toggleExpand() {
            this.isExpanded = !this.isExpanded;
            this.$emit('expand', this.isExpanded);
        },
        sendMessage() {
            if (this.newMessage.trim()) {
                const sanitizedMessage = this.sanitizeMessage(this.newMessage);
                this.chatMessages[this.selectedApartmentId].push({
                    sender: 'User',
                    text: sanitizedMessage
                });
                this.newMessage = '';
            }
        },
        sanitizeMessage(message) {
            message = message.replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, '***');
            message = message.replace(/(\+|0)?9\d{9}/g, '***');
            return message;
        },

        saveTemporaryReservation() {
            this.MyReservations.push({
                ...this.reservation,
                apartment: this.selectedApartment,
                paymentStatus: 'pending'
            });

            this.openPaymentModal();
        },

        openPaymentModal() {
            this.localShow = true;
        },
        saveDates() {
            let startDate = new Date(this.selectedDates[0]);
            let endDate = new Date(this.selectedDates[this.selectedDates.length - 1]);
            let days = Math.floor((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            this.reservation.startDate = this.selectedDates[0];
            this.reservation.endDate = this.selectedDates[this.selectedDates.length - 1];
            this.reservation.days = days;
            this.showCalendar = false;
        },
        openReservationModal(apartment) {
            this.selectedApartment = apartment;
            this.localShow = true;
        },
        filterApartments(type) {
            this.selectedType = type;
            this.filteredApartments = this.apartments.filter(
                apartment => apartment.type === type
            );
        },
        async loadMoreApartments() {
            if (this.loading) return;
            this.loading = true;

            const newApartments = [
                {
                    id: 10,
                    location: "آنتورپ،بلژیک",
                    host: "میزبان علی",
                    rating: "4.5",
                    price: "€ 25",
                    period: "روزانه",
                    type: "apartment",
                    image: "rectangle-2200.png",
                    coordinates: [51.2194, 4.4025],
                },
            ];

            this.apartments = this.apartments.concat(newApartments);

            if (this.selectedType) {
                this.filteredApartments = this.apartments.filter(
                    apartment => apartment.type === this.selectedType
                );
            } else {
                this.filteredApartments = this.apartments;
            }

            this.loading = false;
        },
        openApartmentDetail(item) {
            this.selectedApartment = item;
            this.showDetail = true;
        },
        closeModal() {
            this.localShow = false;
        },

        editGuests() {
            this.showEditGuestsModal = true;
        },
        saveGuestInfo() {
            this.showEditGuestsModal = false;
        },
        closeHousesContent() {
            this.$emit('close');
            this.localShow = false;
        },
    },
    mounted() {
        this.filteredApartments = this.apartments;
    },
};

</script>

<style scoped>

.ad-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
}

@media (max-width: 960px) {
    .ad-container {
        flex-direction: column;
        align-items: flex-start;
    }

    .ad-container .v-col {
        width: 100%;
        margin-bottom: 20px;
    }
}

.apartment-card {
    background-color: var(--sidebar-background-color);
    color: var(--text-color);
}
.icon-btn {
    transition: transform 0.3s ease;
    background-color: var(--background-color);
    width: 50px;
    height: 50px;

}
.message {
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 8px;
    background-color: #38383a;
}

.v-textarea {
    margin-top: 20px;
}

.v-card {
    border-radius: 12px;
}
.icon-btn:hover {
    transform: scale(1.1);
}
.icon-img {
    width: 50px;
    height: 50px;
    transition: transform 0.3s ease;
    background-color: var(--background-color);
}

.icon-btn:hover .icon-img {
    transform: scale(1.2);
}

.v-container {
    transition: all 0.3s ease;
}
.v-container.expanded {
    max-width: 100%;
    margin: 0 auto;
}

#map {
  height: 85vh;
  width: 100%;
}
.AdsSetting{
    margin-top: 30px;
    margin-bottom: 10px;
    padding-top: 10px;
    alignment: center;
}
.AdsSetting2{
    margin-top: 15px;

}

.Ads {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.headline {
    font-size: 24px;
    font-weight: bold;
    color: #1976D2;
}

.text-h6 {
    font-size: 18px;
    font-weight: bold;
}

.text-body-1 {
    font-size: 16px;
    color: #ece3e3;
}
.expanded-container {
    max-width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
}

.primary--text {
    color: #1976D2 !important;
}

.rounded-lg {
    border-radius: 12px;
}

.custom-dialog {
    border-radius: 12px;
}
</style>
