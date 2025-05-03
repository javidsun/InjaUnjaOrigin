<template>
    <UserSidebar>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <h2 class="text-center">{{ translate('UserSidebar.MyAds') }}</h2>
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
                            <v-btn color="error" @click="confirmDelete(ad.id)">{{ translate('Ad.delete') }}</v-btn>
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
                                    :label="translate('Ad.Add_Images')"
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
                        <v-text-field :label="translate('Ad.total_price')" :value="totalPrice" type="number"
                                      readonly outlined></v-text-field>
                        <v-text-field :label="translate('Ad.received_amount')" :value="finalReceivedAmount"
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

            <v-dialog v-model="confirmDialog" max-width="400px">
                <v-card>
                    <v-card-title class="text-h5">{{ translate('Ad.ConfirmDelete') }}</v-card-title>
                    <v-card-text>{{ translate('Ad.ConfirmDeleteMessage') }}</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="green darken-1" text @click="confirmDialog = false">{{ translate('Ad.Cancel') }}</v-btn>
                        <v-btn color="red darken-1" text @click="deleteAd">{{ translate('Ad.Confirm') }}</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-container>
    </UserSidebar>
</template>

<script>
import UserSidebar from '../Users/Layout.vue';
import { translate } from "@/store/languageStore";

export default {
    components: {
        UserSidebar
    },
    data() {
        return {
            ads: [
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
                }
            ],
            editDialog: false,
            confirmDialog: false,
            editedAd: {},
            adToDelete: null,
            newImages: [],
            imageRules: [
                (files) => !files || files.length <= 10 || this.translate("Ad.Upload_images"),
                (files) => !files || files.length >= 3 || this.translate("Ad.Upload_images2"),
            ]
        }
    },
    computed: {
        totalPrice() {
            try {
                const basePrice = parseFloat(this.editedAd.basePrice || 0);
                const serviceFee = parseFloat(this.editedAd.serviceFee || 0);
                return (basePrice + serviceFee).toFixed(2);
            } catch (error) {
                this.showError('Error calculating total price');
                return '0.00';
            }
        },
        finalReceivedAmount() {
            try {
                const totalPrice = parseFloat(this.totalPrice);
                const discountPercent = parseFloat(this.editedAd.discountPercent || 0);
                const discountAmount = (totalPrice * discountPercent) / 100;
                const finalAmount = (totalPrice - discountAmount) * 0.94;
                return finalAmount.toFixed(2);
            } catch (error) {
                this.showError('Error calculating final amount');
                return '0.00';
            }
        }
    },
    methods: {
        translate,
        openEditModal(ad) {
            try {
                this.editedAd = JSON.parse(JSON.stringify(ad));
                this.editDialog = true;
            } catch (error) {
                this.showError('Failed to open edit modal');
            }
        },
        saveEdit() {
            try {
                const index = this.ads.findIndex(ad => ad.id === this.editedAd.id);
                if (index !== -1) {
                    this.ads[index] = JSON.parse(JSON.stringify(this.editedAd));
                    this.showSuccess('Ad updated successfully');
                    this.editDialog = false;
                }
            } catch (error) {
                this.showError('Failed to save ad');
            }
        },
        confirmDelete(adId) {
            this.adToDelete = adId;
            this.confirmDialog = true;
        },
        deleteAd() {
            try {
                this.ads = this.ads.filter(ad => ad.id !== this.adToDelete);
                this.showSuccess('Ad deleted successfully');
                this.confirmDialog = false;
            } catch (error) {
                this.showError('Failed to delete ad');
            }
        },
        handleImageUpload(files) {
            try {
                if (!files || !files.length) return;

                const maxImages = 10;
                const validFiles = files.slice(0, maxImages - this.editedAd.images.length);

                validFiles.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.editedAd.images.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            } catch (error) {
                this.showError('Failed to upload images');
            }
        },
        removeImage(index) {
            try {
                this.editedAd.images.splice(index, 1);
            } catch (error) {
                this.showError('Failed to remove image');
            }
        },
        showSuccess(message) {
            this.$store.dispatch('showAlert', {
                type: 'success',
                message: message,
                duration: 3000
            });
        },
        showError(message) {
            this.$store.dispatch('showAlert', {
                type: 'error',
                message: message,
                duration: 5000
            });
        }
    }
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
