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
                    <v-img v-if="openModal === 'amenities'" src="/Untitled design (1) 10.png" contain
                           height="100"></v-img>
                    <v-img class="modal-img" v-else-if="openModal === 'photos'" src="/Untitled design (8) 2.png" contain
                           height="100"></v-img>
                    <v-img v-else-if="openModal === 'modalStep3'" src="/Untitled design (1) 10.png" contain
                           height="200"></v-img>
                    <v-img v-else-if="openModal === 'Step3-1'" src="/Untitled design (1) 14.png" contain
                           height="150"></v-img>
                    <v-img v-else-if="openModal === 'thirdStepSetPrice'" src="/Untitled design (1) 13.png" contain
                           height="100"></v-img>
                    <v-img v-else-if="openModal === 'discountModal'" src="/Untitled design (1) 14.png" contain
                           height="100"></v-img>

                    <h3 v-if="openModal === 'amenities'">{{ translate('AD_HIGHLIGHT_YOUR_PLACE') }}</h3>
                    <h3 v-else-if="openModal === 'photos'">{{ translate('AD_ADD_PHOTOS_OF_YOUR_PLACE') }}</h3>
                    <h4 v-else-if="openModal === 'modal4'">{{ translate('AD_MODAL_4_TITLE') }}</h4>
                    <h3 class="text-primary" v-else-if="openModal === 'modalStep3'">
                        {{translate('AD_FINALIZE_AND_PUBLISH') }}<br>{{ translate('AD_STEP_THREE') }}</h3>
                    <h3 v-else-if="openModal === 'Step3-1'">{{ translate('AD_HOWRESERVE') }}</h3>
                    <h3 class="top1" v-else-if="openModal === 'thirdStepSetPrice'">{{ translate('AD_SET_YOUR_PRICE')
                        }}</h3>
                    <h3 v-else-if="openModal === 'discountModal'">{{ translate('AD_DISCOUNTS') }}</h3>
                    <h2 class="font-weight-bold text-primary font-weight-bold3"
                        v-else-if="openModal === 'finalStepModal'">{{ translate('AD_FINAL_STEP') }}</h2>
                    <h5 v-else-if="openModal === 'finalStepModal2'">{{ translate('AD_REQUEST_APPROVAL') }}</h5>

                    <p class="modal-text text-info" v-if="openModal === 'amenities'">{{ translate('AD_STEP_TWO') }}<br>{{
                            translate('step_two_description') }}</p>
                    <p class="modal-text" v-else-if="openModal === 'photos'">{{ translate('AD_NEED_TO_ADD_PHOTOS')
                        }}</p>
                    <p class="modal-text text-muted" v-else-if="openModal === 'modalStep3'">{{
                            translate('AD_FINAL_STEP_DESCRIPTION') }}</p>
                    <p class="modal-text" v-else-if="openModal === 'Step3-1'">{{ translate('AD_CANCHANGE') }} </p>
                    <p class="modal-text top1" v-else-if="openModal === 'thirdStepSetPrice'">{{
                            translate('AD_CANCHANGE') }}</p>
                    <p class="modal-text top1" v-else-if="openModal === 'discountModal'">{{
                            translate('AD_HELPS_HIGHLIGHT_YOUR_NICHE') }} </p>
                    <p class="modal-text top1" v-else-if="openModal === 'finalStepModal'">{{
                            translate('AD_HOST_TYPE_QUESTION') }} </p>
                    <h2 class="modal-text  bold-red-text" v-else-if="openModal === 'finalStepModal2'">{{
                            translate('AD_AWAITING_CONFIRMATION') }} </h2>

                </v-card-title>
                <v-card v-if="openModal === 'property'" class="top1">
                    <v-card-text class="top1">
                        <p class="Txt2">{{ translate('AD_MODAL1_1') }}</p>
                        <br>
                        <p class="Txt2">{{ translate('AD_MODAL1_2') }}</p>
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
                <v-card v-else-if="openModal === 'map'">
                    <v-card-title class="text-h6 Txt2">{{ translate('AD_WHEREACCOMMODATION') }}</v-card-title>
                    <v-card-subtitle class="Txt2"></v-card-subtitle>
                    <v-card-text>
                        <v-text-field v-model="searchQuery" label="Search location"
                                      @keyup.enter="searchLocation"></v-text-field>
                        <div id="map" style="height: 300px;"></div>
                    </v-card-text>
                </v-card>
                <v-card v-else-if="openModal === 'details'" class="top1 details">
                    <v-card-title class="text-h6 top1 Txt2">{{ translate('AD_SHAREACCOMMODATIONINFO') }}</v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col v-for="(item, index) in accommodationDetails" :key="index" cols="" md="12">
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
                    <h4 class="mb-2" style="margin-top: 70px;"> {{ translate('AD_TELL_GUESTS_ABOUT_AMENITIES') }}</h4>
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
                    <h4 class="mt-4">{{ translate('AD_SPECIAL_AMENITIES') }}</h4>
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
                    <h4 class="mt-4">{{ translate('AD_SAFETY_AMENITIES') }}</h4>
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
                            {{ translate('AD_ADD_PHOTO') }}
                        </v-btn>

                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg mt-2 d-md-none"
                            @click="openCamera">
                            <v-icon left class="icon-small font-weight-bold">mdi-camera</v-icon>
                            {{ translate('AD_TAKE_NEW_PHOTO') }}
                        </v-btn>

                        <v-btn
                            block
                            color="dark-gray lighten-3"
                            class="py-8 rounded-lg mt-2 d-md-none"
                            @click="openGallery">
                            <v-icon left class="icon-small font-weight-bold">mdi-image</v-icon>
                            {{ translate('AD_ADD_PHOTO') }}
                        </v-btn>
                    </div>

                    <div class="image-preview mt-4">
                        <v-row>
                            <v-col v-for="(image, index) in uploadedImages" :key="index" cols="4">
                                <v-img :src="image" class="rounded-lg" aspect-ratio="1"></v-img>
                                <v-btn
                                    v-if="uploadedImages.length > 3"
                                    icon
                                    small
                                    color="error"
                                    @click="removeImage(index)"
                                    class="image-remove-btn"
                                >
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                        <p class="text-caption text-center mt-2">
                            {{ translate('Ad.image_upload_limit', {min: 3, max: 10}) }}
                            ({{ uploadedImages.length }}/10)
                        </p>
                    </div>
                </template>
                <v-card v-else-if="openModal === 'title'">
                    <h3 class="top1">{{ translate('AD_GIVE_TITLE_FOR_ACCOMMODATION') }}</h3>
                    <p class="modal-text text-muted ">{{ translate('AD_SHORT_TITLE_SUGGESTION') }}</p>

                    <v-text-field v-model="title"
                                  max-length="32"
                                  counter
                                  clearable
                                  style="height: 10px;"
                                  @input="checkCharacterLimit"
                    ></v-text-field>
                    <br>
                    <p class="text-left top1"
                       :style="{ fontSize: '12px', color: characterLimitExceeded ? 'red' : 'grey' }">
                        {{ translate('AD_MAX_32_CHARACTERS') }}
                    </p>
                    <br>

                    <h3>{{ translate('AD_CREATE_YOUR_DESCRIPTION') }}</h3>
                    <p>{{ translate('AD_SHARE_WHAT_MAKES_YOUR_PLACE_SPECIAL') }}</p>

                    <div class="description-container">
                        <v-textarea v-model="description"
                                    counter
                                    maxlength="441"
                                    rows="4"
                                    class="description-box"
                                    @input="checkCharacterLimit2"
                        ></v-textarea>
                        <p class="text-left"
                           :style="{ fontSize: '12px', color: characterLimitExceeded2 ? 'red' : 'grey' }">
                            {{ translate('AD_MAX_441_CHARACTERS') }}
                        </p>
                    </div>

                </v-card>
                <template v-if="openModal === 'modal4'">
                    <div>
                        <p style="margin-top: 50px;" class="modal-text">{{ translate('AD_MODAL_4_DESCRIPTION') }}</p>
                        <br>
                        <v-row class="flex-wrap">
                            <v-col v-for="(item, index) in modal4Options" :key="index" cols="6" sm="4">
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
                                <h4 class="font-weight-bold">{{ translate('AD_QUICKRESERVE') }}</h4>
                                <p class="font-weight-bold2">{{ translate('AD_RESERVATIONAUTOMATICALLY') }}</p>
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
                                <h4 class="font-weight-bold">{{ translate('AD_ACCEPTREJECT') }}</h4>
                                <p class="font-weight-bold2">{{ translate('AD_RESERVATIONREQUEST') }}</p>
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
                            <v-text-field v-model="basePrice" :label="translate('AD_BASE_PRICE')" type="number" dense
                                          outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0">
                            <v-text-field v-model="serviceFee" :label="translate('AD_SERVICE_FEE')" type="number" dense
                                          outlined class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0 received-amount2">
                            <v-text-field v-model="totalPrice" :label="translate('AD_TOTAL_PRICE')" dense outlined
                                          readonly class="rounded-lg">
                                <template v-slot:append>
                                    <span>{{ currency }}</span>
                                </template>
                            </v-text-field>
                        </v-col>
                        <v-col cols="8" class="mb-0 received-amount2">
                            <v-text-field v-model="totalPrice" :label="translate('AD_RECEIVED_AMOUNT')" dense
                                          outlined readonly class="rounded-lg">
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
                        + {{ translate('AD_ADD_EXTRA_FEE') }}
                    </v-btn>

                    <v-row v-for="(fee, index) in extraFees" :key="index" justify="center" align="center">
                        <v-col cols="6">
                            <v-text-field v-model="fee.title" :label="translate('AD_EXTRA_FEE_TITLE')" dense outlined
                                          class="rounded-lg"></v-text-field>
                        </v-col>
                        <v-col cols="4">
                            <v-text-field v-model="fee.amount" type="number" :label="translate('AD_AMOUNT')" dense
                                          outlined class="rounded-lg"></v-text-field>
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
                                        <v-card-title class="font-weight-bold3 text-right">{{ translate(discount.title)
                                            }}
                                        </v-card-title>
                                        <v-card-subtitle class="text-right">{{ translate(discount.description) }}
                                        </v-card-subtitle>
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
                                    <v-text-field v-model="customDiscountPercent" label="Discount percentage"
                                                  type="number"></v-text-field>
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
                                    <v-list-item-title>{{ discount.title }} - {{ discount.percent }}%
                                    </v-list-item-title>
                                </v-list-item-content>
                                <v-list-item-action>
                                    <v-btn icon @click="removeDiscount(index)">
                                        <v-icon>mdi-delete</v-icon>
                                    </v-btn>
                                </v-list-item-action>
                            </v-list-item>
                        </v-list>
                        <v-col cols="12">
                            <h3> {{translate('AD_RECEIVED_AMOUNT') }}: {{ receivedAmount }} €</h3>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'finalStepModal'">
                    <v-row justify="center">
                        <v-col cols="12">
                            <v-row class="top1">
                                <v-col cols="6" class="top1">
                                    <v-checkbox
                                        v-model="hostType"
                                        :label="translate('AD_HOST_AS_INDIVIDUAL')"
                                        :value="'individual'"
                                        required
                                    />
                                </v-col>
                                <v-col cols="6" class="top1">
                                    <v-checkbox
                                        v-model="hostType"
                                        :label="translate('AD_HOST_AS_BUSINESS')"
                                        :value="'business'"
                                        required
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4"/>
                            <p>{{ translate('AD_LOCATION_FEATURES') }}</p>
                            <v-row>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('AD_SECURITY_CAMERA')"
                                        :value="'security_camera'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('AD_SOUND_INSULATION')"
                                        :value="'sound_insulation'"
                                    />
                                </v-col>
                                <v-col cols="6">
                                    <v-checkbox
                                        v-model="locationFeatures"
                                        :label="translate('AD_PROTECTIVE_WEAPONS')"
                                        :value="'protective_weapons'"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>

                        <v-col cols="12">
                            <v-divider class="my-4"/>
                            <h2 align="center" class="font-weight-bold3" style="color: darkred"><strong>{{
                                    translate('AD_IMPORTANT_INFORMATION') }}</strong></h2>
                            <p>{{ translate('AD_CCTV_PROHIBITED') }}</p>
                            <p>{{ translate('AD_ONSITE_CAMERAS_REQUIRED') }}</p>
                            <h4 class="font-weight-bold3" style="color: #1b43ff">{{
                                    translate('AD_FOLLOW_LOCAL_REGULATIONS') }}</h4>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'calendarModal'">
                    <v-row justify="center">
                        <v-col cols="12">
                            <h3 class="text-center">{{ translate('SELECT_AVAILABLE_DATES') }}</h3>
                            <v-date-picker
                                v-model="selectedDates"
                                range
                                multiple
                                :min="new Date().toISOString().substr(0, 10)"
                            ></v-date-picker>
                        </v-col>
                    </v-row>
                </template>
                <template v-if="openModal === 'finalStepModal2'">
                    <v-row justify="center">
                        <v-row class="top2">
                            <v-col cols="12">
                                <div class="info-container">
                                    <div class="info-box">
                                        <div align="center" style="color: #858585">{{ translate('AD_SHOWHOST') }}</div>
                                        <v-row class="d-flex flex-wrap" justify="center">
                                            <v-card class="apartment-card top1" align="center">
                                                <v-img :src="uploadedImage || uploadedImages[0] || '/20.jpg'"
                                                       height="100px" class="apartment-img"></v-img>
                                                <v-card-title class="apartment-title">
                                                    {{ location }}
                                                </v-card-title>
                                                <v-card-subtitle class="apartment-subtitle">
                                                    {{ userName }}
                                                </v-card-subtitle>
                                                <v-card-text>
                                                    <br/>
                                                    <div class="price-info">
                                                        <div>
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
                            <p>{{ translate('AD_REQUIRED_SECTIONS') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="openModal = 'calendarModal'">
                        <v-icon class="mr-2">mdi-calendar-month</v-icon>
                        <h3>{{ translate('AD_SET_UP_CALENDAR') }}</h3>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ translate('AD_CHOOSE_AVAILABLE') }}</p>
                        </v-col>
                    </v-row>

                    <v-row align="center" justify="center" class="selectable-item" @click="goNext">
                        <h3>{{ translate('AD_CHECK_SETTINGS') }}</h3>
                    </v-row>

                    <v-row>
                        <v-col cols="12">
                            <p>{{ translate('AD_SET_HOUSE_RULES') }}</p>
                        </v-col>
                    </v-row>
                </template>

                <v-card-actions class="d-flex flex-row flex-wrap justify-end gap-2">
                    <v-btn color="grey" text class="btn-small" style="min-width: auto; padding: 4px 8px;"
                           @click="goBack">
                        {{ translate('BACK') }}
                    </v-btn>

                    <v-btn color="grey" text class="btn-small" style="min-width: auto;
                     padding: 4px 8px;" @click="$emit('update:modelValue', false)">
                        {{ translate('SAVEEXIT') }}
                    </v-btn>
                    <v-btn
                        color="primary"
                        class="btn-small"
                        style="min-width: auto; padding: 4px 8px;"
                        @click="goNext"
                        :disabled="characterLimitExceeded || (openModal === 'finalStepModal' && !hostType.length)"
                    >
                        {{ openModal === 'finalStepModal2' ? translate('PUBLISHANDFINISH') : translate('AD_CONFIRMNEXT') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-card>
    </v-dialog>
</template>

<script>
//Todo:{ad:title/description/propertyType/amenities/hostType/locationFeatures/basePrice/serviceFee/uploadedImages/totalPrice/reservationType
//Todo: receivedAmount/availableDates:: ["2023-12-15", "2023-12-16"]/location: "123 Main St, City, Country"
//Todo: coordinates:  "lat": 35.6892,"lng": 51.3890
//Todo: accommodationDetails:guests/rooms/beds/bathrooms
//Todo: extraFees:title/amount/
//Todo: specialFeatures/discounts:title/percent/value
//Todo: status:published

import { translate } from "../../../store/languageStore";
import imageUploadService from '../../../services/ imageUploadService.js';

export default {
    props: {
        modelValue: Boolean,
        totalPrice: Number,
        currency: {
            type: String,
            default: '€'
        },
        title: String,
        uploadedImage: String,
        city: String,
        country: String,
        userName: String,
        basePrice: {
            type: Number,
            default: 0
        },
        discountedPrice: Number,
        discount: Boolean,
        ad: {
            type: Object,
            default: null
        }
    },

    emits: ['update:modelValue', 'next', 'back', 'update-total-price'],

    data() {
        return {
            openModal: "property",
            title: this.ad ? this.ad.title : '',
            description: this.ad ? this.ad.description : '',
            selectedProperty: this.ad ? this.ad.propertyType : null,
            selectedAmenities: this.ad ? this.ad.amenities : [],
            hostType: this.ad ? this.ad.hostType : [],
            locationFeatures: this.ad ? this.ad.locationFeatures : [],
            basePrice: this.ad ? this.ad.basePrice : 0,
            serviceFee: this.ad ? this.ad.serviceFee : 0,
            extraFees: this.ad ? this.ad.extraFees : [],
            uploadedImages: this.ad ? this.ad.uploadedImages : [],
            uploadedImage: this.ad ? this.ad.uploadedImage : '',
            characterLimitExceeded: false,
            characterLimitExceeded2: false,
            selectedModal4: [],
            selectedReservation: null,
            selectedDiscounts: [],
            selectedDates: [],
            isCustomer: false,
            searchQuery: "",
            showCustomDiscount: false,
            customDiscountTitle: '',
            customDiscountPercent: 0,
            map: null,
            marker: null,
            userName: "Default name",
            location: "Default Location",

            propertyTypes: [
                {title: "AD_HOME", image: "/home-icon.png"},
                {title: "AD_APARTMENT", image: "/apartment-icon.png"},
                {title: "AD_FURNITURE", image: "/furniture-icon.png"},
                {title: "AD_BED", image: "/bed-icon.png"},
                {title: "AD_CAMPER", image: "/car-icon.png"},
                {title: "AD_TRAVELTENT", image: "/tent-icon.png"},
                {title: "AD_CONTAINER", image: "/container.png"},
                {title: "AD_TREEHOUSE", image: "/Treehouse.png"}
            ],
            accommodationDetails: [
                {name: "AD_GUEST", value: 1},
                {name: "AD_ROOM", value: 1},
                {name: "AD_BED", value: 1},
                {name: "AD_BATHROOM", value: 1}
            ],
            modal4Options: [
                {text: "AD_PEACEFUL", icon: 'mdi-home-heart'},
                {text: "AD_UNIQUE", icon: 'mdi-flower'},
                {text: "AD_FAMILY_FAVORITE", icon: 'mdi-heart'},
                {text: "AD_UNIQUE_STYLE", icon: 'mdi-palette'},
                {text: "AD_CENTER", icon: 'mdi-map-marker'},
                {text: "AD_SPACIOUS", icon: 'mdi-home-variant'}
            ],
            amenities: [
                {text: "AD_WIFI", icon: 'mdi-wifi'},
                {text: "AD_TELEVISION", icon: 'mdi-television'},
                {text: "AD_KITCHEN", icon: 'mdi-silverware-fork-knife'},
                {text: "AD_WASHING_MACHINE", icon: 'mdi-washing-machine'},
                {text: "AD_FREE_PARKING", icon: 'mdi-parking'},
                {text: "AD_PAID_PARKING", icon: 'mdi-currency-usd'},
                {text: "AD_AIR_CONDITIONING", icon: 'mdi-air-conditioner'},
                {text: "AD_WORKSPACE", icon: 'mdi-desk'}
            ],
            specialAmenities: [
                {text: "AD_POOL", icon: 'mdi-pool'},
                {text: "AD_YARD", icon: 'mdi-tree'},
                {text: "AD_BARBECUE", icon: 'mdi-grill'},
                {text: "AD_PATIO", icon: 'mdi-patio-heater'},
                {text: "AD_GYM", icon: 'mdi-dumbbell'},
                {text: "AD_SEA_ACCESS", icon: 'mdi-wave'}
            ],
            safetyFeatures: [
                {text: "AD_SMOKE_ALARM", icon: 'mdi-smoke-detector'},
                {text: "AD_FIRE_EXTINGUISHER", icon: 'mdi-fire-extinguisher'},
                {text: "AD_FIRST_AID_KIT", icon: 'mdi-plus-circle'},
                {text: "AD_CARBON_MONOXIDE_ALARM", icon: 'mdi-molecule-co'}
            ],
            discountOptions: [
                {value: 1, title: this.translate("AD_SPECIAL_DISCOUNT"), description: this.translate("AD_OFFFIRSTRESERVE"), percent: 20},
                {value: 2, title: this.translate("AD_WEEKLY_DISCOUNT"), description: this.translate("AD_OFF7NIGHT"), percent: 10},
                {value: 3, title: this.translate("AD_MONTHLY_DISCOUNT"), description: this.translate("AD_OFF28NIGHTSTAY"), percent: 20}
            ]
        };
    },

    computed: {
        discountAmount() {
            return this.selectedDiscounts.reduce((sum, discount) => {
                return (this.totalPrice * discount.percent / 100);
            }, 0);
        },

        calculatedBaseTotal() {
            const base = parseFloat(this.basePrice) || 0;
            const service = parseFloat(this.serviceFee) || 0;
            const extras = this.extraFees.reduce((sum, fee) => sum + (parseFloat(fee.amount) || 0), 0);
            return base + service + extras;
        },

        totalDiscount() {
            return this.selectedDiscounts.reduce((sum, discount) => sum + discount.percent, 0);
        },

        totalPrice() {
            const baseTotal = this.calculatedBaseTotal;
            return baseTotal - (baseTotal * (this.totalDiscount / 100));
        },

        receivedAmount() {
            return this.totalPrice - 10;
        },

        finalTotalPrice() {
            return this.totalPrice;
        },

        hasMinimumImages() {
            return this.uploadedImages.length >= 3;
        }
    },

    watch: {
        modelValue(newVal) {
            if (newVal && this.ad) {
                this.title = this.ad.title;
                this.description = this.ad.description;
                this.selectedProperty = this.ad.propertyType;
                this.selectedAmenities = this.ad.amenities;
                this.hostType = this.ad.hostType;
                this.locationFeatures = this.ad.locationFeatures;
                this.basePrice = this.ad.basePrice;
                this.serviceFee = this.ad.serviceFee;
                this.extraFees = this.ad.extraFees;
                this.uploadedImages = this.ad.uploadedImages;
                this.uploadedImage = this.ad.uploadedImage;
                this.selectedDates = this.ad.availableDates || [];
            }
        },
        openModal(newVal) {
            if (newVal === 'finalStepModal2' && this.uploadedImages.length > 0) {
                this.uploadedImage = this.uploadedImages[0];
            }
            if (newVal === 'map') {
                this.$nextTick(() => {
                    this.initMap();
                });
            }
        },
        basePrice() {
            this.updateFinalTotal();
        },
        serviceFee() {
            this.updateFinalTotal();
        },
        extraFees: {
            deep: true,
            handler() {
                this.updateFinalTotal();
            }
        }
    },

    methods: {
        translate,

        selectProperty(title) {
            this.selectedProperty = title;
        },

        selectProperty2() {
            this.openModal = "property";
        },

        goBack() {
            const modalFlow = {
                "map": "property",
                "details": "map",
                "title": "photos",
                "photos": "amenities",
                "modal4": "title",
                "modalStep3": "modal4",
                "Step3-1": "modalStep3",
                "thirdStepSetPrice": "Step3-1",
                "discountModal": "thirdStepSetPrice",
                "finalStepModal": "discountModal",
                "finalStepModal2": "finalStepModal",
                "calendarModal": "finalStepModal2"
            };

            this.openModal = modalFlow[this.openModal] || (this.$emit('update:modelValue', false), false);
        },

        goNext() {
            if (this.characterLimitExceeded) {
                return;
            }

            if (this.openModal === 'property' && !this.selectedProperty) {
                alert("Please select a property type.");
                return;
            }

            if (this.openModal === 'photos' && !this.hasMinimumImages) {
                alert("Please upload at least 3 images.");
                return;
            }

            if (this.openModal === 'finalStepModal' && this.hostType.length === 0) {
                alert("Please select host type (individual or business).");
                return;
            }

            const modalFlow = {
                "property": "map",
                "map": "details",
                "details": "amenities",
                "amenities": "photos",
                "photos": "title",
                "title": "modal4",
                "modal4": "modalStep3",
                "modalStep3": "Step3-1",
                "Step3-1": "thirdStepSetPrice",
                "thirdStepSetPrice": "discountModal",
                "discountModal": "finalStepModal",
                "finalStepModal": "calendarModal",
                "calendarModal": "finalStepModal2",
                "finalStepModal2": "publish"
            };

            const nextModal = modalFlow[this.openModal];

            if (nextModal === 'publish') {
                this.publishAd();
            } else if (nextModal) {
                this.openModal = nextModal;
            }
        },

        async openGallery() {
            try {
                const images = await imageUploadService.openGallery(10, 2);
                const remainingSlots = 10 - this.uploadedImages.length;
                this.uploadedImages.push(...images.slice(0, remainingSlots));
            } catch (error) {
                console.error("Error in openGallery:", error);
                alert(error.message);
            }
        },

        async openCamera() {
            try {
                const image = await imageUploadService.openCamera(2);
                if (image && this.uploadedImages.length < 10) {
                    this.uploadedImages.push(image);
                }
            } catch (error) {
                console.error("Error in openCamera:", error);
                alert(error.message);
            }
        },

        removeImage(index) {
            this.uploadedImages.splice(index, 1);
        },

        initMap() {
            try {
                if (!this.map) {
                    this.map = L.map("map").setView([35.6892, 51.3890], 13);
                    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                    }).addTo(this.map);
                    this.marker = L.marker([35.6892, 51.3890], {draggable: true}).addTo(this.map);
                    this.map.on('click', (e) => {
                        const {lat, lng} = e.latlng;
                        this.marker.setLatLng([lat, lng]);
                        this.updateSearchQuery(e.latlng);
                    });
                }
            } catch (error) {
                console.error("Error initializing map:", error);
                alert("An error occurred while initializing the map");
            }
        },

        updateSearchQuery(latLng) {
            try {
                const {lat, lng} = latLng;
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        this.searchQuery = data.display_name;
                        this.location = data.display_name;
                    });
            } catch (error) {
                console.error("Error updating search query:", error);
            }
        },

        searchLocation() {
            try {
                if (!this.searchQuery) return;
                fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const {lat, lon} = data[0];
                            this.map.setView([lat, lon], 13);
                            this.marker.setLatLng([lat, lon]);
                            this.searchQuery = data[0].display_name;
                            this.location = data[0].display_name;
                        }
                    });
            } catch (error) {
                console.error("Error searching location:", error);
                alert("An error occurred while searching for the location");
            }
        },

        toggleModal4Option(option) {
            const index = this.selectedModal4.indexOf(option);
            if (index === -1) {
                this.selectedModal4.push(option);
            } else {
                this.selectedModal4.splice(index, 1);
            }
        },

        increment(index) {
            this.accommodationDetails[index].value += 1;
        },

        decrement(index) {
            if (this.accommodationDetails[index].value > 0) {
                this.accommodationDetails[index].value -= 1;
            }
        },

        selectReservation(type) {
            this.selectedReservation = type;
        },

        saveDates() {
            console.log("Selected dates:", this.selectedDates);
            this.showCalendar = false;
        },

        checkCharacterLimit() {
            this.characterLimitExceeded = this.title.length > 32;
        },

        checkCharacterLimit2() {
            this.characterLimitExceeded2 = this.description.length > 441;
        },

        toggleAmenity(amenity) {
            const index = this.selectedAmenities.indexOf(amenity);
            if (index === -1) {
                this.selectedAmenities.push(amenity);
            } else {
                this.selectedAmenities.splice(index, 1);
            }
        },

        addExtraFee() {
            this.extraFees.push({title: '', amount: 0, selected: true});
        },

        updateFinalTotal() {
            this.$emit('update-total-price', this.totalPrice);
        },

        selectDiscount(discount) {
            if (this.selectedDiscounts.some(d => d.value === discount.value)) {
                this.selectedDiscounts = this.selectedDiscounts.filter(d => d.value !== discount.value);
            } else {
                this.selectedDiscounts.push(discount);
            }
            this.updateFinalTotal();
        },

        addCustomDiscount() {
            try {
                if (this.customDiscountTitle && this.customDiscountPercent > 0) {
                    const newDiscount = {
                        title: this.customDiscountTitle,
                        percent: parseFloat(this.customDiscountPercent),
                        value: Date.now()
                    };
                    this.selectedDiscounts.push(newDiscount);
                    this.showCustomDiscount = false;
                    this.customDiscountTitle = '';
                    this.customDiscountPercent = 0;
                    this.updateFinalTotal();
                }
            } catch (error) {
                console.error("Error adding custom discount:", error);
                alert("An error occurred while adding the discount");
            }
        },

        removeDiscount(index) {
            this.selectedDiscounts.splice(index, 1);
            this.updateFinalTotal();
        },

        publishAd() {
            try {
                if (!this.hasMinimumImages) {
                    alert("Please upload at least 3 images before publishing.");
                    return;
                }

                if (this.hostType.length === 0) {
                    alert("Please select host type (individual or business).");
                    return;
                }

                if (this.selectedDates.length === 0) {
                    alert("Please select available dates on the calendar.");
                    return;
                }

                const adData = {
                    title: this.title,
                    description: this.description,
                    propertyType: this.selectedProperty,
                    amenities: this.selectedAmenities,
                    hostType: this.hostType,
                    locationFeatures: this.locationFeatures,
                    basePrice: this.basePrice,
                    serviceFee: this.serviceFee,
                    extraFees: this.extraFees,
                    uploadedImages: this.uploadedImages,
                    totalPrice: this.totalPrice,
                    receivedAmount: this.receivedAmount,
                    availableDates: this.selectedDates,
                    location: this.location,
                    reservationType: this.selectedReservation,
                    status: 'pending'
                };

                this.$emit('update:modelValue', false);

                if (this.ad) {
                    this.$store.dispatch('editAd', {id: this.ad.id, ...adData});
                } else {
                    this.$store.dispatch('publishAd', adData);
                }

                this.$router.push({name: 'MyAds'});
            } catch (error) {
                console.error("Error publishing ad:", error);
                alert("An error occurred while publishing the ad");
            }
        },

        closeModal() {
            this.$emit('update:modelValue', false);
        },

    }
};
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

.top1 {
    margin-top: 30px !important;
}

.bottom1 {
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

    .font-weight-bold {
        font-size: 70%;
    }

    .font-weight-bold2 {
        font-size: 50%;
    }

    .font-weight-bold3 {
        font-size: 14px;
    }

    .property-card img {
        height: 60px;
    }
}

.selectable-item {
    color: #69e8e1;
}

.details {
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

.apartment-card {
    background-color: var(--price-color);
    color: var(--background-color);
}

.top2 {
    margin-top: 70px;
}

.apartment-img {
    border-radius: 20px;
    margin-top: 5px;
}
</style>
