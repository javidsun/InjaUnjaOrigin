<!--فایل  TravelersContent.js در services      فایل   TravelersContent.json در پوشه docs -->


<template>
    <v-container :class="{ 'expanded-container': isExpanded }">
        <v-row>
            <v-col cols="12" class="d-flex justify-end">
                <v-btn icon @click="toggleExpand">
                    <v-icon>{{ isExpanded ? 'mdi-arrow-collapse' : 'mdi-arrow-expand' }}</v-icon>
                </v-btn>
                <v-btn icon @click="closeCompanionContent">
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
                    <v-col v-for="(icon, index) in travelIcons" :key="index" cols="2">
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    class="d-flex flex-column justify-center align-center icon-btn"
                                    tile
                                    @click="filterCompanions(icon.name)"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <img :src="icon.src" alt="Icon" class="icon-img" />
                                </v-btn>
                            </template>
                            <span>{{ translate(`companioncontent.categories.${icon.name}`) }}</span>
                        </v-tooltip>
                    </v-col>
                    <v-col cols="2">
                        <v-tooltip top>
                            <template v-slot:activator="{ on, attrs }">
                                <v-btn
                                    class="d-flex flex-column justify-center align-center icon-btn"
                                    tile
                                    @click="filterCompanions('all')"
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                    <v-icon large>mdi-format-list-bulleted</v-icon>
                                    <span class="mt-1">{{ translate('companioncontent.categories.all') }}</span>
                                </v-btn>
                            </template>
                            <span>{{ translate('companioncontent.categories.all') }}</span>
                        </v-tooltip>
                    </v-col>
                </v-row>

                <v-row class="d-flex flex-wrap">
                    <v-col
                        v-for="(item, index) in filteredCompanions"
                        :key="index"
                        class="companion-card-container"
                        cols="12" sm="6" md="4" lg="4"
                    >
                        <v-card class="companion-card" @click="openCompanionDetail(item)">
                            <v-img :src="item.image" height="200px" class="companion-img"></v-img>
                            <v-card-title class="companion-title">
                                {{ item.destination }}
                            </v-card-title>
                            <v-card-subtitle class="companion-subtitle">
                                {{ item.user.name }} • {{ item.user.age }} {{ translate('years') }}
                            </v-card-subtitle>
                            <v-card-text class="companion-text">
                                <v-chip small :color="getGenderColor(item.user.gender)" class="mr-1">
                                    {{ translateGender(item.user.gender) }}
                                </v-chip>
                                <v-chip small color="primary" class="mr-1">
                                    {{ item.travelDates }}
                                </v-chip>
                                <v-chip small color="secondary">
                                    {{ item.budget }} €
                                </v-chip>
                                <v-chip small class="mt-1" color="teal" text-color="white">
                                    {{ translateTravelStyle(item.travelStyle) }}
                                </v-chip>
                            </v-card-text>

                            <v-card-actions class="justify-space-between">
                                <v-btn class="btncolor" @click.stop="openReservationModal(item)">
                                    {{ translate('housescontent.Quick_booking') }}
                                </v-btn>
                                <v-btn class="btncolor2" @click.stop="openContactModal(item)" small>
                                    {{ translate('companioncontent.contact') }}
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row v-if="filteredCompanions.length === 0">
                    <v-col cols="12" class="d-flex justify-center">
                        <v-alert type="info" outlined>
                            {{ translate('companioncontent.no_companions') }}
                        </v-alert>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="12" class="d-flex justify-center">
                        <v-btn
                            class="more-button"
                            color="primary"
                            @click="loadMoreCompanions"
                            :loading="loading"
                        >
                            {{ translate('companioncontent.seeMore') }}
                        </v-btn>
                    </v-col>
                </v-row>
            </v-col>

            <v-col cols="12" v-if="tab === 1">
                <v-card>
                    <v-card-title>{{ translate('companioncontent.map_title') }}</v-card-title>
                    <CompanionMap :companions="filteredCompanions" />
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="showReservationModal" max-width="600px">
            <v-card class="Ads">
                <v-card-title class="headline primary--text text-center">
                    {{ translate('housescontent.Reservation_request') }}
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="4">
                            <v-img :src="selectedCompanion?.image" height="200px" class="rounded-lg"></v-img>
                        </v-col>
                        <v-col cols="8" class="AdsSetting">
                            <v-card-subtitle class="AdsSetting2 text-h6 text-right">{{ selectedCompanion?.user.name || "Uncertain" }}</v-card-subtitle>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('housescontent.Location') }}</strong> {{ selectedCompanion?.destination || "نامشخص" }}</p>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('companioncontent.dates') }}</strong> {{ selectedCompanion?.travelDates || "نامشخص" }}</p>
                            <p class="AdsSetting2 text-body-1 text-right"><strong>{{ translate('companioncontent.budget') }}</strong> {{ selectedCompanion?.budget || "0" }} €</p>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>
                    <h3 class="font-weight-bold mt-4 text-h5 text-center">{{ translate('housescontent.Your_details') }}</h3>
                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ reservation?.startDate || "?" }} to {{ reservation?.endDate || "?" }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <v-btn @click="showCalendar = true" outlined>{{ translate('housescontent.Edit_date') }}</v-btn>
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
                    <h3 class="font-weight-bold mt-4 text-h5 text-center">
                        {{ translate('housescontent.Payment_Details') }}
                    </h3>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ translate('housescontent.Service_Fee') }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="text-body-1">15.00 {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <p class="text-body-1">{{ translate('housescontent.Tax_10') }}</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="text-body-1">1.50 {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-row>
                        <v-col cols="6">
                            <p class="font-weight-bold text-h6">{{ translate('housescontent.Total_Amount') }} ({{ translate('housescontent.Euro') }})</p>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <p class="font-weight-bold text-h6">16.50 {{ translate('housescontent.Euro') }}</p>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>
                    <h3 class="font-weight-bold mt-4 text-h5 text-center">{{ translate('housescontent.Pay_with') }}</h3>
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
                            <v-btn color="primary" @click="confirmReservation">{{ translate('housescontent.Payment') }}</v-btn>
                        </v-col>
                        <v-col cols="6" class="text-right">
                            <v-btn color="error" @click="closeReservationModal">{{ translate('housescontent.close') }}</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="showContactModal" max-width="600px">
            <v-card class="companion-contact-card">
                <v-card-title class="headline primary--text text-center">
                    {{ translate('companioncontent.contact_title') }}
                </v-card-title>

                <v-card-text>
                    <v-row>
                        <v-col cols="4">
                            <v-img :src="selectedCompanion?.image" height="200px" class="rounded-lg"></v-img>
                        </v-col>
                        <v-col cols="8" class="companion-details">
                            <v-card-subtitle class="text-h6">
                                {{ selectedCompanion?.user.name || translate('Uncertain') }}
                            </v-card-subtitle>
                            <p><strong>{{ translate('companioncontent.destination') }}</strong> {{ selectedCompanion?.destination || translate('Uncertain') }}</p>
                            <p><strong>{{ translate('companioncontent.dates') }}</strong> {{ selectedCompanion?.travelDates || translate('Uncertain') }}</p>
                            <p><strong>{{ translate('companioncontent.budget') }}</strong> {{ selectedCompanion?.budget || "0" }} €</p>
                            <p><strong>{{ translate('companioncontent.travel_style') }}</strong> {{ translateTravelStyle(selectedCompanion?.travelStyle) }}</p>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>

                    <h3 class="font-weight-bold mt-4 text-h5 text-center">
                        {{ translate('companioncontent.contact_form') }}
                    </h3>

                    <div class="chat-container mt-4">
                        <div class="chat-messages" ref="chatMessages">
                            <div v-for="(message, index) in chatMessages[selectedCompanion?.id]" :key="index"
                                 :class="['message-bubble', message.sender === 'User' ? 'customer' : 'host']">
                                <div class="message-content">
                                    <div class="message-text">{{ message.text }}</div>
                                    <div class="message-time">{{ formatMessageTime(message.timestamp) }}</div>
                                </div>
                            </div>
                            <div v-if="!chatMessages[selectedCompanion?.id]?.length" class="empty-chat text-center py-4">
                                {{ translate('companioncontent.no_messages') }}
                            </div>
                        </div>

                        <v-form @submit.prevent="sendMessage" class="mt-3">
                            <v-textarea
                                v-model="newMessage"
                                :label="translate('companioncontent.message_label')"
                                outlined
                                rows="2"
                                auto-grow
                                :placeholder="translate('companioncontent.type_message')"
                                hide-details
                                class="message-input"
                                @keydown.enter.exact.prevent="sendMessage"
                            ></v-textarea>

                        </v-form>
                    </div>

                    <v-divider class="my-4"></v-divider>

                    <v-row>
                        <v-col cols="6" >
                            <v-btn  color="primary" @click="sendMessage" :loading="sendingRequest">
                                {{ translate('companioncontent.send_request') }}
                            </v-btn>
                        </v-col>
                        <v-col cols="6" class="text-right">

                            <v-btn color="error" @click="closeContactModal" depressed>
                                {{ translate('companioncontent.close') }}
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog v-model="showDetail" max-width="800px">
            <v-card class="companion-detail-card">
                <v-card-title class="headline">{{ translate('companioncontent.detail_title') }}</v-card-title>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <v-carousel>
                                <v-carousel-item
                                    v-for="(img, i) in selectedCompanion?.images"
                                    :key="i"
                                    :src="img"
                                ></v-carousel-item>
                            </v-carousel>
                        </v-col>
                        <v-col cols="6" class="companion-info">
                            <h3 class="text-h5">{{ selectedCompanion?.destination }}</h3>
                            <p><strong>{{ translate('companioncontent.user') }}</strong> {{ selectedCompanion?.user.name }}, {{ selectedCompanion?.user.age }} {{ translate('years') }}</p>
                            <p><strong>{{ translate('companioncontent.gender') }}</strong> {{ translateGender(selectedCompanion?.user.gender) }}</p>
                            <p><strong>{{ translate('companioncontent.dates') }}</strong> {{ selectedCompanion?.travelDates }}</p>
                            <p><strong>{{ translate('companioncontent.budget') }}</strong> {{ selectedCompanion?.budget }} €</p>
                            <p><strong>{{ translate('companioncontent.style') }}</strong> {{ translateTravelStyle(selectedCompanion?.travelStyle) }}</p>
                            <p><strong>{{ translate('companioncontent.description') }}</strong> {{ selectedCompanion?.description }}</p>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="openContactModal(selectedCompanion)">
                        {{ translate('companioncontent.contact') }}
                    </v-btn>
                    <v-btn color="error" @click="showDetail = false">
                        {{ translate('companioncontent.close') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>

</template>

<script>
import { translate } from "../../../../../store/languageStore";
import CompanionMap from "./CompanionMap.vue";
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import axios from 'axios';

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png',
    iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
    shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png'
});

export default {
    setup() {
        return { translate };
    },

    components: {
        CompanionMap,

    },
    data() {
        return {
            showReservationModal: false,
            showSnackbar: false,
            snackbarMessage: '',
            snackbarColor: 'success',
            selectedPayment: null,
            reservation: {
                startDate: "2025-04-10",
                endDate: "2025-04-15",
                guests: 1,
                name: "",
                days: 5,
            },
            selectedDates: [],
            showCalendar: false,
            showEditGuestsModal: false,
            map: null,
            originQuery: '',
            destinationQuery: '',
            origin: null,
            destination: null,
            routeLayer: null,
            originMarker: null,
            destinationMarker: null,
            companionMarkers: [],
            routeDistance: null,
            routeDuration: null,
            showCompanionDetail: false,
            isExpanded: false,
            tab: 0,
            loading: false,
            sendingRequest: false,
            showDetail: false,
            showContactModal: false,
            showChatModal: false,
            selectedCompanion: null,
            selectedUser: '',
            selectedCompanionId: null,
            contactMessage: '',
            newMessage: '',
            chatMessages: {},
            markerIcons: {
                origin: '/map-marker-origin.png',
                destination: '/map-marker-destination.png',
                male: '/map-marker-male.png',
                female: '/map-marker-female.png',
                neutral: '/map-marker-origin.png'
            },
            selectedTravelStyle: null,
            travelIcons: [
                { name: 'backpacker', src: '/Travel 009.png' },
                { name: 'family', src: '/family.png' },
                { name: 'couple', src: '/couple.png' },
                { name: 'business', src: '/business.png' },
                { name: 'adventure', src: '/adventure.png' },
                { name: 'luxury', src: '/luxury.png' },
            ],
            companions: [
                {
                    id: 1,
                    destination: "Paris, France",
                    user: {
                        name: "Sara",
                        age: 28,
                        gender: "female",
                        rating: 4.7
                    },
                    travelDates: "2025 April 10-15",
                    budget: "1200",
                    travelStyle: "backpacker",
                    description: "Looking for a female travel companion for an economical trip to Paris and visiting cultural attractions",
                    image: "/1010.png",
                    images: ["/1010.png", "/1020.png"],
                    coordinates: [48.8566, 2.3522],
                    personalityTraits: ["Cultural", "Thrifty", "Independent"]
                },
                {
                    id: 2,
                    destination: "Rome, Italy",
                    user: {
                        name: "Ali",
                        age: 32,
                        gender: "male",
                        rating: 4.9
                    },
                    travelDates: "2025 Feb 11-15",
                    budget: "1500",
                    travelStyle: "cultural",
                    description: "Interested in history and architecture, looking for a travel companion to visit museums and historical monuments",
                    image: "/1030.png",
                    images: ["/1010.png"],
                    coordinates: [41.9028, 12.4964],
                    personalityTraits: ["Culturated", "polite", "orderly"]
                },
                {
                    id: 3,
                    destination: "Barcelona, Spain",
                    user: {
                        name: "Nazanin",
                        age: 25,
                        gender: "female",
                        rating: 4.5
                    },
                    travelDates: "All Summer",
                    budget: "800",
                    travelStyle: "backpacker",
                    description: "Looking for a travel companion to experience local life and couch surfing",
                    image: "/1020.png",
                    images: ["/1020.png"],
                    coordinates: [41.3851, 2.1734],
                    personalityTraits: ["Adventurous", "Intimate", "Flexible"]
                },
                {
                    id: 4,
                    destination: "Amsterdam, Netherlands",
                    user: {
                        name: "Reza",
                        age: 35,
                        gender: "male",
                        rating: 4.8
                    },
                    travelDates: "2025 JUN 20-30",
                    budget: "2000",
                    travelStyle: "business",
                    description: "Business trip with free time for sightseeing, suitable for professional travelers",
                    image: "/1010.png",
                    images: ["/1010.png"],
                    coordinates: [52.3676, 4.9041],
                    personalityTraits: ["professional", "regular", "moderate"]
                },
                {
                    id: 5,
                    destination: "Vienna, Austria",
                    user: {
                        name: "Taraneh",
                        age: 30,
                        gender: "female",
                        rating: 4.9
                    },
                    travelDates: "2025 MAY 01-15",
                    budget: "1800",
                    travelStyle: "luxury",
                    description: "Looking for a female travel companion to stay in luxury hotels and fine restaurants",
                    image: "/1030.png",
                    images: ["/1030.png"],
                    coordinates: [48.2082, 16.3738],
                    personalityTraits: ["entertaining", "hospitable", "classy"]
                },
                {
                    id: 6,
                    destination: "Berlin, Germany",
                    user: {
                        name: "Amir",
                        age: 27,
                        gender: "male",
                        rating: 4.6
                    },
                    travelDates: "2025 April 01-15",
                    budget: "1000",
                    travelStyle: "adventure",
                    description: "Interested in adventure tours and nature tourism",
                    image: "/1020.png",
                    images: ["/1010.png"],
                    coordinates: [52.5200, 13.4050],
                    personalityTraits: ["Adventurous", "Lively", "Intimate"]
                }
            ],
            filteredCompanions: [],
            messageRules: [
                v => !!v || 'Message is required.',
                v => (v && v.length >= 20) || 'The message must be at least 20 characters long.'
            ]
        };
    },
    computed: {
        isLoggedIn() {
            return !!this.$store.state.user;
        },
        currentChatMessages() {
            if (!this.chatMessages[this.selectedCompanionId]) {
                this.$set(this.chatMessages, this.selectedCompanionId, []);
            }
            return this.chatMessages[this.selectedCompanionId];
        }
    },
    methods: {
        openReservationModal(companion) {
            this.selectedCompanion = companion;
            this.showReservationModal = true;


            if (companion.travelDates) {
                const dates = companion.travelDates.match(/\d{4} [A-Za-z]+ \d{1,2}-\d{1,2}/);
                if (dates) {
                    const [year, month, dayRange] = dates[0].split(' ');
                    const [startDay, endDay] = dayRange.split('-');

                    this.reservation.startDate = `${year}-${this.getMonthNumber(month)}-${startDay.padStart(2, '0')}`;
                    this.reservation.endDate = `${year}-${this.getMonthNumber(month)}-${endDay.padStart(2, '0')}`;

                    const start = new Date(this.reservation.startDate);
                    const end = new Date(this.reservation.endDate);
                    this.reservation.days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                }
            }
        },

        getMonthNumber(monthName) {
            const months = {
                'January': '01', 'February': '02', 'March': '03', 'April': '04', 'May': '05', 'June': '06',
                'July': '07', 'August': '08', 'September': '09', 'October': '10', 'November': '11', 'December': '12'
            };
            return months[monthName] || '01';
        },

        closeReservationModal() {
            this.showReservationModal = false;
        },

        saveDates() {
            if (this.selectedDates.length >= 2) {
                this.selectedDates.sort();
                this.reservation.startDate = this.selectedDates[0];
                this.reservation.endDate = this.selectedDates[this.selectedDates.length - 1];

                const start = new Date(this.reservation.startDate);
                const end = new Date(this.reservation.endDate);
                this.reservation.days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
            }
            this.showCalendar = false;
        },

        editGuests() {
            this.showEditGuestsModal = true;
        },

        saveGuestInfo() {
            this.showEditGuestsModal = false;
        },

        confirmReservation() {
            this.showNotification('Reservation confirmed successfully!');
            this.showReservationModal = false;
        },
        showNotification(message, color = 'success') {
            this.snackbarMessage = message;
            this.snackbarColor = color;
            this.showSnackbar = true;
        },

        translateGender(gender) {
            return gender === 'male' ? 'مرد' : gender === 'female' ? 'زن' : 'مهم نیست';
        },

        translateTravelStyle(style) {
            return this.translate(`companioncontent.categories.${style}`) || style;
        },

        getGenderColor(gender) {
            return gender === 'female' ? 'pink' : gender === 'male' ? 'blue' : 'grey';
        },

        toggleExpand() {
            this.isExpanded = !this.isExpanded;
            this.$emit('expand', this.isExpanded);
        },

        closeCompanionContent() {
            this.$emit('close');
        },
        formatMessageTime(timestamp) {
            if (!timestamp) return '';
            const date = new Date(timestamp);
            return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },

        openChatModal(item) {
            this.selectedCompanion = item;
            this.selectedCompanionId = item.id;
            this.selectedUser = item.user.name;

            if (!this.chatMessages[item.id]) {
                this.$set(this.chatMessages, item.id, []);
            }

            this.showChatModal = true;
        },

        openContactModal(item) {
            try {
                // if (!this.isLoggedIn) {
                //     this.showNotification(this.translate('login_required'), 'error');
                //     return;
                // }

                if (!item) {
                    console.error('No companion item provided');
                    return;
                }

                this.selectedCompanion = item;
                this.selectedCompanionId = item.id;
                if (!this.chatMessages[item.id]) {
                    this.chatMessages[item.id] = [];
                }
                this.showContactModal = true;
            } catch (error) {
                console.error('Error opening contact modal:', error);
                this.showNotification(this.translate('error_occurred'), 'error');
            }
        },

        async loadMoreCompanions() {
            if (this.loading) return;
            this.loading = true;

            try {
                // شبیه‌سازی دریافت داده از API
                await new Promise(resolve => setTimeout(resolve, 1000));

                const newCompanions = [
                    {
                        id: 10,
                        destination: "Prague, Czech Republic",
                        user: {
                            name: "Nader",
                            age: 31,
                            gender: "male",
                            rating: 4.8
                        },
                        travelDates: "2025 April 02-15",
                        budget: "1100",
                        travelStyle: "cultural",
                        description: "Interested in photographing historical architecture",
                        image: "/1010.png",
                        images: ["/1030.png"],
                        coordinates: [50.0755, 14.4378],
                        personalityTraits: ["creative", "passionate", "tasteful"]
                    }
                ];

                this.companions = this.companions.concat(newCompanions);

                if (this.selectedTravelStyle) {
                    this.filteredCompanions = this.companions.filter(
                        companion => companion.travelStyle === this.selectedTravelStyle
                    );
                } else {
                    this.filteredCompanions = this.companions;
                }
            } catch (error) {
                console.error('Error loading more companions:', error);
                this.showNotification('Error receiving companion information', 'error');
            } finally {
                this.loading = false;
            }
        },

        async sendContactRequest() {
            if (this.$refs.contactForm.validate()) {
                this.sendingRequest = true;
                try {
                    // شبیه‌سازی ارسال درخواست
                    await new Promise(resolve => setTimeout(resolve, 1500));

                    this.$store.dispatch('sendCompanionRequest', {
                        companionId: this.selectedCompanion.id,
                        message: this.contactMessage
                    });

                    this.closeContactModal();
                        this.showNotification('Your request has been sent successfully.');
                } catch (error) {
                    console.error('Error sending contact request:', error);
                    this.showNotification('Error sending request', 'error');
                } finally {
                    this.sendingRequest = false;
                }
            }
        },

        getCompanionIcon(companion) {
            if (companion.user.gender === 'female') {
                return this.markerIcons.female;
            } else if (companion.user.gender === 'male') {
                return this.markerIcons.male;
            }
            return this.markerIcons.neutral;
        },

        closeChatModal() {
            this.showChatModal = false;
            this.newMessage = '';
        },

        sendMessage() {
            if (this.newMessage.trim()) {
                const sanitizedMessage = this.sanitizeMessage(this.newMessage);

                if (!this.chatMessages[this.selectedCompanionId]) {
                    this.chatMessages[this.selectedCompanionId] = [];
                }

                this.chatMessages[this.selectedCompanionId].push({
                    sender: 'User',
                    text: sanitizedMessage
                });
                this.newMessage = '';

                // شبیه‌سازی پاسخ
                setTimeout(() => {
                    this.chatMessages[this.selectedCompanionId].push({
                        sender: 'Companion',
                        text: 'Your message has been received. I will respond soon.'
                    });
                }, 1000);
            }
        },

        sanitizeMessage(message) {
            message = message.replace(/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/g, '***');
            message = message.replace(/(\+|0)?9\d{9}/g, '***');
            return message;
        },

        filterCompanions(style) {
            this.selectedTravelStyle = style === 'all' ? null : style;
            if (this.selectedTravelStyle) {
                this.filteredCompanions = this.companions.filter(
                    companion => companion.travelStyle === this.selectedTravelStyle
                );
            } else {
                this.filteredCompanions = this.companions;
            }
        },

        openCompanionDetail(item) {
            this.selectedCompanion = item;
            this.showDetail = true;
        },


        closeContactModal() {
            this.showContactModal = false;
            this.newMessage = '';
        },

    },
    mounted() {
        this.filteredCompanions = this.companions;
    }
};

</script>

<style scoped>
.Ads {
    border-radius: 15px;
}

.AdsSetting {
    direction: rtl;
    text-align: right;
}

.AdsSetting2 {
    direction: rtl;
    text-align: right;
    margin-bottom: 10px;
}

.expanded-container {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
}
.companion-card {
    background-color: var(--sidebar-background-color);
    color: var(--text-color);
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.companion-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.companion-img {
    object-fit: cover;
}

.companion-title {
    font-size: 1.1rem;
    font-weight: bold;
    padding-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.companion-subtitle {
    padding-top: 0;
    color: var(--text-color);
}

.companion-text {
    padding-top: 0;
    padding-bottom: 0;
    flex-grow: 1;
}

.companion-contact-card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.companion-detail-card {
    border-radius: 12px;
}

.companion-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.companion-info {
    padding: 20px;
}

.icon-btn {
    transition: transform 0.3s ease;
    background-color: var(--background-color);
    width: 100%;
    height: 100%;
    padding: 8px;
    flex-direction: column;
}

.icon-img {
    width: 50px;
    height: 50px;
    transition: transform 0.3s ease;
    background-color: var(--background-color);
}

.icon-btn:hover .icon-img {
    transform: scale(1.1);
}

.ad-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 20px;
    margin-bottom: 40px;
}

.chat-messages {
    height: 300px;
    overflow-y: auto;
    padding: 10px;
    border: 1px solid #eee;
    border-radius: 4px;
    margin-bottom: 10px;
}

.chat-container {
    border-radius: 8px;
    padding: 12px;
    background-color: #242426;
}

.chat-messages {
    height: 300px;
    overflow-y: auto;
    padding: 8px;
    margin-bottom: 16px;
    display: flex;
    flex-direction: column;
    background-color: #242426;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.empty-chat {
    color: #9e9e9e;
    font-style: italic;
}

.message-bubble {
    max-width: 80%;
    margin-bottom: 8px;
    display: flex;
    flex-direction: column;
}

.message-bubble.customer {
    align-self: flex-end;
}

.message-bubble.host {
    align-self: flex-start;
}

.message-content {
    padding: 8px 12px;
    border-radius: 18px;
    position: relative;
}


.sent .message-content {
    background-color: #585d5e;
    color: white;
    border-bottom-right-radius: 4px;
}

.received .message-content {
    background-color: #ffffff;
    color: #333;
    border-bottom-left-radius: 4px;
}

.message-text {
    word-wrap: break-word;
    line-height: 1.4;
}

.message-time {
    font-size: 0.7rem;
    margin-top: 4px;
    opacity: 0.8;
    text-align: right;
}

.sent .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.received .message-time {
    color: rgba(0, 0, 0, 0.6);
}

.message-input {
    background-color: #3b3b3b;
    border-radius: 8px;
}
.customer .message-content {
    background-color: #1976d2;
    color: white;
    border-bottom-right-radius: 4px;
}

.host .message-content {
    background-color: #4caf50;
    color: white;
    border-bottom-left-radius: 4px;
}

.message-text {
    word-wrap: break-word;
    line-height: 1.4;
}

.message-time {
    font-size: 0.7rem;
    margin-top: 4px;
    opacity: 0.8;
    text-align: right;
}

.customer .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.host .message-time {
    color: rgba(255, 255, 255, 0.8);
}
.chat-messages::-webkit-scrollbar {
    width: 6px;
}

.chat-messages::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
}

.chat-messages::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
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

    .companion-card-container {
        padding: 8px;
    }

}
.btncolor{
    background-color: #0f5b1e;
}
.btncolor2{
    background-color: #033d6b;
}

</style>
