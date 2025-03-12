    <template>
        <v-dialog
            :model-value="modelValue"
            @update:model-value="emit('update:modelValue', $event)"
            max-width="600"
        >
            <v-card class="modal-container">
                <v-card-title class="text-center modal-title">
                    <h3>{{ ad ? 'Edit Ad' : 'Create Ad' }}</h3>
                </v-card-title>


                <v-card class="modal-container">
                <v-card-title class="text-center modal-title">
                    <v-img v-if="openModal === 'amenities'" src="/Untitled design (1) 10.png" contain height="100"></v-img>
                    <v-img class="modal-img" v-else-if="openModal === 'photos'" src="/photos.png" contain height="100"></v-img>
                    <v-img class="modal-img" v-else-if="openModal === 'modal4'" src="/Untitled design (2) 14.png" contain height="100"></v-img>
                    <v-img v-else-if="openModal === 'modalStep3'" src="/Untitled design (1) 10.png" contain height="200"></v-img>
                    <v-img v-else-if="openModal === 'Step3-1'" src="/Untitled design (1) 14.png" contain height="150"></v-img>
                    <v-img v-else-if="openModal === 'thirdStepSetPrice'" src="/Untitled design (1) 13.png" contain height="100"></v-img>
                    <v-img v-else-if="openModal === 'discountModal'" src="/Untitled design (1) 13.png" contain height="100"></v-img>

                    <h3 v-if="openModal === 'amenities'">{{ translate('Ad.highlight_your_place') }}</h3>
                    <h3 v-else-if="openModal === 'photos'">{{ translate('Ad.add_photos_of_your_place') }}</h3>
                    <h4 v-else-if="openModal === 'modal4'">{{ translate('Ad.modal_4_title') }}</h4>
                    <h3 class="text-primary" v-else-if="openModal === 'modalStep3'">{{translate('Ad.finalize_and_publish') }}<br>{{ translate('Ad.step_three') }}</h3>
                    <h3 v-else-if="openModal === 'Step3-1'">{{ translate('Ad.HowReserve') }}</h3>
                    <h3 class="top1" v-else-if="openModal === 'thirdStepSetPrice'">{{ translate('Ad.set_your_price') }}</h3>
                    <h3 v-else-if="openModal === 'discountModal'">{{ translate('Ad.discounts') }}</h3>
                    <h2 class="font-weight-bold text-primary font-weight-bold3"  v-else-if="openModal === 'finalStepModal'">{{ translate('Ad.final_step') }}</h2>
                    <h5  v-else-if="openModal === 'finalStepModal2'">{{ translate('Ad.Request_Approval') }}</h5>

                    <p class="modal-text text-info" v-if="openModal === 'amenities'">{{ translate('Ad.step_two') }}<br>{{ translate('Ad.step_two_description') }}</p>
                    <p class="modal-text" v-else-if="openModal === 'photos'">{{ translate('Ad.need_to_add_photos') }}</p>
                    <p class="modal-text text-muted" v-else-if="openModal === 'modalStep3'">{{ translate('Ad.final_step_description') }}</p>
                    <p class="modal-text"  v-else-if="openModal === 'Step3-1'">{{ translate('Ad.CanChange') }} </p>
                    <p class="modal-text top1" v-else-if="openModal === 'thirdStepSetPrice'">{{ translate('Ad.CanChange') }}</p>
                    <p class="modal-text top1"  v-else-if="openModal === 'discountModal'">{{ translate('Ad.Helps_highlight_your_niche') }} </p>
                    <p class="modal-text top1"  v-else-if="openModal === 'finalStepModal'">{{ translate('Ad.host_type_question') }} </p>
                    <h2 class="modal-text  bold-red-text"  v-else-if="openModal === 'finalStepModal2'">{{ translate('Ad.Awaiting_Confirmation') }} </h2>

                </v-card-title>
                <v-card v-if="openModal === 'property'"  class="top1">
                    <v-card-text class="top1" >
                        <p class="Txt2">{{ translate('Ad.Modal1_1') }}</p>
                        <br>
                        <p class="Txt2">{{ translate('Ad.Modal1_2') }}</p>
                        <br>

                        <v-row>
                            <v-col v-for="(option, index) in propertyTypes" :key="index" cols="6" md="3">
                                <v-card
                                    class="property-card"
                                    :class="{ 'selected': selectedProperty === option.title }"
                                    @click="selectProperty(option.title)">
                                    <v-img :src="option.image" height="80"></v-img>
                                    <p class="mt-2 Txt2">{{ translate(option.title) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <v-card v-else-if="openModal === 'map'"  >
                    <v-card-title class="text-h6 Txt2">{{ translate('Ad.WhereAccommodation') }}</v-card-title>
                    <v-card-subtitle class="Txt2"></v-card-subtitle>
                    <v-card-text>
                        <v-text-field v-model="searchQuery" label="Search location" @keyup.enter="searchLocation"></v-text-field>
                        <div id="map" style="height: 300px;"></div>
                    </v-card-text>
                </v-card>
                <v-card v-else-if="openModal === 'details'"  class="top1 details">
                    <v-card-title class="text-h6 top1 Txt2">{{ translate('Ad.ShareAccommodationInfo') }}</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col v-for="(item, index) in accommodationDetails" :key="index" cols="" md="12" >
                                <v-row align="center" justify="space-between">
                                    <v-col cols="8" class="text-center1 Txt2">
                                        <span>{{ translate(item.name) }}</span>
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
                        <h4 class="mb-2" style="margin-top: 70px;"> {{ translate('Ad.tell_guests_about_amenities') }}</h4>
                        <v-row>
                            <v-col v-for="item in amenities" :key="item.text" cols="6" sm="3">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedAmenities.includes(item.text)}"
                                    @click="toggleAmenity(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <p class="amenity-text">{{ translate(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                        <h4 class="mt-4">{{ translate('Ad.special_amenities') }}</h4>
                        <v-row>
                            <v-col v-for="(item, index) in specialAmenities" :key="index" cols="6" sm="3">
                                <v-card
                                    class="text-center pa-2 amenity-card"
                                    outlined
                                    :class="{'selected': selectedAmenities.includes(item.text)}"
                                    @click="toggleAmenity(item.text)"
                                >
                                    <v-icon size="40">{{ item.icon }}</v-icon>
                                    <p class="amenity-text">{{ translate(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                        <h4 class="mt-4">{{ translate('Ad.safety_amenities') }}</h4>
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
                                    <p class="amenity-text">{{ translate(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>
                <template v-else-if="openModal === 'photos'">
                    <div class="rectangle">
                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg d-none d-md-block"
                            @click="openGallery">
                            <v-icon left class="icon-small font-weight-bold">mdi-image</v-icon>
                            {{ translate('Ad.add_photo') }}
                        </v-btn>

                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg mt-2 d-md-none"
                            @click="openCamera">
                            <v-icon left class="icon-small font-weight-bold">mdi-camera</v-icon>
                            {{ translate('Ad.take_new_photo') }}
                        </v-btn>

                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg mt-2 d-md-none"
                            @click="openGallery">
                            <v-icon left class="icon-small font-weight-bold">mdi-image</v-icon>
                            {{ translate('Ad.add_photo') }}
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
                    <h3 class="top1" >{{ translate('Ad.give_title_for_accommodation') }}</h3>
                    <p class="modal-text text-muted ">{{ translate('Ad.short_title_suggestion') }}</p>

                    <v-text-field v-model="title"
                                  max-length="32"
                                  counter
                                  clearable
                                  style="height: 10px;"
                                  @input="checkCharacterLimit"
                    ></v-text-field>
                    <br>
                    <p class="text-left top1" :style="{ fontSize: '12px', color: characterLimitExceeded ? 'red' : 'grey' }">
                        {{ translate('Ad.max_32_characters') }}
                    </p>
                    <br>

                    <h3 >{{ translate('Ad.create_your_description') }}</h3>
                    <p >{{ translate('Ad.share_what_makes_your_place_special') }}</p>

                    <div class="description-container">
                        <v-textarea v-model="description"
                                    counter
                                    maxlength="441"
                                    rows="4"
                                    class="description-box"
                                    @input="checkCharacterLimit2"
                        ></v-textarea>
                        <p class="text-left" :style="{ fontSize: '12px', color: characterLimitExceeded2 ? 'red' : 'grey' }">
                            {{ translate('Ad.max_441_characters') }}
                        </p>
                    </div>

                </v-card>
                <template v-if="openModal === 'modal4'">
                    <div>
                        <p style="margin-top: 50px;" class="modal-text">{{ translate('Ad.modal_4_description') }}</p>
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
                                    <p class="amenity-text">{{ translate(item.text) }}</p>
                                </v-card>
                            </v-col>
                        </v-row>
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
                                <h4 class="font-weight-bold">{{ translate('Ad.quickReserve') }}</h4>
                                <p class="font-weight-bold2">{{ translate('Ad.reservationAutomatically') }}</p>
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
                                <h4 class="font-weight-bold">{{ translate('Ad.AcceptReject') }}</h4>
                                <p class="font-weight-bold2">{{ translate('Ad.reservationRequest') }}</p>
                            </v-col>
                        </v-btn>
                    </div>
                </template>
                <template v-if="openModal === 'thirdStepSetPrice'">
                    <v-row justify="center">
                        <v-col cols="12" class="mb-1" align="center">
                            <h1 class="font-weight-bold text-primary"
                                style="margin-bottom: 10px; margin-top: 10px"
                            >
                                {{ finalTotalPrice }} {{ currency }}
                            </h1>
                        </v-col>

                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="basePrice" :label="translate('Ad.base_price')" type="number" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="serviceFee" :label="translate('Ad.service_fee')" type="number" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0 received-amount2">
                            <v-text-field v-model="totalPrice" :label="translate('Ad.total_price')" dense outlined readonly class="rounded-lg">
                                <template v-slot:append>
                                    <span>{{ currency }}</span>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0 received-amount2">
                            <v-text-field v-model="receivedAmount" :label="translate('Ad.received_amount')" dense outlined readonly class="rounded-lg">
                                <template v-slot:append>
                                    <span>{{ currency }}</span>
                                </template>
                            </v-text-field>
                        </v-col>

                        <discountModal
                            :total-price="totalPrice"
                            :currency="currency"
                            v-model="discountModal"
                        />
                    </v-row>

                    <v-btn v-if="!isCustomer" block color="primary" class="py-3 mt-4 rounded-lg" @click="addExtraFee">
                        + {{ translate('Ad.add_extra_fee') }}
                    </v-btn>

                    <v-row v-for="(fee, index) in extraFees" :key="index" justify="center" align="center">
                        <v-col cols="6">
                            <v-text-field v-model="fee.title" :label="translate('Ad.extra_fee_title')" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="fee.amount" type="number" :label="translate('Ad.amount')" dense outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="2" v-if="isCustomer">
                            <v-checkbox v-model="fee.selected" @change="updateFinalTotal" dense></v-checkbox>
                        </v-col>
                    </v-row>
                </template>
                    <template v-if="openModal === 'discountModal'">
                        <v-row justify="center">
                            <v-col cols="12" align="center">
                                <h1 class="font-weight-bold text-primary" style="margin-top: 10px;">
                                    {{ totalPrice }} {{ currency }}
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
                                            <br>
                                            <br>
                                            <v-card-title class="font-weight-bold3 text-right">{{ translate(discount.title) }}</v-card-title>
                                            <v-card-subtitle class="text-right">{{ translate(discount.description) }}</v-card-subtitle>
                                            <v-card-actions class="justify-start">
                                                <h1 class="text-primary">{{ discount.percent }}%</h1>
                                            </v-card-actions>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-btn color="primary" @click="showCustomDiscount = true">Add custom discount</v-btn>

                            <v-dialog v-model="showCustomDiscount" max-width="500">
                                <v-card>
                                    <v-card-title>Add custom discount</v-card-title>
                                    <v-card-text>
                                            <v-text-field v-model="customDiscountTitle" label="Discount title"></v-text-field>
                                        <v-text-field v-model="customDiscountPercent" label="Discount percentage" type="number"></v-text-field>
                                    </v-card-text>
                                    <v-card-actions>
                                        <v-btn color="primary" @click="addCustomDiscount">Add</v-btn>
                                        <v-btn color="error" @click="showCustomDiscount = false">Cancel</v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-dialog>
                            <v-list>
                                <v-list-item v-for="(discount, index) in selectedDiscounts" :key="index">
                                    <v-list-item-content>
                                        <v-list-item-title>{{ discount.title }} - {{ discount.percent }}%</v-list-item-title>
                                    </v-list-item-content>
                                    <v-list-item-action>
                                        <v-btn icon @click="removeDiscount(index)">
                                            <v-icon>mdi-delete</v-icon>
                                        </v-btn>
                                    </v-list-item-action>
                                </v-list-item>
                            </v-list>
                            <v-col cols="12">
                                <h3>  {{translate('Ad.received_amount') }}: {{ receivedAmount }} €</h3>
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
                                        :label="translate('Ad.host_as_individual')"

                                        :value="'individual'"
                                    />
                                </v-col>
                                <v-col cols="6" class="top1 ">
                                    <v-checkbox
                                        v-model="hostType"
                                        :label="translate('Ad.host_as_business')"
                                        :value="'business'"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4" />
                            <p >{{ translate('Ad.location_features') }}</p>
                            <v-row >
                                <v-col cols="6" >
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('Ad.security_camera')"
                                        :value="'security_camera'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('Ad.sound_insulation')"
                                        :value="'sound_insulation'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('Ad.protective_weapons')"
                                        :value="'protective_weapons'"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4" />
                            <h2 align="center" class="font-weight-bold3" style="color: darkred"><strong>{{ translate('Ad.important_information') }}</strong></h2>
                            <p >{{ translate('Ad.cctv_prohibited') }}</p>
                            <p>{{ translate('Ad.onsite_cameras_required') }}</p>
                            <h4 class="font-weight-bold3" style="color: #1b43ff">{{ translate('Ad.follow_local_regulations') }}</h4>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'finalStepModal2'">
                    <v-row justify="center">
                            <v-row class="top2">
                                <v-col cols="12">
                                    <div class="info-container">
                                        <div class="info-box"  >
                                            <div align="center"  style="color: #858585">{{ translate('Ad.ShowHost') }}</div>
                                            <v-row class="d-flex flex-wrap" justify="center" >
                                                    <v-card class="apartment-card top1" align="center">
                                                        <v-img :src="uploadedImage || uploadedImages[0] || '/20.jpg'" height="100px" class="apartment-img"></v-img>
                                                        <v-card-title class="apartment-title">
                                                            {{ location }}
                                                        </v-card-title>
                                                        <v-card-subtitle class="apartment-subtitle">
                                                            {{ userName }}
                                                        </v-card-subtitle>
                                                        <v-card-text >
                                                            <br />
                                                            <div class="price-info">
                                                                <div >
                                                                    {{ totalPrice }} {{ currency }}
                                                                </div>

                                                            </div>
                                                        </v-card-text>
                                                    </v-card>
                                            </v-row>

                                        </div>
                                    </div>
                                </v-col>

                            </v-row>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <v-btn @click="selectProperty2" block color="primary">{{ translate('Ad.Edit') }}</v-btn>
                        </v-col>
                    </v-row>

                    <v-divider class="my-4"></v-divider>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ translate('Ad.required_sections') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="showCalendar = true">
                        <v-icon class="mr-2">mdi-calendar-month</v-icon>
                        <h3>{{ translate('Ad.Set_up_calendar') }}</h3>
                    </v-row>

                    <v-dialog v-model="showCalendar" max-width="400px" centered persistent class="custom-dialog">
                        <v-card>
                            <v-card-title>{{ translate('Ad.available_dates') }}</v-card-title>
                            <v-card-text>
                                <v-date-picker v-model="selectedDates" multiple></v-date-picker>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" @click="saveDates">{{ translate('Ad.SaveExit') }}</v-btn>
                                <v-btn color="grey" text @click="showCalendar = false"> {{ translate('Ad.Back') }}</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ translate('Ad.choose_available') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="goNext">
                        <h3>{{ translate('Ad.Check_settings') }}</h3>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ translate('Ad.Set_house_rules') }}</p>
                        </v-col>
                    </v-row>
                </template>

                <v-card-actions class="d-flex flex-row flex-wrap justify-end gap-2">
                    <v-btn color="grey" text class="btn-small" style="min-width: auto; padding: 4px 8px;" @click="goBack">
                        {{ translate('Ad.Back') }}
                    </v-btn>

                    <v-btn color="grey" text class="btn-small" style="min-width: auto;
                     padding: 4px 8px;" @click="$emit('update:modelValue', false)">
                        {{ translate('Ad.SaveExit') }}
                    </v-btn>
                    <v-btn color="primary" class="btn-small" style="min-width: auto; padding: 4px 8px;" @click="goNext" :disabled="characterLimitExceeded">
                        {{ translate('Ad.ConfirmNext') }}
                    </v-btn>

                </v-card-actions>
            </v-card>
                </v-card>
        </v-dialog>


    </template>



    <script setup>
    import { ref, computed, defineProps, defineEmits, watch, nextTick ,onMounted } from 'vue';
    import { translate } from "../../../store/languageStore";
    import L from "leaflet";
    import "leaflet/dist/leaflet.css";
    import { useStore } from 'vuex';
    let ads = computed(() => []);
    import MyAds from "../MyAds.vue"
    const store = useStore();
    const title = ref('');
    const description = ref('');
    const images = ref([]);
    const showCustomDiscount = ref(false);
    const addCustomDiscount = () => {
        if (customDiscountTitle.value && customDiscountPercent.value > 0) {
            const newDiscount = {
                title: customDiscountTitle.value,
                percent: parseFloat(customDiscountPercent.value),
            };
            selectedDiscounts.value.push(newDiscount);
            showCustomDiscount.value = false;
            customDiscountTitle.value = '';
            customDiscountPercent.value = 0;
        }
    };

    const removeDiscount = (index) => {
        selectedDiscounts.value.splice(index, 1);
    };

    onMounted(() => {
        ads = computed(() => store.getters.getAds);
    });

    const editAd = (adId) => {
        router.push({ name: 'EditAd', params: { id: adId } });
    };

    const deleteAd = (adId) => {
        store.dispatch('deleteAd', adId);
    };
    const customDiscountTitle = ref('');
    const customDiscountPercent = ref(0);

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
        discount: Boolean,
        ad: {
            type: Object,
            default: null,
        },
    });

    const emit = defineEmits(["update:modelValue", "next", "back", "update-total-price"]);
    const userName = "Default name";
    const location = "Default Location";
    const selectedProperty = ref(props.ad ? props.ad.propertyType : null);
    const selectedAmenities = ref(props.ad ? props.ad.amenities : []);
    const hostType = ref(props.ad ? props.ad.hostType : null);
    const locationFeatures = ref(props.ad ? props.ad.locationFeatures : []);
    const basePrice = ref(props.ad ? props.ad.basePrice : 0);
    const serviceFee = ref(props.ad ? props.ad.serviceFee : 0);
    const extraFees = ref(props.ad ? props.ad.extraFees : []);
    const uploadedImages = ref(props.ad ? props.ad.uploadedImages : []);
    const uploadedImage = ref(props.ad ? props.ad.uploadedImage : '');
    const characterLimitExceeded = ref(false);
    const characterLimitExceeded2 = ref(false);
    const selectedModal4 = ref([]);
    const selectedReservation = ref(null);
    const selectedDiscounts = ref([]);
    const showCalendar = ref(false);
    const selectedDates = ref([]);
    const isCustomer = ref(false);
    const selectProperty = (title) => {
        selectedProperty.value = title;
    };

    const saveAd = () => {
        const adData = {
            title: title.value,
            description: description.value,
            propertyType: selectedProperty.value,
            amenities: selectedAmenities.value,
            hostType: hostType.value,
            locationFeatures: locationFeatures.value,
            basePrice: basePrice.value,
            serviceFee: serviceFee.value,
            extraFees: extraFees.value,
            uploadedImages: uploadedImages.value,
            totalPrice: totalPrice.value,
            receivedAmount: receivedAmount.value,
            images: uploadedImages.value,

        };
        title.value = '';
        description.value = '';
        selectedProperty.value = null;
        uploadedImages.value = [];
        store.dispatch('saveAd', adData);
        router.push({ name: 'MyAds' });

        if (props.ad) {
            store.dispatch('editAd', { id: props.ad.id, ...adData });
        } else {
            store.dispatch('saveAd', adData);
        }

        emit('update:modelValue', false);
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

    const selectReservation = (type) => {
        selectedReservation.value = type;
    };
    const goBack = () => {
        if (openModal.value === "map") {
            openModal.value = "property";
        } else if (openModal.value === "details") {
            openModal.value = "map";
        } else if (openModal.value === 'title') {
            openModal.value = 'photos';
        } else if (openModal.value === 'photos') {
            openModal.value = 'amenities';
        } else if (openModal.value === 'modal4') {
            openModal.value = 'title';
        } else if (openModal.value === 'modalStep3') {
            openModal.value = 'modal4';
        } else if (openModal.value === 'Step3-1') {
            openModal.value = 'modalStep3';
        } else if (openModal.value === 'thirdStepSetPrice') {
            openModal.value = 'Step3-1';
        } else if (openModal.value === 'discountModal') {
            openModal.value = 'thirdStepSetPrice';
        } else if (openModal.value === 'finalStepModal') {
            openModal.value = 'discountModal';
        } else if (openModal.value === 'finalStepModal2') {
            openModal.value = 'finalStepModal';
        } else {
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
            } else if (openModal.value === 'map') {
                openModal.value = 'details';
            } else if (openModal.value === 'details') {
                openModal.value = 'amenities';
            } else if (openModal.value === 'amenities') {
                openModal.value = 'photos';
            } else if (openModal.value === 'photos') {
                openModal.value = 'title';
            } else if (openModal.value === 'title') {
                openModal.value = 'modal4';
            } else if (openModal.value === 'modal4') {
                openModal.value = 'modalStep3';
            } else if (openModal.value === 'modalStep3') {
                openModal.value = 'Step3-1';
            } else if (openModal.value === 'Step3-1') {
                openModal.value = 'thirdStepSetPrice';
            } else if (openModal.value === 'thirdStepSetPrice') {
                openModal.value = 'discountModal';
            } else if (openModal.value === 'discountModal') {
                openModal.value = 'finalStepModal';
            } else if (openModal.value === 'finalStepModal') {
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
                const validFiles = files.slice(0, maxImages - uploadedImages.value.length);
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

    const currency = ref('€');
    const appliedDiscount = ref(0);
    const discountAmount = computed(() => {
        return selectedDiscounts.value.reduce((sum, discount) => {
            return (totalPrice.value * discount.percent / 100);
        }, 0);
    });

    const finalTotalPrice = computed(() => totalPrice.value - discountAmount.value);

    const discountOptions = [
        { value: 1, title: translate("Ad.Special_discount"), description: translate("Ad.OffFirstReserve"), percent: 20 },
        { value: 2, title: translate("Ad.Weekly_discount"), description: translate("Ad.Off7night"), percent: 10 },
        { value: 3, title: translate("Ad.Monthly_discount"), description: translate("Ad.Off28nightStay"), percent: 20 }
    ];

    watch(() => props.openModal, (newVal) => {
        if (newVal === 'finalStepModal2' && uploadedImages.value.length > 0) {
            uploadedImage.value = uploadedImages.value[0];
        }
    });

    watch(() => props.totalPrice, (newValue) => {

    });

    const toggleDiscount = (value) => {
        const index = selectedDiscounts.value.indexOf(value);
        if (index === -1) {
            selectedDiscounts.value.push(value);
        } else {
            selectedDiscounts.value.splice(index, 1);
        }
    };

    const saveDates = () => {
        console.log("Selected dates:", selectedDates.value);
        showCalendar.value = false;
    };

    const updateFinalTotal = () => {
    };

    const checkCharacterLimit = () => {
        characterLimitExceeded.value = title.value.length > 32;
    };

    const checkCharacterLimit2 = () => {
        characterLimitExceeded2.value = description.value.length > 441;
    };

    const toggleAmenity = (amenity) => {
        const index = selectedAmenities.value.indexOf(amenity);
        if (index === -1) {
            selectedAmenities.value.push(amenity);
        } else {
            selectedAmenities.value.splice(index, 1);
        }
    };

    const addExtraFee = () => {
        extraFees.value.push({ title: '', amount: 0 });
    };

    const selectDiscount = (discount) => {
        if (selectedDiscounts.value.some(d => d.value === discount.value)) {
            selectedDiscounts.value = selectedDiscounts.value.filter(d => d.value !== discount.value);
        } else {
            selectedDiscounts.value.push(discount);
        }
    };


    const totalPrice = computed(() => {
        let extraTotal = extraFees.value.reduce((sum, fee) => sum + (parseFloat(fee.amount) || 0), 0);
        let total = parseFloat(basePrice.value || 0) + parseFloat(serviceFee.value || 0) + extraTotal;
        return total - (total * (selectedDiscounts.value.reduce((sum, discount) => sum + discount.percent, 0) / 100));
    });

    const receivedAmount = computed(() => totalPrice.value * 0.94);

    watch(() => props.modelValue, (newVal) => {
        if (newVal && props.ad) {
            title.value = props.ad.title;
            description.value = props.ad.description;
            selectedProperty.value = props.ad.propertyType;
            selectedAmenities.value = props.ad.amenities;
            hostType.value = props.ad.hostType;
            locationFeatures.value = props.ad.locationFeatures;
            basePrice.value = props.ad.basePrice;
            serviceFee.value = props.ad.serviceFee;
            extraFees.value = props.ad.extraFees;
            uploadedImages.value = props.ad.uploadedImages;
            uploadedImage.value = props.ad.uploadedImage;
        }
    });

    </script>



    <style scoped>
    .modal-container {
        width: 500px !important;
        height: 700px !important;
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
    .custom-dialog {
        max-width: 800px !important;
        height: 90vh !important;
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


    .info-image img {
        width: 100px;
        height: 100px;
    }

    .price-info {
        margin-top: -30px;
        display: flex;
        flex-direction: column;
        font-size: 18px;
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
        .price-info {
            display: flex;
            flex-direction: column;
            font-size: 14px;
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


    .received-amount2 {
        color: #83ceff;
        font-weight: bold;
        font-size: 1.25rem;
        text-align: center;
    }
    .apartment-card{
        background-color: var(--price-color );
        color: var(--background-color);
    }

    .top2{
        margin-top: 70px;
    }
    .apartment-img{
        border-radius: 20px;
        margin-top: 5px;
    }
    </style>
