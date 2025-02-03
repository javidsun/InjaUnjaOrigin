    <template>
        <v-dialog
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            max-width="600"
        >

            <v-card class="modal-container">
                <v-card-title class="text-center modal-title">
                    <v-img v-if="openModal === 'amenities'" src="/Untitled design (1) 10.png" contain height="100"></v-img>
                    <v-img class="modal-img" v-else-if="openModal === 'photos'" src="/Untitled design (8) 2.png" contain height="100"></v-img>
                    <v-img v-else-if="openModal === 'modalStep3'" src="/Untitled design (1) 10.png" contain height="200"></v-img>
                    <v-img v-else-if="openModal === 'Step3-1'" src="/Untitled design (1) 14.png" contain height="150"></v-img>
                    <v-img v-else-if="openModal === 'thirdStepSetPrice'" src="/Untitled design (1) 13.png" contain height="100"></v-img>
                    <v-img v-else-if="openModal === 'discountModal'" src="/Untitled design (1) 14.png" contain height="100"></v-img>

                    <h3 v-if="openModal === 'amenities'">{{ t('Ad.highlight_your_place') }}</h3>
                    <h3 v-else-if="openModal === 'photos'">{{ t('Ad.add_photos_of_your_place') }}</h3>
                    <h3 class="top1" v-else-if="openModal === 'title'">{{ t('Ad.give_title_for_accommodation') }}</h3>
                    <h4 v-else-if="openModal === 'modal4'">{{ t('Ad.modal_4_title') }}</h4>
                    <h3 class="text-primary" v-else-if="openModal === 'modalStep3'">{{ t('Ad.finalize_and_publish') }}<br>{{ t('Ad.step_three') }}</h3>
                    <h3 class="title-extra-margin" v-else-if="openModal === 'modal5'">{{ t('Ad.create_your_description') }}</h3>
                    <h3 v-else-if="openModal === 'Step3-1'">{{ t('Ad.HowReserve') }}</h3>
                    <h3 class="top1" v-else-if="openModal === 'thirdStepSetPrice'">{{ t('Ad.set_your_price') }}</h3>
                    <h3 v-else-if="openModal === 'discountModal'">{{ t('Ad.discounts') }}</h3>
                    <h2 class="font-weight-bold text-primary font-weight-bold3"  v-else-if="openModal === 'finalStepModal'">{{ t('Ad.final_step') }}</h2>
                    <h5  v-else-if="openModal === 'finalStepModal2'">{{ t('Ad.Request_Approval') }}</h5>

                    <p class="modal-text text-info" v-if="openModal === 'amenities'">{{ t('Ad.step_two') }}<br>{{ t('Ad.step_two_description') }}</p>
                    <p class="modal-text" v-else-if="openModal === 'photos'">{{ t('Ad.need_to_add_photos') }}</p>
                    <p class="modal-text text-muted " v-else-if="openModal === 'title'">{{ t('Ad.short_title_suggestion') }}</p>
                    <p class="modal-text text-muted" v-else-if="openModal === 'modal5'">{{ t('Ad.share_what_makes_your_place_special') }}</p>
                    <p class="modal-text text-muted" v-else-if="openModal === 'modalStep3'">{{ t('Ad.final_step_description') }}</p>
                    <p class="modal-text"  v-else-if="openModal === 'Step3-1'">{{ t('Ad.CanChange') }} </p>
                    <p class="modal-text top1" v-else-if="openModal === 'thirdStepSetPrice'">{{ t('Ad.CanChange') }}</p>
                    <p class="modal-text top1"  v-else-if="openModal === 'discountModal'">{{ t('Ad.Helps_highlight_your_niche') }} </p>
                    <p class="modal-text top1"  v-else-if="openModal === 'finalStepModal'">{{ t('Ad.host_type_question') }} </p>
                    <h2 class="modal-text  bold-red-text"  v-else-if="openModal === 'finalStepModal2'">{{ t('Ad.Awaiting_Confirmation') }} </h2>

                </v-card-title>
                <v-card v-if="openModal === 'property'"  class="top1">
                    <v-card-text class="top1" >
                        <p class="Txt2">{{ t('Ad.Modal1_1') }}</p>
                        <br>
                        <p class="Txt2">{{ t('Ad.Modal1_2') }}</p>
                        <br>

                        <v-row>
                            <v-col v-for="(option, index) in propertyTypes" :key="index" cols="6" md="3">
                                <v-card
                                    class="property-card"
                                    :class="{ 'selected': selectedProperty === option.title }"
                                    @click="selectProperty(option.title)">
                                    <v-img :src="option.image" height="80"></v-img>
                                    <p class="mt-2 Txt2">{{ t(option.title) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card v-else-if="openModal === 'map'"  >
                    <v-card-title class="text-h6 Txt2">{{ t('Ad.WhereAccommodation') }}</v-card-title>
                    <v-card-subtitle class="Txt2"></v-card-subtitle>
                    <v-card-text>
                        <v-text-field v-model="searchQuery" label="Search location" @keyup.enter="searchLocation"></v-text-field>
                        <div id="map" style="height: 300px;"></div>
                    </v-card-text>
                </v-card>
                <v-card v-else-if="openModal === 'details'"  class="top1 details">
                    <v-card-title class="text-h6 top1 Txt2">{{ t('Ad.ShareAccommodationInfo') }}</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col v-for="(item, index) in accommodationDetails" :key="index" cols="" md="12" >
                                <v-row align="center" justify="space-between">
                                    <v-col cols="8" class="text-center1 Txt2">
                                        <span>{{ t(item.name) }}</span>
                                    </v-col>
                                    <v-col cols="1" class="text-right Txt2">
                                        <v-btn icon @click="decrement(index)">
                                            <v-icon>mdi-minus</v-icon>
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="1" class="text-center Txt2">
                                        <span>{{ item.value }}</span>
                                    </v-col>
                                    <v-col cols="1" class="text-left">
                                        <v-btn icon @click="increment(index)">
                                            <v-icon>mdi-plus</v-icon>
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <template v-if="openModal === 'amenities'">
                        <h4 class="mb-2" style="margin-top: 70px;"> {{ t('Ad.tell_guests_about_amenities') }}</h4>
                        <v-row>
                            <v-col v-for="item in amenities" :key="item.text" cols="6" sm="3">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedAmenities.includes(item.text)}"
                                    @click="toggleAmenity(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <p class="amenity-text">{{ t(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                        <h4 class="mt-4">{{ t('Ad.special_amenities') }}</h4>
                        <v-row>
                            <v-col v-for="(item, index) in specialAmenities" :key="index" cols="6" sm="3">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedAmenities.includes(item.text)}"
                                    @click="toggleAmenity(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <p class="amenity-text">{{ t(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                        <h4 class="mt-4">{{ t('Ad.safety_amenities') }}</h4>
                        <v-row>
                            <v-col v-for="(item, index) in safetyFeatures" :key="index" cols="6" sm="3">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedAmenities.includes(item.text)}"
                                    @click="toggleAmenity(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <br>
                                    <p class="amenity-text">{{ t(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>
                <template v-else-if="openModal === 'photos'">
                    <div class="rectangle">
                        <v-btn block color="dark-gray lighten-3" class="py-8 rounded-lg" @click="openGallery">
                            <v-icon left class="icon-small font-weight-bold">mdi-image</v-icon> {{ t('Ad.add_photo') }}
                        </v-btn>

                        <v-btn block color="dark-gray lighten-3" class="py-8 rounded-lg mt-2" @click="openCamera">
                            <v-icon left class="icon-small font-weight-bold">mdi-camera</v-icon> {{ t('Ad.take_new_photo') }}
                        </v-btn>
                    </div>

                    <div class="image-preview mt-4">
                        <v-row>
                            <v-col v-for="(image, index) in uploadedImages" :key="index" cols="4">
                                <v-img :src="image" class="rounded-lg" aspect-ratio="1"></v-img>
                            </v-col>
                        </v-row>
                    </div>
                </template>
                <v-card v-else-if="openModal === 'title'">
                        <v-text-field v-model="title"
                                      max-length="32"
                                      counter
                                      clearable
                                      style="height: 10px;"
                                      @input="checkCharacterLimit"
                        ></v-text-field>
                        <p class="text-left top1" :style="{ fontSize: '12px', color: characterLimitExceeded ? 'red' : 'grey' }">
                            {{ t('Ad.max_32_characters') }}
                        </p>

                    </v-card>
                <template v-if="openModal === 'modal4'">
                    <div>
                        <p style="margin-top: 50px;" class="modal-text">{{ t('Ad.modal_4_description') }}</p>
                        <br>
                        <v-row  class="flex-wrap">
                            <v-col  v-for="(item, index) in modal4Options" :key="index" cols="6" sm="4">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedModal4.includes(item.text)}"
                                    @click="toggleModal4Option(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <p class="amenity-text">{{ t(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </div>
                </template>
                <template v-if="openModal === 'modal5'">
                <div class="description-container">
                <v-textarea v-model="description"
                                        counter
                                        maxlength="441"
                                        rows="4"
                                        class="description-box"
                                        @input="checkCharacterLimit2"
                            ></v-textarea>
                            <p class="text-left" :style="{ fontSize: '12px', color: characterLimitExceeded2 ? 'red' : 'grey' }">
                                {{ t('Ad.max_441_characters') }}
                            </p>
                        </div>
                    </template>
                <template v-if="openModal === 'Step3-1'">
                    <div class="rectangle">
                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg my-1"
                            :class="{ 'selected': selectedReservation === 'instant' }"
                            type="button"
                            @click="selectReservation('instant')"
                        >
                            <v-icon size="25">mdi-lightning-bolt</v-icon>
                            <v-col cols="10">
                                <h4 class="font-weight-bold">{{ t('Ad.HowReserve') }}</h4>
                                <p class="font-weight-bold2">{{ t('Ad.CanChange') }}</p>
                            </v-col>
                        </v-btn>

                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg my-4"
                            :class="{ 'selected': selectedReservation === 'request' }"
                            type="button"
                            @click="selectReservation('request')"
                        >
                            <v-icon size="25">mdi-note-text</v-icon>
                            <v-col cols="10">
                                <h4 class="font-weight-bold">{{ t('Ad.AcceptReject') }}</h4>
                                <p class="font-weight-bold2">{{ t('Ad.reservationRequest') }}</p>
                            </v-col>
                        </v-btn>
                    </div>
                </template>
                <template v-if="openModal === 'thirdStepSetPrice'">
                    <v-row justify="center">
                        <v-col cols="12" class="mb-1" align="center">
                            <h1 class="font-weight-bold text-primary "
                                style="margin-bottom: 10px;margin-top: 10px"
                            >{{ totalPrice }} {{ currency }}</h1>
                        </v-col>
                        <v-col cols="8" >
                            <v-select
                                v-model="currency"
                                :items="['$', '€', 'ریال']"
                                :label="t('Ad.currency')"
                                dense
                                outlined
                                class="rounded-lg"
                            ></v-select>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="basePrice" :label="t('Ad.base_price')" type="number" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="serviceFee" :label="t('Ad.service_fee')" type="number" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="totalPrice" :label="t('Ad.total_price')" dense outlined readonly class="rounded-lg">
                                <template v-slot:append>
                                    <span>{{ currency }}</span>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="receivedAmount" :label="t('Ad.received_amount')" dense outlined readonly class="rounded-lg">
                                <template v-slot:append>
                                    <span>{{ currency }}</span>
                                </template>
                            </v-text-field>
                        </v-col>

                        <discount-modal
                            :total-price="totalPrice"
                            :currency="currency"
                            v-model="discountModalOpen"
                        />

                    </v-row>

                    <v-btn block color="primary" class="py-3 mt-4 rounded-lg" @click="addExtraFee">
                        + {{ t('Ad.add_extra_fee') }}
                    </v-btn>

                    <v-row v-for="(fee, index) in extraFees" :key="index" justify="center">
                        <v-col cols="6">
                            <v-text-field v-model="fee.title" :label="t('Ad.extra_fee_title')" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="fee.amount" type="number" :label="t('Ad.amount')" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'discountModal'">
                    <v-row justify="center">
                        <v-col cols="12" align="center">
                            <h1 class="font-weight-bold text-primary"
                                style="margin-top: 10px;"
                            >
                                {{t('Ad.total_price')}}: {{ totalPrice - discountAmount }} {{ currency }}
                            </h1>
                        </v-col>

                        <v-col cols="12">
                            <v-row>
                                <v-col cols="12">
                                    <v-card
                                        v-for="discount in discountOptions"
                                        :key="discount.value"
                                        :class="{'bg-blue-lighten-4': selectedDiscounts.some(d => d.value === discount.value)}"
                                        outlined
                                        class="mb-2 cursor-pointer"
                                        @click="selectDiscount(discount)"
                                    >
                                        <v-card-title class="font-weight-bold3 text-right">{{ t(discount.title) }}</v-card-title>
                                        <v-card-subtitle class="text-right">{{ t(discount.description) }}</v-card-subtitle>
                                        <v-card-actions class="justify-start">
                                            <h1 class=" text-primary">{{ discount.percent }}%</h1>
                                        </v-card-actions>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <h3>  {{t('Ad.received_amount')}}: {{ receivedAmount }} {{ currency }}</h3>
                        </v-col>

                    </v-row>
                </template>
                <template v-if="openModal === 'finalStepModal'">
                    <v-row justify="center">
                        <v-col cols="12">
                            <v-row class="top1 ">
                                <v-col cols="6" class="top1 ">
                                    <v-checkbox
                                        v-model="hostType"
                                        :label="t('Ad.host_as_individual')"

                                        :value="'individual'"
                                    />
                                </v-col>
                                <v-col cols="6" class="top1 ">
                                    <v-checkbox
                                        v-model="hostType"
                                        :label="t('Ad.host_as_business')"
                                        :value="'business'"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4" />
                            <p >{{ t('Ad.location_features') }}</p>
                            <v-row >
                                <v-col cols="6" >
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="t('Ad.security_camera')"
                                        :value="'security_camera'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="t('Ad.sound_insulation')"
                                        :value="'sound_insulation'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="t('Ad.protective_weapons')"
                                        :value="'protective_weapons'"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4" />
                            <h2 align="center" class="font-weight-bold3" style="color: darkred"><strong>{{ t('Ad.important_information') }}</strong></h2>
                            <p >{{ t('Ad.cctv_prohibited') }}</p>
                            <p>{{ t('Ad.onsite_cameras_required') }}</p>
                            <h4 class="font-weight-bold3" style="color: #1b43ff">{{ t('Ad.follow_local_regulations') }}</h4>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'finalStepModal2'">
                    <v-row justify="center">
                        <v-container class="top1">
                            <v-row class="top1">
                                <v-col cols="12">
                                    <div class="info-container">
                                        <div class="info-box">
                                            <div align="center" style="color: #858585">{{ t('Ad.ShowHost') }}</div>

                                            <div class="info-body" style="display: flex; flex-direction: row; align-items: start;">
                                                <v-img class="img" :src="uploadedImage || uploadedImages[0] || '/20.jpg'" contain height="100"></v-img>
                                                <div class="info-details" style="text-align: center; margin-right: 12px;">
                                                    <div>{{ location || 'Default location' }}</div>
                                                    <div>{{ userName || 'Default name' }}</div>
                                                    <div class="price-info">
                                                        <div style="text-decoration: line-through; color: red;">
                                                            {{ totalPrice }} {{ currency }}
                                                        </div>
                                                        <div style="color: #00c853 ; font-weight: bold">{{ totalPrice - discountAmount }} {{ currency }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-btn @click="selectProperty2" block color="primary">{{ t('Ad.Edit') }}</v-btn>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ t('Ad.required_sections') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="showCalendar = true">
                        <v-icon class="mr-2">mdi-calendar-month</v-icon>
                        <h3>{{ t('Ad.Set_up_calendar') }}</h3>
                    </v-row>

                    <v-dialog v-model="showCalendar" max-width="400px" centered persistent class="custom-dialog">
                        <v-card>
                            <v-card-title>{{ t('Ad.available_dates') }}</v-card-title>
                            <v-card-text>
                                <v-date-picker v-model="selectedDates" multiple></v-date-picker>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="saveDates">{{ t('Ad.SaveExit') }}</v-btn>
                                <v-btn color="grey" text @click="showCalendar = false"> {{ t('Ad.Back') }}</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ t('Ad.choose_available') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="goNext">
                        <h3>{{ t('Ad.Check_settings') }}</h3>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ t('Ad.Set_house_rules') }}</p>
                        </v-col>
                    </v-row>
                </template>

                <v-card-actions class="d-flex flex-row flex-wrap justify-end gap-2">
                    <v-btn color="grey" text class="btn-small" style="min-width: auto; padding: 4px 8px;" @click="goBack">
                        {{ t('Ad.Back') }}
                    </v-btn>

                    <v-btn color="grey" text class="btn-small" style="min-width: auto; padding: 4px 8px;" @click="$emit('update:modelValue', false)">
                        {{ t('Ad.SaveExit') }}
                    </v-btn>
                    <v-btn color="primary" class="btn-small" style="min-width: auto; padding: 4px 8px;" @click="goNext" :disabled="characterLimitExceeded">
                        {{ t('Ad.ConfirmNext') }}
                    </v-btn>

                </v-card-actions>
            </v-card>
        </v-dialog>


    </template>



    <script setup>
    import {ref, computed, defineProps, defineEmits, watch, nextTick} from 'vue';
    import { t } from "../../../store/languageStore";
    import StepOneModal from './StepOneModal.vue';
    import L from "leaflet";
    import "leaflet/dist/leaflet.css";
    const openModal = ref("property");


    const props = defineProps({
        modelValue: Boolean,
        totalPrice: Number,
        currency: String,
        title: String,
        uploadedImage: String,
        city: String,
        country: String,
        userName: String,
        basePrice: Number,
        discountedPrice: Number,
        discount: Boolean
    });


    const emit = defineEmits(["update:modelValue", "next", "back","update-total-price"]);
    const title = ref('');
    const characterLimitExceeded = ref(false);
    const selectedModal4 = ref([]);
    const description = ref('');
    const characterLimitExceeded2 = ref(false);
    const hostType = ref(null);
    const locationFeatures = ref([]);
    const userName = "Default name";
    const location = "Default Location";
    const selectedProperty = ref(null);

    const selectProperty = (title) => {
        selectedProperty.value = title;
    };

    const searchQuery = ref("");
    const propertyTypes = ref([
        { title: "Ad.home", image: "/home-icon.png" },
        { title: "Ad.apartment", image: "/apartment-icon.png" },
        { title: "Ad.furniture", image: "/furniture-icon.png" },
        { title: "Ad.bed", image: "/bed-icon.png" },
        { title: "Ad.Camper", image: "/car-icon.png" },
        { title: "Ad.travelTent", image: "/tent-icon.png" },
        { title: "Ad.container", image: "/container.png" },
        { title: "Ad.Treehouse", image: "/Treehouse.png" },
    ]);

    const accommodationDetails = ref([
        { name: "Ad.Guest", value: 1 },
        { name: "Ad.Room", value: 1 },
        { name: "Ad.bed", value: 1 },
        { name: "Ad.Bathroom", value: 1 },
    ]);
    const confirmLocation = () => {
        openModal.value = "details";
    };
    const selectProperty2 = () => {
        openModal.value = "property";
    };
    const confirmStep2 = () => {
        emit("update:modelValue", false);
        emit("next");
    };


    const closeModal = () => {
        emit("update:modelValue", false);
    };


    const checkCharacterLimit2 = () => {
        characterLimitExceeded2.value = description.value.length > 441;
    };
    const selectedReservation = ref(null);

    const selectReservation = (type) => {
        selectedReservation.value = type;
    };

    const goBack = () => {

        if (openModal.value === "map") {
            openModal.value = "property";
        } else if (openModal.value === "details") {
            openModal.value = "map";
        }
        else if (openModal.value === 'title') {
            openModal.value = 'photos';
        } else if (openModal.value === 'photos') {
            openModal.value = 'amenities';
        } else if (openModal.value === 'modal4') {
            openModal.value = 'title';
        }
        else if (openModal.value === 'modal5') {
            openModal.value = 'modal4';
        }
        else if (openModal.value === 'modalStep3') {
            openModal.value = 'modal5';
        }
        else if (openModal.value === 'Step3-1') {
            openModal.value = 'modalStep3';
        }
        else if (openModal.value === 'thirdStepSetPrice') {
            openModal.value = 'Step3-1';
        }
        else if (openModal.value === 'discountModal') {
            openModal.value = 'thirdStepSetPrice';
        }
        else if (openModal.value === 'finalStepModal') {
            openModal.value = 'discountModal';
        }
        else if (openModal.value === 'finalStepModal2') {
            openModal.value = 'finalStepModal';
        }

        else {
            emit('update:modelValue', false);
        }
    };


    const goNext = () => {
        if (!characterLimitExceeded.value) {
            if (openModal.value === 'property') {
                if (!selectedProperty.value) {
                    alert("Please select a property type.");
                    return;
                }
                openModal.value = 'map';
                nextTick(initMap);
            }
            else if (openModal.value === 'map') {
                openModal.value = 'details';
            }
            else if (openModal.value === 'details') {
                openModal.value = 'amenities';
            }
            else if (openModal.value === 'amenities') {
                openModal.value = 'photos';
            } else if (openModal.value === 'photos') {
                openModal.value = 'title';
            } else if (openModal.value === 'title') {
                openModal.value = 'modal4';
            } else if (openModal.value === 'modal4') {
                openModal.value = 'modal5';
            } else if (openModal.value === 'modal5') {
                openModal.value = 'modalStep3';
            } else if (openModal.value === 'modalStep3') {
                openModal.value = 'Step3-1';
            } else if (openModal.value === 'Step3-1') {
                openModal.value = 'thirdStepSetPrice';
            } else if (openModal.value === 'thirdStepSetPrice') {
                openModal.value = 'discountModal';
            } else if (openModal.value === 'discountModal') {
                openModal.value = 'finalStepModal';
            }
            else if (openModal.value === 'finalStepModal') {
                openModal.value = 'finalStepModal2';
            }
        } else {
            emit('update:modelValue', false);
        }
    };


    const openGallery = () => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.multiple = true;
        input.onchange = (event) => {
            const files = Array.from(event.target.files);
            if (files.length > 0) {
                const maxImages = 10;
                const validFiles = files.slice(0, maxImages - uploadedImages.value.length); // تعداد عکس‌ها را محدود می‌کنیم
                validFiles.forEach(file => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        uploadedImages.value.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
            }
        };
        input.click();
    };


    const openCamera = () => {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    const video = document.createElement('video');
                    video.srcObject = stream;
                    video.play();

                    const captureButton = document.createElement('button');
                    captureButton.textContent = 'Capture';
                    document.body.appendChild(captureButton);

                    captureButton.addEventListener('click', () => {
                        const canvas = document.createElement('canvas');
                        const context = canvas.getContext('2d');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        context.drawImage(video, 0, 0, canvas.width, canvas.height);

                        const imageData = canvas.toDataURL('image/png');
                        uploadedImages.value.push(imageData);

                        stream.getTracks().forEach(track => track.stop());
                        document.body.removeChild(captureButton);
                        document.body.removeChild(video);
                    });
                })
                .catch((err) => {
                    alert("دسترسی به دوربین غیرممکن است: " + err);
                });
        } else {
            alert("این مرورگر از دوربین پشتیبانی نمی‌کند.");
        }
    };

    const toggleModal4Option = (option) => {
        const index = selectedModal4.value.indexOf(option);
        if (index === -1) {
            selectedModal4.value.push(option);
        } else {
            selectedModal4.value.splice(index, 1);
        }
    };


    const increment = (index) => {
        accommodationDetails.value[index].value += 1;
    };

    const decrement = (index) => {
        if (accommodationDetails.value[index].value > 0) {
            accommodationDetails.value[index].value -= 1;
        }
    };

    let map, marker;

    const initMap = () => {
        if (!map) {
            map = L.map("map").setView([35.6892, 51.3890], 13);

            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            marker = L.marker([35.6892, 51.3890], { draggable: true }).addTo(map);

            map.on('click', (e) => {
                const { lat, lng } = e.latlng;
                marker.setLatLng([lat, lng]);
                updateSearchQuery(e.latlng);
            });
        }
    };

    const updateSearchQuery = (latLng) => {
        const { lat, lng } = latLng;
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                searchQuery.value = data.display_name;
            });
    };

    const searchLocation = () => {
        if (!searchQuery.value) return;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${searchQuery.value}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    const { lat, lon } = data[0];
                    map.setView([lat, lon], 13);
                    marker.setLatLng([lat, lon]);
                    searchQuery.value = data[0].display_name;
                }
            });
    };
    const goToStep = (step) => {
        openModal.value = step;
    };

    const checkCharacterLimit = () => {
        if (title.value.length > 32) {
            characterLimitExceeded.value = true;
        } else {
            characterLimitExceeded.value = false;
        }
    };

    const selectedAmenities = ref([]);

    const toggleAmenity = (amenity) => {
        const index = selectedAmenities.value.indexOf(amenity);
        if (index === -1) {
            selectedAmenities.value.push(amenity);
        } else {
            selectedAmenities.value.splice(index, 1);
        }
    };
    const modal4Options = [
        { text: "Ad.peaceful", icon: 'mdi-home-heart' },
        { text: "Ad.unique", icon: 'mdi-flower' },
        { text: "Ad.family_favorite", icon: 'mdi-heart' },
        { text: "Ad.unique_style", icon: 'mdi-palette' },
        { text: "Ad.center", icon: 'mdi-map-marker' },
        { text: "Ad.spacious", icon: 'mdi-home-variant' },
    ];

    const amenities = [
        { text: "Ad.wifi", icon: 'mdi-wifi' },
        { text: "Ad.television", icon: 'mdi-television' },
        { text: "Ad.kitchen", icon: 'mdi-silverware-fork-knife' },
        { text: "Ad.washing_machine", icon: 'mdi-washing-machine' },
        { text: "Ad.free_parking", icon: 'mdi-parking' },
        { text: "Ad.paid_parking", icon: 'mdi-currency-usd' },
        { text: "Ad.air_conditioning", icon: 'mdi-air-conditioner' },
        { text: "Ad.work_space", icon: 'mdi-desk' },
    ];

    const specialAmenities = [
        { text: "Ad.pool", icon: 'mdi-pool' },
        { text: "Ad.yard", icon: 'mdi-tree' },
        { text: "Ad.barbecue", icon: 'mdi-grill' },
        { text: "Ad.patio", icon: 'mdi-patio-heater' },
        { text: "Ad.gym", icon: 'mdi-dumbbell' },
        { text: "Ad.sea_access", icon: 'mdi-wave' },
    ];

    const safetyFeatures = [
        { text: "Ad.smoke_alarm", icon: 'mdi-smoke-detector' },
        { text: "Ad.fire_extinguisher", icon: 'mdi-fire-extinguisher' },
        { text: "Ad.first_aid_kit", icon: 'mdi-plus-circle' },
        { text: "Ad.carbon_monoxide_alarm", icon: 'mdi-molecule-co' },
    ];
    const currency = ref('$');
    const basePrice = ref(0);
    const serviceFee = ref(0);
    const extraFees = ref([]);
    const appliedDiscount = ref(0);

    const totalPrice = computed(() => {
        let extraTotal = extraFees.value.reduce((sum, fee) => sum + (parseFloat(fee.amount) || 0), 0);
        let total = parseFloat(basePrice.value || 0) + parseFloat(serviceFee.value || 0) + extraTotal;
        return total - appliedDiscount.value;
    });
    const receivedAmount = computed(() => (totalPrice.value - discountAmount.value) * 0.94);


    const addExtraFee = () => {
        extraFees.value.push({ title: '', amount: 0 });
    };
    const selectedDiscount = ref(null);

    const discountOptions = [
        { value: 1, title: t("Ad.Special_discount"), description: t("Ad.OffFirstReserve"), percent: 20 },
        { value: 2, title: t("Ad.Weekly_discount"), description: t("Ad.Off7night"), percent: 10 },
        { value: 3, title: t("Ad.Monthly_discount"), description: t("Ad.Off28nightStay"), percent: 20 }
    ];

    const selectDiscount = (discount) => {
        const index = selectedDiscounts.value.findIndex(d => d.value === discount.value);
        if (index === -1) {
            selectedDiscounts.value.push(discount);
        } else {
            selectedDiscounts.value.splice(index, 1);
        }
    };
    watch(() => props.openModal, (newVal) => {
        if (newVal === 'finalStepModal2' && uploadedImages.value.length > 0) {
            uploadedImage.value = uploadedImages.value[0];
        }
    });
    const uploadedImages = ref([]);
    const uploadedImage = ref('');

    watch(() => props.totalPrice, (newValue) => {
        receivedAmount.value = newValue - discountAmount.value;
    });
    const selectedDiscounts = ref([]);

    const toggleDiscount = (value) => {
        const index = selectedDiscounts.value.indexOf(value);
        if (index === -1) {
            selectedDiscounts.value.push(value);
        } else {
            selectedDiscounts.value.splice(index, 1);
        }
    };
    const discountAmount = computed(() => {
        return selectedDiscounts.value.reduce((sum, discount) => {
            return sum + (totalPrice.value * discount.percent / 100);
        }, 0);
    });
    const showCalendar = ref(false);
    const selectedDates = ref([]);

    const saveDates = () => {
        console.log("تاریخ‌های انتخاب‌شده:", selectedDates.value);
        showCalendar.value = false;
    };

    </script>
    <style scoped>
    .modal-container {
        width: 500px !important;
        height: 600px !important;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;


    }
    .modal-title {
        font-size: 18px;
        color: #555;
    }

    .top1{
        margin-top: 30px!important;
    }
     .bottom1{
         margin-bottom: 50px;
     }

    .bold-red-text {
        font-size: 16px;
        font-weight: bold;
        color: red;
    }

    .info-container {
        display: flex;
        flex-direction: column;
        margin-top: 20px;
    }

    .info-box {
        border: 1px solid #ccc;
        padding: 15px;
        margin-bottom: 20px;
    }


    .info-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-image img {
        width: 100px;
        height: 100px;
    }

    .info-details {
        text-align: left;
        margin-left: 10px;
    }

    .price-info {
        display: flex;
        flex-direction: column;
    }

    .modal-content {
        max-height: 350px;
        overflow-y: auto;
        padding: 20px;
    }

    .amenity-card {
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
        cursor: pointer;
    }

    .selected {
        background-color: #1976D2;
        color: white;
    }

    .amenity-text {
        font-size: 14px;
        margin-top: 5px;
    }

    .icon-small {
        font-size: 20px;
    }

    .btn-small {
        font-size: 14px;
    }

    h3, h4 {
        text-align: center;
    }

    p {
        text-align: center;
        font-size: 14px;
    }


    .v-btn {
        text-align: start;
        font-size: 16px;
        font-weight: bold;
    }

    .rectangle {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .description-box {
        width: 100%;
        border: 1px solid #ccc;
        padding: 10px;
        border-radius: 5px;
    }

    .modal-title {
        margin-top: 10px;
        margin-bottom: -80px;
    }

    .modal-img {
        margin-top: 45px;
    }

    .title-extra-margin {
        margin-top: 20px;
    }

    .text-primary {
        color: #8c9eff;
    }

    .text-info {
        color: #9dd8fa;
    }

    .text-muted {
        color: grey;
        margin-top: 20px;
    }

    @media (max-width: 600px) {
        .modal-container {
            width: 90% !important;
            height: 450px !important;
            font-size: 50%;
        }

        .modal-content {
            max-height: 300px;
            padding: 15px;
            font-size: 50%;
        }

        .modal-text, .amenity-text {
            font-size: 10px !important;
        }

        .icon-small {
            font-size: 16px !important;
        }

        .btn-small {
            font-size: 10px !important;
            margin-left: -6px;
            margin-right: -6px;

        }

        .modal-title {
            font-size: 14px !important;
        }

        .modal-img {
            max-width: 80%;
            height: auto;
        }

        .property-card {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .property-card.selected {
            background-color: #8c9eff;
            color: white;
        }

        .font-weight-bold{
            font-size: 70%;
        }

        .font-weight-bold2{
            font-size: 50%;
        }
        .font-weight-bold3{
            font-size: 14px;
        }
        .property-card img {
            height: 60px;
        }
    }
   .selectable-item{
       color: #69e8e1;
   }

    .details{
        height: 500px;
    }


    #map {
        width: 100%;
        height: 300px;
        border-radius: 8px;
        margin-top: 10px;
    }

    .property-card {
        text-align: center;
        padding: 8px;
        border-radius: 8px;
        cursor: pointer;
        border: 1px solid #ddd;
    }
    .property-card.selected {
        border: 2px solid blue;
        background-color: #011e33;

    }

    @media (max-width: 600px) {
        .v-dialog {
            width: 90% !important;
            height: 450px !important;
        }

        .property-card {
            padding: 2px;
        }

        .Txt2 {
            font-size: 10px !important;
        }

        .v-btn {
            font-size: 10px !important;
        }

        .v-icon {
            font-size: 14px !important;
        }
    }
    .image-preview v-img {
        max-height: 150px;
        object-fit: cover;
        width: 100%;
    }

    .v-dialog #map {
        height: 100%;
    }

    .text-center {
        text-align: center;
    }
    .text-center1 {
        text-align: left;
        margin-left: 20px;
    }



    </style>
