<template>
    <v-app :dark="isDarkMode">
        <v-app-bar app elevation="1" class="header">
            <v-col cols="2">
                <div class="logo-container">
                    <img src="/assets/images/inja-unja.png" alt="Logo" class="logo-image" @click="drawer = !drawer" />
                </div>
            </v-col>
            <v-spacer />
            <Searchbar />
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

                <v-dialog v-model="adDialog" max-width="800px">
                    <v-card class="elevation-2 rounded-lg">
                        <v-card-title class="headline text-center">
                            {{ editingAd ? translate('Admin_AdManagement.edit_ad') : translate('Admin_AdManagement.add_new_ad') }}
                        </v-card-title>
                        <v-card-text>
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
                        </v-card-text>
                        <v-card-actions class="justify-end">
                            <v-btn @click="adDialog = false" color="grey" outlined rounded>
                                {{ translate('Admin_AdManagement.close') }}
                            </v-btn>
                            <v-btn @click="saveAd" color="primary" :disabled="!valid" rounded>
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

<script setup>
import Sidebar from "../Sidebar.vue";
import { ref, computed } from 'vue';
import "vue-sidebar-menu/dist/vue-sidebar-menu.css";
import Searchbar from "../../layout/Header/search/Searchbar.vue";
import Darkmood from "../../layout/Header/Darkmood.vue";
import LanguageSwitcher from "../../layout/Header/LanguageSwitcher.vue";
import { translate } from "../../../store/languageStore";

const adDialog = ref(false);
const detailsDialog = ref(false);
const editingAd = ref(false);
const valid = ref(false);
const props = defineProps({
    type: Array,
});

const ads = ref([
    { id: 1, title: 'آپارتمان لوکس', description: 'آپارتمان مبله با ویو دریا', category: 'آپارتمان', basePrice: 1000000, serviceFee: 100000, discountPercent: 10, hostType: ['individual'], locationFeatures: ['security_camera'], status: 'Awaiting_confirmation', images: ['/ads/special-offer.jpg', '/ads/house1.jpg'] },
    { id: 2, title: 'ویلا در شمال', description: 'ویلا با استخر و باغچه', category: 'ویلا', basePrice: 2000000, serviceFee: 200000, discountPercent: 15, hostType: ['business'], locationFeatures: ['sound_insulation'], status: 'Awaiting_confirmation', images: ['/ads/top-rated.jpg', '/ads/house2.jpg'] },
]);

const categories = computed(() => [
    'ویلا',
    'آپارتمان',
    'سوئیت',
]);

const approveAd = (ad) => {
    const adIndex = ads.value.findIndex(a => a.id === ad.id);
    if (adIndex !== -1) {
        ads.value[adIndex].status = 'approved';
    }
};

const rejectAd = (ad) => {
    const adIndex = ads.value.findIndex(a => a.id === ad.id);
    if (adIndex !== -1) {
        ads.value[adIndex].status = 'rejected';
    }
};

const isDarkMode = ref(true);
const drawer = ref(true);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
};

const adHeaders = [
    { text: translate('Admin_AdManagement.ad_title'), align: 'start', key: 'title', sortable: true },
    { text: translate('Admin_AdManagement.ad_description'), key: 'description' },
    { text: translate('Admin_AdManagement.ad_category'), key: 'category' },
    { text: translate('Admin_AdManagement.ad_status'), key: 'status' },
    { text: translate('Admin_AdManagement.images'), key: 'images', sortable: false },
    { text: translate('Admin_AdManagement.actions'), key: 'actions', sortable: false }
];

const adForm = ref({
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
});

const selectedAd = ref({ title: '' });

const rules = computed(() => ({
    required: value => !!value || translate('Admin_AdManagement.validation.required'),
}));

const totalPriceComputed = computed(() => {
    const basePrice = parseFloat(adForm.value.basePrice || 0);
    const serviceFee = parseFloat(adForm.value.serviceFee || 0);
    return (basePrice + serviceFee).toFixed(2);
});

const finalReceivedAmountComputed = computed(() => {
    const totalPrice = parseFloat(totalPriceComputed.value);
    const discountPercent = parseFloat(adForm.value.discountPercent || 0);
    const discountAmount = (totalPrice * discountPercent) / 100;
    const finalAmount = (totalPrice - discountAmount) * 0.94;
    return finalAmount.toFixed(2);
});

const openAdDialog = () => {
    adForm.value = { title: '', description: '', category: '', basePrice: 0, serviceFee: 0, discountPercent: 0, hostType: [], locationFeatures: [], active: false, images: [] };
    editingAd.value = false;
    adDialog.value = true;
};

const saveAd = () => {
    if (!valid.value) return;

    if (editingAd.value) {
        const adIndex = ads.value.findIndex(a => a.id === adForm.value.id);
        ads.value[adIndex] = { ...adForm.value };
    } else {
        const newAd = { ...adForm.value, id: ads.value.length + 1, status: 'Awaiting_confirmation' };
        ads.value.push(newAd);
    }

    adDialog.value = false;
};

const editAd = ad => {
    adForm.value = { ...ad };
    editingAd.value = true;
    adDialog.value = true;
};

const viewAdDetails = ad => {
    selectedAd.value = ad;
    detailsDialog.value = true;
};
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
