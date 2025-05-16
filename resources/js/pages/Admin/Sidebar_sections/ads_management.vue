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
            <Darkmood class="darkmood"/>
            <LanguageSwitcher class="language" />
        </v-app-bar>

        <Sidebar app v-model="drawer" />

        <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
            <v-container fluid>
                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-2 rounded-lg border1">
                            <v-card-title class="text-h5 primary--text">
                                <v-icon class="mr-2">mdi-bullhorn</v-icon>
                                {{ translate('Admin_AdManagement.ad_management') }}
                            </v-card-title>
                            <v-card-subtitle class="text-body2">
                                {{ translate('Admin_AdManagement.ad_list_and_actions') }}
                            </v-card-subtitle>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="12">
                        <v-card class="elevation-2 rounded-lg border1">
                            <v-card-title>
                                <v-btn color="primary" @click="openAdDialog" elevation="2" rounded>
                                    {{ translate('Admin_AdManagement.add_new_ad') }}
                                </v-btn>
                            </v-card-title>
                            <v-data-table
                                :headers="adHeaders"
                                :items="ads"
                                item-key="id"
                                disable-pagination
                                class="elevation-1"
                            >
                                <template v-slot:item.images="{ item }">
                                    <v-img
                                        :src="item.images[0]"
                                        height="50"
                                        width="50"
                                        class="ad-image"
                                        style="border-radius: 8px;"
                                    ></v-img>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-btn icon @click="editAd(item)">
                                        <v-icon>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="viewAdDetails(item)">
                                        <v-icon>mdi-eye</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="approveAd(item)" color="green">
                                        <v-icon>mdi-check</v-icon>
                                    </v-btn>
                                    <v-btn icon @click="rejectAd(item)" color="red">
                                        <v-icon>mdi-close</v-icon>
                                    </v-btn>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-col>
                </v-row>
                <v-dialog v-model="adTypeDialog" max-width="500px" persistent>
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline text-center">
                            {{ translate('Admin_AdManagement.select_ad_type') }}
                        </v-card-title>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="6" v-for="(type, index) in adTypes" :key="index">
                                    <v-btn
                                        block
                                        large
                                        color="primary"
                                        @click="selectAdType(type.value)"
                                        class="mb-2"
                                        height="80"
                                    >
                                        <v-icon left>{{ type.icon }}</v-icon>
                                        {{ type.text }}
                                    </v-btn>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-dialog>

                <v-dialog v-model="adDialog" max-width="800px">
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline text-center">
                            {{ editingAd ? translate('Admin_AdManagement.edit_ad') : translate('Admin_AdManagement.add_new_ad') }}
                        </v-card-title>
                        <v-card-text>
                            <div v-if="selectedAdType === 'house'">
                                <v-form ref="form" v-model="valid">
                                    <v-text-field v-model="adForm.title" :label="translate('Admin_AdManagement.ad_title')" :rules="[rules.required]" outlined dense />
                                    <v-textarea v-model="adForm.description" :label="translate('Admin_AdManagement.ad_description')" :rules="[rules.required]" outlined dense />
                                    <v-select
                                        v-model="adForm.category"
                                        :items="categories"
                                        :label="translate('Admin_AdManagement.ad_category')"
                                        :rules="[rules.required]"
                                        outlined dense
                                    />
                                    <v-text-field v-model="adForm.basePrice" :label="translate('Admin_AdManagement.base_price')" type="number" outlined dense />
                                    <v-text-field v-model="adForm.serviceFee" :label="translate('Admin_AdManagement.service_fee')" type="number" outlined dense />
                                    <v-text-field v-model="adForm.discountPercent" :label="translate('Admin_AdManagement.discount') + ' (%)'" type="number" outlined dense />
                                    <v-text-field :value="totalPriceComputed" :label="translate('Admin_AdManagement.total_price')" type="number" readonly outlined dense />
                                    <v-text-field :value="finalReceivedAmountComputed" :label="translate('Admin_AdManagement.received_amount')" type="number" readonly outlined dense />
                                    <v-checkbox v-model="adForm.hostType" :label="translate('Admin_AdManagement.host_as_individual')" value="individual" />
                                    <v-checkbox v-model="adForm.hostType" :label="translate('Admin_AdManagement.host_as_business')" value="business" />
                                    <v-checkbox v-model="adForm.locationFeatures" :label="translate('Admin_AdManagement.security_camera')" value="security_camera" />
                                    <v-checkbox v-model="adForm.locationFeatures" :label="translate('Admin_AdManagement.sound_insulation')" value="sound_insulation" />
                                    <v-checkbox v-model="adForm.locationFeatures" :label="translate('Admin_AdManagement.protective_weapons')" value="protective_weapons" />
                                    <v-switch v-model="adForm.active" :label="translate('Admin_AdManagement.ad_active')" color="primary" />
                                </v-form>
                            </div>

                            <div v-else-if="selectedAdType === 'companion'">
                                <v-form ref="companionForm" v-model="companionValid">
                                    <v-text-field
                                        v-model="companionForm.title"
                                        :label="translate('Admin_AdManagement.companion_title')"
                                        :rules="[rules.required]"
                                        outlined dense
                                    />

                                    <v-textarea
                                        v-model="companionForm.description"
                                        :label="translate('Admin_AdManagement.companion_description')"
                                        :rules="[rules.required]"
                                        outlined dense
                                    />
                                    <v-select
                                        v-model="companionForm.travelType"
                                        :items="travelTypes"
                                        :label="translate('Admin_AdManagement.travel_type')"
                                        outlined
                                        dense
                                        item-title="label"
                                        item-value="value"
                                        return-object
                                    ></v-select>

                                    <v-select
                                        v-model="companionForm.genderPreference"
                                        :items="genderPreferences"
                                        :label="translate('Admin_AdManagement.gender_preference')"
                                        outlined
                                        dense
                                        item-title="label"
                                        item-value="value"
                                        return-object
                                    ></v-select>

                                    <v-text-field
                                        v-model="companionForm.origin"
                                        :label="translate('Admin_AdManagement.origin')"
                                        :rules="[rules.required]"
                                        outlined dense
                                    />

                                    <v-text-field
                                        v-model="companionForm.destination"
                                        :label="translate('Admin_AdManagement.destination')"
                                        :rules="[rules.required]"
                                        outlined dense
                                    />

                                    <v-menu
                                        v-model="datePickerMenu"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="companionForm.travelDate"
                                                :label="translate('Admin_AdManagement.travel_date')"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                                outlined dense
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="companionForm.travelDate"
                                            no-title
                                            scrollable
                                        ></v-date-picker>
                                    </v-menu>

                                    <v-text-field
                                        v-model="companionForm.price"
                                        :label="translate('Admin_AdManagement.price')"
                                        type="number"
                                        outlined dense
                                    />

                                    <v-switch v-model="adForm.active" :label="translate('Admin_AdManagement.ad_active')" color="primary" />
                                </v-form>
                            </div>
                            <div v-else class="text-center py-12">
                                <v-icon x-large color="grey" class="mb-4">mdi-clock-outline</v-icon>
                                <h3 class="text-h5 grey--text">{{ translate('Admin_AdManagement.coming_soon') }}</h3>
                                <p class="grey--text">{{ translate('Admin_AdManagement.this_feature_will_be_available_soon') }}</p>
                            </div>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn @click="closeAdDialog" color="grey" outlined rounded>
                                {{ translate('Admin_AdManagement.close') }}
                            </v-btn>
                            <v-btn
                                v-if="selectedAdType === 'house'"
                                @click="saveAd"
                                color="primary"
                                :disabled="!valid"
                                rounded
                            >
                                {{ translate('Admin_AdManagement.save') }}
                            </v-btn>
                            <v-btn
                                v-else-if="selectedAdType === 'companion'"
                                @click="saveCompanionAd"
                                color="primary"
                                :disabled="!companionValid"
                                rounded
                            >
                                {{ translate('Admin_AdManagement.save') }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>


                <v-dialog v-model="detailsDialog" max-width="800px">
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline">
                            {{ translate('Admin_AdManagement.ad_details') }} {{ selectedAd.title }}
                        </v-card-title>
                        <v-card-text>
                            <v-carousel v-if="selectedAd.images && selectedAd.images.length > 0">
                                <v-carousel-item
                                    v-for="(image, index) in selectedAd.images"
                                    :key="index"
                                    :src="image"
                                    cover
                                ></v-carousel-item>
                            </v-carousel>
                            <v-list>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">{{ translate('Admin_AdManagement.ad_description') }}</v-list-item-title>
                                        <v-list-item-subtitle class="text-body-1">{{ selectedAd.description }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">{{ translate('Admin_AdManagement.ad_category') }}</v-list-item-title>
                                        <v-list-item-subtitle class="text-body-1">{{ selectedAd.category }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item>
                                    <v-list-item-content>
                                        <v-list-item-title class="font-weight-bold">{{ translate('Admin_AdManagement.ad_status') }}</v-list-item-title>
                                        <v-list-item-subtitle class="text-body-1">{{ selectedAd.status || 'Awaiting_confirmation' }}</v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn @click="detailsDialog = false" color="grey" outlined rounded>
                                {{ translate('Admin_AdManagement.close') }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </v-container>
        </v-main>
    </v-app>
</template>


<script>
//Todo: Ad Model (House Type): id/title/description/category/basePrice/serviceFee/discountPercent/hostType/locationFeatures/status/images/type/active
//Todo: Ad Model (Companion Type):{id/title/description/origin/destination/travelDate/price/genderPreference/travelType/status/type/active/smokingAllowed/petsAllowed/images
import { translate } from "@/store/languageStore";
import Sidebar from "../Sidebar.vue";
import { ref,reactive, computed } from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";

export default {
    components: {
        Sidebar,
        Darkmood,
        LanguageSwitcher
    },
    data() {
        return {
            isDarkMode: true,
            drawer: true,
            adTypeDialog: false,
            adDialog: false,
            detailsDialog: false,
            editingAd: false,
            valid: false,
            companionValid: false,
            datePickerMenu: false,

            selectedAdType: '',
            selectedAd: { title: '' },

            adForm: {
                title: '',
                description: '',
                category: '',
                basePrice: 0,
                serviceFee: 0,
                discountPercent: 0,
                hostType: [],
                locationFeatures: [],
                active: false,
                images: []
            },
            companionForm: {
                title: '',
                description: '',
                origin: '',
                destination: '',
                travelDate: null,
                price: 0,
                genderPreference: '',
                active: false,
                travelType: '',
                smokingAllowed: false,
                petsAllowed: false
            },

            ads: [
                {
                    id: 1,
                    title: 'آپارتمان لوکس',
                    description: 'آپارتمان مبله با ویو دریا',
                    category: 'آپارتمان',
                    basePrice: 1000000,
                    serviceFee: 100000,
                    discountPercent: 10,
                    hostType: ['individual'],
                    locationFeatures: ['security_camera'],
                    status: 'Awaiting_confirmation',
                    images: ['/ads/special-offer.jpg', '/ads/house1.jpg']
                },
                {
                    id: 2,
                    title: 'ویلا در شمال',
                    description: 'ویلا با استخر و باغچه',
                    category: 'ویلا',
                    basePrice: 2000000,
                    serviceFee: 200000,
                    discountPercent: 15,
                    hostType: ['business'],
                    locationFeatures: ['sound_insulation'],
                    status: 'Awaiting_confirmation',
                    images: ['/ads/top-rated.jpg', '/ads/house2.jpg']
                }
            ],
            adHeaders: [
                { text: this.translate('Admin_AdManagement.ad_title'), align: 'start', key: 'title', sortable: true },
                { text: this.translate('Admin_AdManagement.ad_description'), key: 'description' },
                { text: this.translate('Admin_AdManagement.ad_category'), key: 'category' },
                { text: this.translate('Admin_AdManagement.ad_status'), key: 'status' },
                { text: this.translate('Admin_AdManagement.images'), key: 'images', sortable: false },
                { text: this.translate('Admin_AdManagement.actions'), key: 'actions', sortable: false }
            ],
            adTypes: [
                { text: this.translate('house'), value: 'house', icon: 'mdi-home' },
                { text: this.translate('travel_companion'), value: 'companion', icon: 'mdi-account-group' },
                { text: this.translate('event'), value: 'event', icon: 'mdi-calendar' },
                { text: this.translate('car'), value: 'car', icon: 'mdi-car' }
            ]
        }
    },
    computed: {
        categories() {
            return ['ویلا', 'آپارتمان', 'سوئیت'];
        },
        travelTypes() {
            return [
                { label: this.translate("Ad.Normal"), value: 'normal', img: '/Travel 005.png' },
                { label: this.translate('Ad.Luxury'), value: 'luxury', img: '/Travel 006.png' },
                { label: this.translate('Ad.Adventure'), value: 'adventure', img: '/Travel 007.png' },
                { label: this.translate('Ad.Camping'), value: 'camping', img: '/Travel 008.png' },
                { label: this.translate('Ad.Backpacking'), value: 'backpacking', img: '/Travel 009.png' }
            ];
        },
        genderPreferences() {
            return [
                { label: this.translate('Admin_AdManagement.no_preference'), value: 'no_preference' },
                { label: this.translate('Admin_AdManagement.male_only'), value: 'male' },
                { label: this.translate('Admin_AdManagement.female_only'), value: 'female' }
            ];
        },
        rules() {
            return {
                required: value => !!value || this.translate('Admin_AdManagement.validation.required')
            };
        },
        totalPriceComputed() {
            try {
                const basePrice = parseFloat(this.adForm.basePrice || 0);
                const serviceFee = parseFloat(this.adForm.serviceFee || 0);
                return (basePrice + serviceFee).toFixed(2);
            } catch (error) {
                this.showError('Failed to calculate total price');
                return '0.00';
            }
        },
        finalReceivedAmountComputed() {
            try {
                const totalPrice = parseFloat(this.totalPriceComputed);
                const discountPercent = parseFloat(this.adForm.discountPercent || 0);
                const discountAmount = (totalPrice * discountPercent) / 100;
                const finalAmount = (totalPrice - discountAmount) * 0.94;
                return finalAmount.toFixed(2);
            } catch (error) {
                this.showError('Failed to calculate final amount');
                return '0.00';
            }
        }
    },
    methods: {
        translate,

        showError(message) {
            alert(message);
        },
        showSuccess(message) {
            alert(message);
        },
        openAdDialog() {
            this.adTypeDialog = true;
        },
        selectAdType(type) {
            try {
                this.selectedAdType = type;
                this.adTypeDialog = false;
                this.adDialog = true;

                if (type === 'house') {
                    this.adForm = {
                        title: '',
                        description: '',
                        category: '',
                        basePrice: 0,
                        serviceFee: 0,
                        discountPercent: 0,
                        hostType: [],
                        locationFeatures: [],
                        active: false,
                        images: []
                    };
                } else if (type === 'companion') {
                    this.companionForm = {
                        title: '',
                        description: '',
                        travelType: '',
                        origin: '',
                        destination: '',
                        travelDate: null,
                        price: 0,
                        genderPreference: '',
                        active: false,
                        smokingAllowed: false,
                        petsAllowed: false
                    };
                }

                this.editingAd = false;
            } catch (error) {
                this.showError('Failed to select ad type');
            }
        },
        closeAdDialog() {
            this.adDialog = false;
            this.selectedAdType = '';
        },
        saveAd() {
            try {
                if (!this.valid) return;

                if (this.editingAd) {
                    const adIndex = this.ads.findIndex(a => a.id === this.adForm.id);
                    if (adIndex !== -1) {
                        this.ads[adIndex] = { ...this.adForm };
                        this.showSuccess('Ad updated successfully');
                    }
                } else {
                    const newAd = {
                        ...this.adForm,
                        id: this.ads.length + 1,
                        status: 'Awaiting_confirmation',
                        type: 'house'
                    };
                    this.ads.push(newAd);
                    this.showSuccess('Ad created successfully');
                }

                this.adDialog = false;
            } catch (error) {
                this.showError('Failed to save ad');
            }
        },
        saveCompanionAd() {
            try {
                if (!this.companionValid) return;

                const newAd = {
                    ...this.companionForm,
                    id: this.ads.length + 1,
                    status: 'Awaiting_confirmation',
                    type: 'companion'
                };
                this.ads.push(newAd);
                this.showSuccess('Companion ad created successfully');
                this.adDialog = false;
            } catch (error) {
                this.showError('Failed to save companion ad');
            }
        },
        editAd(ad) {
            try {
                this.adForm = { ...ad };
                this.editingAd = true;
                this.adDialog = true;
                this.selectedAdType = 'house';
            } catch (error) {
                this.showError('Failed to edit ad');
            }
        },
        viewAdDetails(ad) {
            this.selectedAd = ad;
            this.detailsDialog = true;
        },
        approveAd(ad) {
            try {
                const adIndex = this.ads.findIndex(a => a.id === ad.id);
                if (adIndex !== -1) {
                    this.ads[adIndex].status = 'approved';
                    this.showSuccess('Ad approved successfully');
                }
            } catch (error) {
                this.showError('Failed to approve ad');
            }
        },
        rejectAd(ad) {
            try {
                const adIndex = this.ads.findIndex(a => a.id === ad.id);
                if (adIndex !== -1) {
                    this.ads[adIndex].status = 'rejected';
                    this.showSuccess('Ad rejected successfully');
                }
            } catch (error) {
                this.showError('Failed to reject ad');
            }
        },
    }
}
</script>


<style scoped>
.v-data-table th {
    background-color: #f0f0f0;
    font-weight: bold;
    color: #333;
}

.v-data-table td {
    text-align: center;
    padding: 12px;
}

.v-btn {
    transition: all 0.3s ease;
}

.v-btn:hover {
    transform: scale(1.05);
}

.v-card {
    border-radius: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.v-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.v-chip {
    font-weight: bold;
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
.language {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}
.darkmood {
    color: var(--text-color);
    background-color: var(--background-color);
    transition: color 0.3s, background-color 0.3s;
}

* {
    box-sizing: border-box;
}
body {
    overflow-x: hidden;
}

.footer {
    background-color: var(--background-color);
}
.language{
    margin-right: 80px!important;
}
.darkmood{
    margin-right: 20px!important;
}

@media (max-width: 600px) {
    .main {
        margin-bottom: 100px;
    }
}
@media (max-width: 960px) {
    .main {
        margin-bottom: 70px;
    }
}

v-container {
    max-width: 100%;
    padding: 0;
}

.logo-container {
    display: flex;
    align-items: center;
    overflow: visible;
    filter: brightness(var(--logo-brightness, 1));
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

.border1{
    margin-left: 20px;
}
@media (max-width: 600px) {
    .border1{
        margin-left: 0!important;
    }

    .main-expanded {
        margin-left: 0;
    }

    .main-collapsed {
        margin-left: 0;
    }

    .v-app-bar .logo-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .v-app-bar .logo-image {
        max-width: 80%;
    }
}


</style>
