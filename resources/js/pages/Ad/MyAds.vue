<template>
    <UserSidebar>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <h2 class="text-center">{{ translate('Ad.MyAds') }}</h2>
                </v-col>
            </v-row>
            <v-row>
                <v-col v-for="ad in ads" :key="ad.id" cols="12" md="6" lg="4">
                    <v-card class="ad-card">
                        <v-img :src="ad.images[0]" height="200" class="ad-image"></v-img>
                        <v-card-title class="ad-title">{{ ad.title }}</v-card-title>
                        <v-card-subtitle class="ad-description">{{ ad.description }}</v-card-subtitle>
                        <v-card-actions>
                            <v-btn color="primary" @click="openEditModal(ad)">{{ translate('Ad.Edit') }}</v-btn>
                            <v-btn color="error" @click="deleteAd(ad.id)">{{ translate('Ad.delete') }}</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
            <v-row v-if="ads.length === 0">
                <v-col cols="12" class="text-center">
                    <p>{{ translate('Ad.NoAdsFound') }}</p>
                </v-col>
            </v-row>

            <v-dialog v-model="editDialog" max-width="800px">
                <v-card class="edit-modal">
                    <v-card-title class="modal-title">{{ translate('Ad.AdsEdit') }}</v-card-title>
                    <v-card-text>
                        <v-text-field :label="translate('Ad.title')" v-model="editedAd.title" outlined></v-text-field>
                        <v-textarea :label="translate('Ad.description')" v-model="editedAd.description"
                                    outlined></v-textarea>
                        <v-text-field :label="translate('Ad.property_type')" v-model="editedAd.propertyType"
                                      outlined></v-text-field>

                        <v-row>
                            <v-col cols="12">
                                <h3>{{ translate('Ad.AcceptReject') }}</h3>
                                <v-file-input
                                    multiple
                                    accept="image/*"
                                    :label="t('Ad.Add_Images')"
                                    :rules="imageRules"
                                    @change="handleImageUpload"
                                ></v-file-input>
                                <v-row>
                                    <v-col v-for="(image, index) in editedAd.images" :key="index" cols="4">
                                        <v-card>
                                            <v-img :src="image" height="150" class="image-preview"></v-img>
                                            <v-card-actions>
                                                <v-btn color="error" @click="removeImage(index)">{{
                                                    translate('Ad.delete') }}
                                                </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>

                        <v-text-field :label="translate('Ad.base_price')" v-model="editedAd.basePrice" type="number"
                                      outlined></v-text-field>
                        <v-text-field :label="translate('Ad.service_fee')" v-model="editedAd.serviceFee" type="number"
                                      outlined></v-text-field>
                        <v-text-field :label="translate('Ad.discount') + ' (%)'" v-model="editedAd.discountPercent"
                                      type="number" outlined></v-text-field>
                        <v-text-field :label="translate('Ad.total_price')" :value="totalPriceComputed" type="number"
                                      readonly outlined></v-text-field>
                        <v-text-field :label="translate('Ad.received_amount')" :value="finalReceivedAmountComputed"
                                      type="number" readonly outlined></v-text-field>

                        <v-checkbox v-model="editedAd.hostType" :label="translate('Ad.host_as_individual')"
                                    value="individual"></v-checkbox>
                        <v-checkbox v-model="editedAd.hostType" :label="translate('Ad.host_as_business')"
                                    value="business"></v-checkbox>
                        <v-checkbox v-model="editedAd.locationFeatures" :label="translate('Ad.security_camera')"
                                    value="security_camera"></v-checkbox>
                        <v-checkbox v-model="editedAd.locationFeatures" :label="translate('Ad.sound_insulation')"
                                    value="sound_insulation"></v-checkbox>
                        <v-checkbox v-model="editedAd.locationFeatures" :label="translate('Ad.protective_weapons')"
                                    value="protective_weapons"></v-checkbox>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn color="green" @click="saveEdit">{{ translate('Ad.SaveExit') }}</v-btn>
                        <v-btn color="red" @click="editDialog = false">{{ translate('Ad.Cancel') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </UserSidebar>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore


import {ref, computed} from 'vue';
import {translate} from "@/store/languageStore";
import UserSidebar from '../Users/Layout.vue';

const ads = ref([
    {
        id: 1,
        title: 'آپارتمان زیبا در تهران',
        description: 'آپارتمان ۲ خوابه در منطقه خوب تهران',
        images: ['/ads/special-offer.jpg', '/ads/house1.jpg'],
        propertyType: 'آپارتمان',
        basePrice: 1000000,
        serviceFee: 100000,
        discountPercent: 10,
        category: 'house',
        hostType: ['individual'],
        locationFeatures: ['security_camera'],
    },
    {
        id: 2,
        title: 'ویلای لوکس در شمال',
        description: 'ویلای ۳ خوابه با استخر خصوصی',
        images: ['/ads/top-rated.jpg', '/ads/house2.jpg'],
        propertyType: 'ویلا',
        basePrice: 2000000,
        serviceFee: 200000,
        discountPercent: 15,
        category: 'house',
        hostType: ['business'],
        locationFeatures: ['sound_insulation'],
    },
]);

const editDialog = ref(false);
const editedAd = ref({});
const newImages = ref([]);

const imageRules = [
    (files) => !files || files.length <= 10 || translate("Ad.Upload_images"),
    (files) => !files || files.length >= 3 || translate("Ad.Upload_images2"),
];

const totalPriceComputed = computed(() => {
    const basePrice = parseFloat(editedAd.value.basePrice || 0);
    const serviceFee = parseFloat(editedAd.value.serviceFee || 0);
    return (basePrice + serviceFee).toFixed(2);
});
const finalReceivedAmountComputed = computed(() => {
    const totalPrice = parseFloat(totalPriceComputed.value);
    const discountPercent = parseFloat(editedAd.value.discountPercent || 0);
    const discountAmount = (totalPrice * discountPercent) / 100;
    const finalAmount = (totalPrice - discountAmount) * 0.94;
    return finalAmount.toFixed(2);
});

const openEditModal = (ad) => {
    editedAd.value = {...ad};
    editDialog.value = true;
};
const saveEdit = () => {
    const index = ads.value.findIndex(ad => ad.id === editedAd.value.id);
    if (index !== -1) {
        ads.value[index] = {...editedAd.value};
        editDialog.value = false;
    }
    ;

    const deleteAd = (adId) => {
        ads.value = ads.value.filter(ad => ad.id !== adId);
    };

    const handleImageUpload = (event) => {
        const files = Array.from(event.target.files);
        if (!files.length) return;

        const maxImages = 10;
        const validFiles = files.slice(0, maxImages - editedAd.value.images.length);

        validFiles.forEach(file => {
            const reader = new FileReader();
            reader.onload = (e) => {
                editedAd.value.images.push(e.target.result);
            };
            reader.readAsDataURL(file);
        });
    };

    const removeImage = (index) => {
        editedAd.value.images.splice(index, 1);
    };
}
</script>

<style scoped>
.ad-image {
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}

.ad-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.ad-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.ad-image {
    border-radius: 8px 8px 0 0;
}

.ad-title {
    font-size: 1.2rem;
    font-weight: bold;
}

.ad-description {
    color: #666;
}

.edit-modal {
    border-radius: 12px;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.image-preview {
    border-radius: 8px;
}
</style>
