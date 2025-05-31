<template>
    <v-dialog v-model="showModal" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center">
                {{ translate('AD_SELECTOPTION') }}
            </v-card-title>
            <v-card-text class="text-center">
                <v-row justify="center">
                    <v-col cols="4">
                        <v-card class="option-card" @click="openModal('companion')">
                            <v-img src="/Travel 001.png" contain height="120"></v-img>
                            <v-btn class="mt-2 option-btn">{{ translate('AD_ACCOMMODATION') }}</v-btn>
                        </v-card>
                    </v-col>
                    <v-col cols="4">
                        <v-card class="option-card" @click="showComingSoon = true; showModal = false;">
                            <v-img src="/Travel 002.png" contain height="120"></v-img>
                            <v-btn class="mt-2 option-btn">{{ translate('TOUR') }}</v-btn>
                        </v-card>
                    </v-col>
                    <v-col cols="4">
                        <v-card class="option-card" @click="showComingSoon = true; showModal = false;">
                            <v-img src="/Travel 003.png" contain height="120"></v-img>
                            <v-btn class="mt-2 option-btn">{{ translate('TOURLEADER') }}</v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions>
                <v-btn color="red" block @click="closeModal">{{ translate('CLOSE') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showComingSoon" max-width="400px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center">{{ translate('FEATURENOTAVAILABLE') }}</v-card-title>
            <v-card-actions class="justify-end">
                <v-btn color="primary" @click="showComingSoon = false">
                    {{ translate('CLOSE') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep1" max-width="600px" persistent>
        <v-card>
            <v-card-text class="text-center">
                <v-img src="/Travel 004.png" contain height="150" class="mb-4"></v-img>
                <v-card-title class="text-h5 text-center" style="color: #007bff">
                    {{ translate('FIRSTSTEP') }}
                </v-card-title>
                <p class=" font-weight-bold descriptionModal">
                    {{ translate('STEP1DESCRIPTION') }}
                </p>
                <p class="text-body-1 descriptionModal">
                    {{ translate('STEP1_1DESCRIPTION') }}
                </p>
            </v-card-text>
            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="closeModal">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('AD_SAVEEXIT') }}
                </v-btn>
                <v-btn color="primary" @click="goNext">
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep2" max-width="800px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center" style="color: #007bff">
                {{ translate('ENTERDESTINATION') }}
            </v-card-title>
            <v-card-text>
                <v-text-field
                    v-model="originSearch"
                    :label="translate('SEARCHORIGIN')"
                    outlined
                    clearable
                    @input="searchOriginLocation"
                    class="mb-4"
                ></v-text-field>

                <v-list v-if="originSearchResults.length > 0" class="mb-4">
                    <v-list-item
                        v-for="(result, index) in originSearchResults"
                        :key="'origin-'+index"
                        @click="selectOriginLocation(result)"
                    >
                        <v-list-item-content>
                            <v-list-item-title>{{ result.display_name }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <v-text-field
                    v-model="destinationSearch"
                    :label="translate('SEARCHDESTINATION')"
                    outlined
                    clearable
                    @input="searchLocation"
                ></v-text-field>

                <v-list v-if="searchResults.length > 0">
                    <v-list-item
                        v-for="(result, index) in searchResults"
                        :key="'dest-'+index"
                        @click="selectLocation(result)"
                    >
                        <v-list-item-content>
                            <v-list-item-title>{{ result.display_name }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>

                <div id="destinationMap" style="height: 400px; width: 100%; margin-top: 20px;"></div>
                <div v-if="distance" class="distance-display mt-2 text-center">
                    <v-chip color="primary">
                        <v-icon left>mdi-map-marker-distance</v-icon>
                        {{ translate('DISTANCE') }}: {{ distance }}
                    </v-chip>
                </div>

                <v-alert v-if="userLocation && !selectedOrigin" type="info" class="mb-2">
                    <v-icon left>mdi-map-marker</v-icon>
                    {{ translate('ORIGIN') }}: {{ translate('YOURCURRENTLOCATION') }}
                    <span v-if="userLocationAddress">({{ userLocationAddress }})</span>
                </v-alert>

                <v-alert v-if="selectedOrigin" type="info" class="mb-2">
                    <v-icon left>mdi-map-marker</v-icon>
                    {{ translate('ORIGIN') }}: {{ selectedOrigin.display_name }}
                </v-alert>

                <v-alert v-if="selectedDestination" type="info">
                    <v-icon left>mdi-flag</v-icon>
                    {{ translate('DESTINATION') }}: {{ selectedDestination.display_name }}
                </v-alert>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="confirmDestination"
                    :disabled="!selectedDestination"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep3" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center" style="color: #007bff">
                {{ translate('SELECTTRAVELSTYLE') }}
            </v-card-title>
            <v-card-subtitle class="text-center">
                {{ translate('TRAVELSTYLESUBTITLE') }}
            </v-card-subtitle>

            <v-card-text>
                <v-row v-for="(style, index) in travelStyles" :key="index" class="mb-3" align="center">
                    <v-col cols="6" class="d-flex justify-end">
                        <v-img :src="style.img" contain height="80"></v-img>
                    </v-col>
                    <v-col cols="6" class="d-flex justify-start">
                        <v-btn
                            block
                            @click="selectStyle(style.value)"
                            :color="selectedStyle === style.value ? 'primary' : ''"
                            class="style-btn"
                        >
                            {{ style.label }}
                        </v-btn>
                    </v-col>
                </v-row>
                <v-alert
                    v-if="styleError"
                    type="error"
                    dense
                    class="mt-2"
                >
                    {{ translate('PLEASESELECTSTYLE') }}
                </v-alert>

            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="confirmTravelStyle"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>

            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep4" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center" style="color: #007bff">
                <v-img src="/Travel 010.png" contain height="150" class="mb-4"></v-img>
                {{ translate('SETBUDGETRANGE') }}
            </v-card-title>
            <v-card-subtitle class="text-center">
                {{ translate('BUDGETDESCRIPTION') }}
            </v-card-subtitle>

            <v-card-text>
                <v-text-field
                    v-model="budgetAmount"
                    :label="translate('BUDGETPERPERSON')"
                    outlined
                    type="number"
                    suffix="€"
                    class="mt-4"
                ></v-text-field>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="goNext"
                    :disabled="!budgetAmount"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep5" max-width="800px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center primary--text">
                {{ translate('PERSONALITYHEADER') }}

            </v-card-title>
            <v-card-subtitle class="text-center">
                {{ translate('PERSONALITYSUBHEADER') }}
            </v-card-subtitle>
            <v-divider class="my-3"></v-divider>
            <v-card-text>
                <v-row>
                    <v-col
                        v-for="(trait, index) in personalityTraits"
                        :key="index"
                        cols="6"
                        sm="4"
                        md="3"
                        lg="2"
                        class="d-flex flex-column align-center"
                    >
                        <div
                            class="trait-item d-flex flex-column align-center"
                            :class="{ 'selected-trait': selectedTraits.includes(trait.key) }"
                            @click="toggleTrait(trait.key)"
                        >
                            <v-img
                                :src="trait.img"
                                contain
                                height="60"
                                width="60"
                                class="mb-2 trait-image"
                            ></v-img>
                            <div class="text-caption text-center trait-label">{{ translate(trait.label) }}</div>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="confirmPersonalityTraits"
                    :disabled="selectedTraits.length === 0"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep6" max-width="600px" >
        <v-card>

            <v-card-title class="text-h5 text-center">
                {{ translate('SHARETRAVELEXPERIENCES') }}
            </v-card-title>
            <v-card-text class="text-center">
                <v-img src="/Travel 041.png" contain height="150" class="mb-4"></v-img>

                <p class="font-weight-bold">
                    {{ translate('SHAREEXPERIENCEDESCRIPTION') }}
                </p>

                <p class="text-body-2 mt-2">
                    {{ translate('PHOTOUPLOADDESCRIPTION') }}
                </p>

                <p class="text-body-1 mt-4">
                    {{ translate('OPTIONALPHOTONOTE') }}
                </p>

                <v-card
                    outlined
                    class="mt-4 d-flex align-center justify-space-between pa-4"
                    @click="triggerFileInput"
                >
                    <span>{{ translate('ADDPHOTO') }}</span>
                    <v-icon>mdi-camera</v-icon>
                    <input
                        type="file"
                        ref="fileInput"
                        style="display: none"
                        accept="image/*"
                        multiple
                        @change="handleFileUpload"
                    >
                </v-card>

                <v-textarea
                    v-if="uploadedPhotos.length > 0"
                    v-model="photoDescription"
                    :label="translate('PHOTODESCRIPTIONPLACEHOLDER')"
                    outlined
                    class="mt-4"
                    :counter="60"
                    maxlength="60"
                    :placeholder="translate('PHOTODESCRIPTIONHINT')"
                    rows="2"
                ></v-textarea>

                <v-row v-if="uploadedPhotos.length > 0" class="mt-2">
                    <v-col
                        v-for="(photo, index) in uploadedPhotos"
                        :key="index"
                        cols="4"
                    >
                        <v-card>
                            <v-img :src="photo.preview" height="100"></v-img>
                            <v-btn
                                icon
                                small
                                color="red"
                                class="delete-photo-btn"
                                @click="removePhoto(index)"
                            >
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-card>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="confirmTravelPlan"
                    :disabled="selectedTraits.length === 0"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep7" max-width="600px" >
        <v-card>
            <v-img src="/Travel 042.png" contain height="150" class="mb-4" style="position: absolute; top: 0; left: 0; right: 0; z-index: -1;"></v-img>

            <v-card-title class="text-h5 text-center" style="margin-top: 130px">

                {{ translate('SELECTTRAVELCOMPANION') }}
            </v-card-title>

            <v-card-subtitle class="text-h6 text-center" style="color: #007bff">
                {{ translate('SECONDSTEP') }}
            </v-card-subtitle>
            <v-card-subtitle class="text-h7 text-center">
                {{ translate('STEP2DESCRIPTION') }}
            </v-card-subtitle>

            <v-card-text>
                <p class="font-weight-bold">
                    {{ translate('WRITEORUPLOADTRAVELPLAN') }}
                </p>

                <v-card
                    outlined
                    class="mb-4 d-flex align-center justify-space-between pa-4 rounded-lg"
                    @click="triggerPlanFileInput"
                >
                    <span>{{ translate('UPLOADFILE') }}</span>
                    <v-icon>mdi-paperclip</v-icon>
                    <input
                        type="file"
                        ref="planFileInput"
                        style="display: none"
                        accept=".pdf,.jpg,.png"
                        @change="handlePlanFileUpload"
                    >
                </v-card>

                <div v-if="uploadedPlanFile" class="file-preview mb-4">
                    <v-card outlined class="pa-2">
                        <div class="d-flex align-center">
                            <v-icon large class="mr-2">
                                {{ getFileIcon(uploadedPlanFile.type) }}
                            </v-icon>
                            <div>
                                <div class="text-body-1">{{ uploadedPlanFile.name }}</div>
                                <div class="text-caption grey--text">
                                    {{ formatFileSize(uploadedPlanFile.size) }}
                                </div>
                            </div>
                            <v-spacer></v-spacer>
                            <v-btn icon small @click="removeUploadedFile">
                                <v-icon color="red">mdi-close</v-icon>
                            </v-btn>
                        </div>
                        <v-img
                            v-if="isImageFile(uploadedPlanFile.type)"
                            :src="uploadedPlanFilePreview"
                            contain
                            max-height="150"
                            class="mt-2"
                        ></v-img>
                    </v-card>
                </div>

                <p class="text-caption text-center grey--text">
                    PDF, JPG, PNG
                </p>

                <p class="text-center my-2">
                    {{ translate('OR') }}
                </p>

                <v-card
                    outlined
                    class="mb-2 rounded-lg"
                >
                    <v-card-title class="text-subtitle-1">
                        {{ translate('WRITEYOURTRAVELPLAN') }}
                    </v-card-title>
                    <v-card-text>
                        <v-textarea
                            v-model="travelPlanText"
                            outlined
                            :placeholder="translate('TRAVELPLANPLACEHOLDER')"
                            :counter="2500"
                            maxlength="2500"
                            :rules="[v => v.length <= 2500 || translate('MAXCHARACTERSREACHED')]"
                            auto-grow
                            rows="6"
                        ></v-textarea>
                    </v-card-text>
                </v-card>

                <p class="text-caption mt-2">
                    {{ translate('NOTIFYCHANGESWARNING') }}
                </p>
            </v-card-text>
            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn
                    color="primary"
                    @click="confirmCompanionCount"
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>


        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep9" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center Text2">
                {{ translate('TRAVELCOMPANIONSCOUNT') }}
            </v-card-title>

            <v-card-text class="text-center">
                <p class="font-weight-bold mb-4 ">
                    {{ translate('CURRENTCOMPANIONSINFO') }}
                </p>

                <p class="mb-6 Text3">
                    {{ translate('COMPANIONSNEEDEDINFO') }}
                </p>

                <p class="font-weight-bold mb-4 Text1">
                    {{ translate('CURRENTTRAVELERSINFO') }}
                </p>

                <p class="mb-6 Text1">
                    {{ translate('EXISTINGCOMPANIONSINFO') }}
                </p>

                <v-row align="center" justify="center" class="mb-6">
                    <v-col cols="12" md="4" class="d-flex justify-center">
                        <v-img src="/Travel 043.png" contain height="120"></v-img>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                        <v-btn icon @click="decrementCompanionCount('current')" :disabled="currentCompanionCount <= 0">
                            <v-icon>mdi-minus-circle</v-icon>
                        </v-btn>

                        <span class="mx-4 text-h6">{{ currentCompanionCount }}</span>

                        <v-btn icon @click="incrementCompanionCount('current')">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row align="center" justify="center" class="mb-6">
                    <v-col cols="12" md="4" class="d-flex justify-center">
                        <v-img src="/Travel 044.png" contain height="120"></v-img>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex justify-center align-center">

                        <v-btn icon @click="decrementCompanionCount('needed')" :disabled="neededCompanionCount <= 0">
                            <v-icon>mdi-minus-circle</v-icon>
                        </v-btn>

                        <span class="mx-4 text-h6">{{ neededCompanionCount }}</span>

                        <v-btn icon @click="incrementCompanionCount('needed')">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn color="primary" @click="confirmCompanionCount">
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep10" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center">
                {{ translate('SELECTCOMPANIONSTITLE') }}
            </v-card-title>

            <v-card-title class="text-center Text2">
                {{ translate('COMPANIONSSELECTIONSUBTITLE') }}
            </v-card-title>

            <v-card-text class="text-center">
                <v-row align="center" justify="center" class="mb-6">
                    <v-col cols="12" md="4" class="d-flex justify-center">
                        <v-img src="/Travel 043.png" contain height="80"></v-img>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                        <v-btn icon @click="decrementCompanionCount('male')" :disabled="maleCompanionCount <= 0">
                            <v-icon>mdi-minus-circle</v-icon>
                        </v-btn>

                        <span class="mx-4 text-h6">{{ maleCompanionCount }}</span>

                        <v-btn icon @click="incrementCompanionCount('male')">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row align="center" justify="center" class="mb-6">
                    <v-col cols="12" md="4" class="d-flex justify-center">
                        <v-img src="/Travel 044.png" contain height="80"></v-img>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                        <v-btn icon @click="decrementCompanionCount('female')" :disabled="femaleCompanionCount <= 0">
                            <v-icon>mdi-minus-circle</v-icon>
                        </v-btn>

                        <span class="mx-4 text-h6">{{ femaleCompanionCount }}</span>

                        <v-btn icon @click="incrementCompanionCount('female')">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-row align="center" justify="center" class="mb-6">
                    <v-col cols="12" md="4" class="d-flex justify-center">
                        <v-img src="/Travel 047.png" contain height="120"></v-img>
                    </v-col>
                    <v-col cols="12" md="4" class="d-flex justify-center align-center">
                        <v-btn icon @click="decrementCompanionCount('any')" :disabled="anyGenderCompanionCount <= 0">
                            <v-icon>mdi-minus-circle</v-icon>
                        </v-btn>

                        <span class="mx-4 text-h6">{{ anyGenderCompanionCount }}</span>

                        <v-btn icon @click="incrementCompanionCount('any')">
                            <v-icon>mdi-plus-circle</v-icon>
                        </v-btn>
                    </v-col>
                </v-row>

                <v-card outlined class="pa-4 mt-4">
                    <p class="font-weight-bold mb-2">{{ translate('TOTALCOMPANIONS') }}</p>
                    <p class="text-h4">{{ totalCompanions }}</p>
                </v-card>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn color="primary" @click="goNext">
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>

        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep11" max-width="600px" persistent>
        <v-card>
            <v-card-title class="text-h5 text-center">
                {{ translate('MOREDESCRIPTIONTITLE') }}
            </v-card-title>

            <v-card-text>
                <p class="text-body-1 mb-4">
                    {{ translate('MOREDESCRIPTIONINSTRUCTION') }}
                </p>

                <v-card outlined class="pa-4 rounded-lg mb-4">
                    <v-textarea
                        v-model="additionalDescription"
                        outlined
                        :placeholder="translate('ADDITIONALDESCRIPTIONPLACEHOLDER')"
                        :counter="441"
                        maxlength="441"
                        :rules="[v => v.length <= 441 || translate('MAXCHARACTERSREACHED')]"
                        auto-grow
                        rows="4"
                    ></v-textarea>
                    <p class="text-caption grey--text text-right">
                        {{ translate('MAX441CHARACTERS') }}
                    </p>
                </v-card>

                <p class="text-caption mt-2">
                    {{ translate('DESCRIPTIONCHANGENOTIFICATION') }}
                </p>
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn color="primary" @click="goNext">
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep12" max-width="600px" persistent>
        <v-card>
            <v-img src="/Travel 042.png" contain height="150" class="mb-4" style="position: absolute; top: 0; left: 0; right: 0; z-index: -1;"></v-img>

            <v-card-title class="text-h5 text-center" style="margin-top: 150px">
                {{ translate('FINALREVIEWTITLE') }}
            </v-card-title>

            <v-card-subtitle class="text-center">
                {{ translate('PUBLISHANDFINISH') }}
            </v-card-subtitle>

            <v-card-text class="text-center font-weight-bold Text2">
                {{ translate('STEP3') }}
            </v-card-text>

            <v-card-text class="text-center">
                {{ translate('FINALREVIEWDESCRIPTION') }}
            </v-card-text>

            <v-card-actions class="d-flex justify-end gap-2">
                <v-btn color="grey" text @click="goBack">
                    <v-icon left>mdi-arrow-left</v-icon>
                    {{ translate('BACK') }}
                </v-btn>
                <v-btn color="grey" text @click="saveAndExit">
                    <v-icon left>mdi-content-save-outline</v-icon>
                    {{ translate('SAVEEXIT') }}
                </v-btn>
                <v-btn color="primary" @click="publishListing">
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep13" max-width="650px" persistent scrollable>
        <v-card class="rounded-lg" elevation="12">
            <div>
                <v-img
                    src="/Travel 046.png"
                    contain
                    height="180"
                    class="modal-image"
                ></v-img>
                <div class="header-overlay"></div>
            </div>

            <v-card-title class="text-h5 text-center primary--text pt-6">
                {{ translate('TRAVELDATETITLE') }}
            </v-card-title>

            <v-card-subtitle class="text-center text--secondary text-caption">
                {{ translate('TRAVELDATESUBTITLE') }}
            </v-card-subtitle>

            <v-card-text class="text-center text--secondary text-caption pb-0">
                {{ translate('TRAVELDATEINSTRUCTION') }}
            </v-card-text>

            <v-card-text class="d-flex justify-center flex-wrap">
                <div class="mr-4">
                    <v-date-picker
                        v-model="selectedDates"
                        multiple
                        full-width
                        :min="minDate"
                        :max="maxDate"
                        color="primary"
                        locale="en-us"
                        :first-day-of-week="1"
                        :show-current="false"
                        :landscape="smAndUp"
                        header-color="primary"
                        class="elevation-3 rounded-lg"
                    ></v-date-picker>
                </div>

                <div v-if="selectedDates.length > 0" class="selected-dates-container">
                    <v-alert
                        colored-border
                        elevation="2"
                    >
                        <div class="d-flex flex-column">
                            <div class="text-h6 primary--text mb-2">
                                {{ translate('SELECTEDTRAVELDATES') }}
                            </div>
                            <div class="text-subtitle-1 mb-2">
                                {{ formatSelectedDates() }}
                            </div>
                            <div class="text-caption mb-2">
                                {{ translate('SELECTEDDAYSCOUNT') }}: {{ selectedDates.length }}
                            </div>
                            <v-btn
                                text
                                @click="clearSelectedDates"
                                color="error"
                                small
                                block
                            >
                                <v-icon left small>mdi-close</v-icon>
                                {{ translate('CLEARSELECTION') }}
                            </v-btn>
                        </div>
                    </v-alert>
                </div>
            </v-card-text>
            <v-card-actions class="d-flex justify-space-between px-6 pb-6 pt-3">
                <div>
                    <v-btn text @click="goBack" class="mr-2">
                        <v-icon left>mdi-arrow-left</v-icon>
                        {{ translate('BACK') }}
                    </v-btn>
                    <v-btn text @click="saveAndExit" color="grey darken-1">
                        <v-icon left>mdi-content-save-outline</v-icon>
                        {{ translate('SAVEEXIT') }}
                    </v-btn>
                </div>
                <v-btn
                    color="primary"
                    @click="confirmSafetyGuidelines"
                    :disabled="selectedDates.length === 0"
                    depressed
                    large
                >
                    {{ translate('AD_CONFIRMNEXT') }}
                    <v-icon right>mdi-arrow-right</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep14" max-width="650px" persistent scrollable>
        <v-card class="rounded-lg" elevation="12">
            <v-card-title class="text-h4 text-center primary--text pt-6 Text2">
                {{ translate('SAFETYGUIDELINESTITLE') }}
            </v-card-title>

            <v-card-text class="px-6">
                <div class="mb-4 text-center">
                    <div class="text-h5 font-weight-bold mb-4">
                        {{ translate('SECURECOMMUNICATION') }}
                    </div>
                    <div class="text-h7">
                        {{ translate('SECURECOMMUNICATIONDESCRIPTION') }}
                    </div>
                </div>

                <v-divider class="my-4"></v-divider>

                <div class="mb-4 text-center">
                    <div class="text-h6 Text3">
                        {{ translate('USEAPPONLYMESSAGE') }}
                    </div>
                </div>

                <v-divider class="my-4"></v-divider>

                <div class="mb-4 text-center">
                    <div class="text-h5 font-weight-bold mb-2">
                        {{ translate('PAYMENTS') }}
                    </div>
                    <div class="text-h7">
                        {{ translate('PAYMENTSDESCRIPTION') }}
                    </div>
                </div>

                <v-divider class="my-4"></v-divider>

                <div class="mb-4 text-center">
                    <div class=" text-h5 font-weight-bold mb-2">
                        {{ translate('IMPORTANTTOKNOW') }}
                    </div>
                    <div class="text-body-2">
                        <div class="text-h6">{{ translate('SECURITYCAMERASRULE') }}</div>
                        <div class="text-h6">{{ translate('FOLLOWLOCALRULES') }}</div>
                    </div>
                </div>
                <v-divider class="my-4"></v-divider>

                <div class="mb-4">
                    <div class="text-subtitle-1 font-weight-bold mb-2 text-center">
                        <a @click="showEssentialTips" class="text-h5 Text2" style="text-decoration: none; cursor: pointer;">
                            {{ translate('ESSENTIALTRAVELTIPS') }}
                            <v-icon small color="primary">mdi-open-in-new</v-icon>
                        </a>
                    </div>
                </div>
            </v-card-text>

            <v-card-actions class="d-flex justify-space-between px-6 pb-6 pt-3">
                <div>
                    <v-btn text @click="goBack" class="mr-2">
                        <v-icon left>mdi-arrow-left</v-icon>
                        {{ translate('BACK') }}
                    </v-btn>
                    <v-btn text @click="saveAndExit" color="grey darken-1">
                        <v-icon left>mdi-content-save-outline</v-icon>
                        {{ translate('SAVEEXIT') }}
                    </v-btn>
                </div>
                <v-btn
                    color="primary"
                    @click="confirmSafetyGuidelines"
                    depressed
                    large
                >
                    {{ translate('CONFIRMANDFINISH') }}
                    <v-icon right>mdi-check</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showEssentialTipsModal" max-width="600px">
        <v-card>
            <v-card-title class="text-h5 primary--text">
                {{ translate('ESSENTIALTRAVELTIPS') }}
            </v-card-title>
            <v-card-text>
                <div v-for="(tip, index) in essentialTips" :key="index" class="mb-2">
                    • {{ translate(tip) }}
                </div>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="showEssentialTipsModal = false">
                    {{ translate('CLOSE') }}
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="showStep15" max-width="800px" persistent scrollable>
        <v-card class="rounded-lg" elevation="12">
            <v-card-title class="text-h4 text-center primary--text pt-6 "style="color: #db4437">
                {{ translate('PREVIEWYOUREAD') }}
            </v-card-title>
            <div class="text-h5 mb-4 text-center">
                <v-icon left color="primary">mdi-account-group</v-icon>
                {{ translate('LOOKINGFORTRAVELCOMPANION') }}
            </div>

            <v-card outlined class="mx-4 mt-4 mb-2" style="border-radius: 8px;">
                <v-row no-gutters>
                    <v-col cols="12" md="6" class="pa-0">
                        <v-carousel
                            cycle
                            height="300"
                            hide-delimiter-background
                            show-arrows-on-hover
                        >
                            <v-carousel-item
                                v-for="(photo, index) in uploadedPhotos"
                                :key="index"
                            >
                                <v-sheet height="100%" color="grey lighten-3">
                                    <v-img
                                        :src="photo.preview"
                                        contain
                                        height="100%"
                                        class="mx-auto"
                                    >
                                        <template v-slot:placeholder>
                                            <v-row class="fill-height ma-0" align="center" justify="center">
                                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                            </v-row>
                                        </template>
                                    </v-img>
                                </v-sheet>
                            </v-carousel-item>
                        </v-carousel>
                    </v-col>

                    <v-col cols="12" md="6" class="pa-4">

                        <div class="mb-3">
                            <div class="text-subtitle-1 font-weight-bold Text3">
                                <v-icon small>mdi-map-marker</v-icon>
                                {{ translate('FROM') }}:
                            </div>
                            <div class="pl-4">{{ userLocationAddress || translate('YOURCURRENTLOCATION') }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-subtitle-1 font-weight-bold Text3">
                                <v-icon small>mdi-flag</v-icon>
                                {{ translate('TO') }}:
                            </div>
                            <div class="pl-4">{{ selectedDestination?.display_name }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-subtitle-1 font-weight-bold Text3">
                                <v-icon small>mdi-map-marker-distance</v-icon>
                                {{ translate('DISTANCE') }}:
                            </div>
                            <div class="pl-4">{{ distance }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-subtitle-1 font-weight-bold Text3">
                                <v-icon small>mdi-account</v-icon>
                                {{ translate('POSTEDBY') }}:
                            </div>
                            <div class="pl-4">{{ userName }}</div>
                        </div>

                        <v-divider class="my-3"></v-divider>

                    </v-col>
                </v-row>
            </v-card>

            <v-card outlined class="mx-4 my-2" style="border-radius: 8px;">
                <v-card-text>
                    <v-row>
                        <v-col cols="12" md="6">
                            <div class="text-subtitle-1 font-weight-bold mb-2 Text3">
                                <v-icon left>mdi-calendar</v-icon>
                                {{ translate('TRAVELDATES') }}
                            </div>
                            <div class="pl-8">{{ formatSelectedDatesRange() }}</div>
                        </v-col>


                        <div class="mb-3">
                            <div class="text-subtitle-1 font-weight-bold Text3">
                                <v-icon small>mdi-cash</v-icon>
                                {{ translate('ESTIMATEDCOST') }}:
                            </div>
                            <div class="pl-4 text-h5 primary--text">{{ budgetAmount }} €</div>
                        </div>

                    </v-row>
                </v-card-text>
            </v-card>

            <v-card-actions class="d-flex justify-space-between px-6 pb-4 pt-2">
                <div>
                    <v-btn text @click="goToStep14" class="mr-2">
                        <v-icon left>mdi-arrow-left</v-icon>
                        {{ translate('BACK') }}
                    </v-btn>
                    <v-btn color="grey" text @click="saveAndExit">
                        <v-icon left>mdi-content-save-outline</v-icon>
                        {{ translate('SAVEEXIT') }}
                    </v-btn>
                </div>
                <v-btn
                    color="primary"
                    @click="publishAd"
                    depressed
                    large
                >
                    {{ translate('PUBLISHAD') }}
                    <v-icon right>mdi-send</v-icon>
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import { translate } from "@/store/languageStore";
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import imageUploadService from '../../../services/ imageUploadService.js';
export default {
    name: 'TravelCompanionModal',
    props: {
        modelValue: Boolean
    },
    emits: ['update:modelValue'],
    data() {
        return {
            showComingSoon: false,
            currentStep: 0,
            showStep1: false,
            showStep2: false,
            showStep3: false,
            showStep4: false,
            showStep5: false,
            showStep6: false,
            showStep7: false,
            showStep9: false,
            showStep10: false,
            showStep11: false,
            showStep12: false,
            showStep13: false,
            showStep14: false,
            showStep15: false,
            styleError: false,
            originSearch: "",
            originSearchResults: [],
            selectedOrigin: null,
            destinationSearch: "",
            searchResults: [],
            selectedDestination: null,
            userLocation: null,
            userLocationAddress: null,
            distance: null,
            selectedStyle: null,
            budgetAmount: null,
            selectedTraits: [],
            uploadedPhotos: [],
            photoDescription: "",
            travelPlanText: "",
            uploadedPlanFile: null,
            uploadedPlanFilePreview: null,
            currentCompanionCount: 0,
            neededCompanionCount: 0,
            maleCompanionCount: 0,
            femaleCompanionCount: 0,
            anyGenderCompanionCount: 0,
            additionalDescription: "",
            selectedDates: [],
            showEssentialTipsModal: false,
            map: null,
            marker: null,
            userLocationMarker: null,
            routeLine: null,
            minDate: new Date().toISOString().substr(0, 10),
            maxDate: new Date(Date.now() + 365 * 24 * 60 * 60 * 1000).toISOString().substr(0, 10),
            userName: "UserName",
            essentialTips: [
                'TIP1DESCRIPTION',
                'TIP2DESCRIPTION',
                'TIP1DESCRIPTION'
            ]
        }
    },
    computed: {
        showModal: {
            get() {
                return this.modelValue
            },
            set(value) {
                this.$emit("update:modelValue", value)
            }
        },
        travelStyles() {
            return [
                { label: this.translate("NORMAL"), value: 'normal', img: '/Travel 005.png' },
                { label: this.translate('LUXURY'), value: 'luxury', img: '/Travel 006.png' },
                { label: this.translate('ADVENTURE'), value: 'adventure', img: '/Travel 007.png' },
                { label: this.translate('CAMPING'), value: 'camping', img: '/Travel 008.png' },
                { label: this.translate('BACKPACKING'), value: 'backpacking', img: '/Travel 009.png' },
            ]
        },
        personalityTraits() {
            return [
                { key: "calm", label: "TRAITS_CALM", img: "/Travel 011.png" },
                { key: "friendly", label: "TRAITS_FRIENDLY", img: "/Travel 012.png" },
                { key: "warrior", label: "TRAITS_WARRIOR", img: "/Travel 013.png" },
                { key: "hardworking", label: "TRAITS_HARDWORKING", img: "/Travel 014.png" },
                { key: "gamer", label: "TRAITS_GAMER", img: "/Travel 016.png" },
                { key: "nightOwl", label: "TRAITS_NIGHTOWL", img: "/Travel 018.png" },
                { key: "earlyBird", label: "TRAITS_EARLYBIRD", img: "/Travel 019.png" },
                { key: "sleepy", label: "TRAITS_SLEEPY", img: "/Travel 017.png" },
                { key: "foodie", label: "TRAITS_FOODIE", img: "/Travel 020.png" },
                { key: "snacker", label: "TRAITS_SNACKER", img: "/Travel 021.png" },
                { key: "vegetarian", label: "TRAITS_VEGETARIAN", img: "/Travel 022.png" },
                { key: "athlete", label: "TRAITS_ATHLETE", img: "/Travel 023.png" },
                { key: "bookworm", label: "TRAITS_BOOKWORM", img: "/Travel 025.png" },
                { key: "curious", label: "TRAITS_CURIOUS", img: "/Travel 026.png" },
                { key: "planner", label: "TRAITS_PLANNER", img: "/Travel 027.png" },
                { key: "punctual", label: "TRAITS_PUNCTUAL", img: "/Travel 028.png" },
                { key: "supportive", label: "TRAITS_SUPPORTIVE", img: "/Travel 029.png" },
                { key: "musicLover", label: "TRAITS_MUSICLOVER", img: "/Travel 030.png" },
                { key: "honest", label: "TRAITS_HONEST", img: "/Travel 031.png" },
                { key: "leader", label: "TRAITS_LEADER", img: "/Travel 032.png" },
                { key: "happy", label: "TRAITS_HAPPY", img: "/Travel 033.png" },
                { key: "tired", label: "TRAITS_TIRED", img: "/Travel 034.png" },
                { key: "extrovert", label: "TRAITS_EXTROVERT", img: "/Travel 035.png" },
                { key: "introvert", label: "TRAITS_INTROVERT", img: "/Travel 036.png" },
                { key: "coordinator", label: "TRAITS_COORDINATOR", img: "/Travel 037.png" },
                { key: "coldSensitive", label: "TRAITS_COLDSENSITIVE", img: "/Travel 038.png" },
                { key: "heatSensitive", label: "TRAITS_HEATSENSITIVE", img: "/Travel 039.png" },
                { key: "analytical", label: "TRAITS_ANALYTICAL", img: "/Travel 040.png" },
                { key: "warm", label: "TRAITS_WARM", img: "/Travel 024.png" },
            ]
        },
        totalCompanions() {
            return this.maleCompanionCount + this.femaleCompanionCount + this.anyGenderCompanionCount
        },
        isDateSelectionValid() {
            return this.selectedDates.length > 0
        }
    },
    methods: {
        translate,

        setActiveModal(step) {
            this.currentStep = step
            this.resetAllModals()

            switch(step) {
                case 1: this.showModal = true; break
                case 2: this.showStep1 = true; break
                case 3: this.showStep2 = true; break
                case 4: this.showStep3 = true; break
                case 5: this.showStep4 = true; break
                case 6: this.showStep5 = true; break
                case 7: this.showStep6 = true; break
                case 8: this.showStep7 = true; break
                case 9: this.showStep9 = true; break
                case 10: this.showStep10 = true; break
                case 11: this.showStep11 = true; break
                case 12: this.showStep12 = true; break
                case 13: this.showStep13 = true; break
                case 14: this.showStep14 = true; break
                case 15: this.showStep15 = true; break
            }
        },

        resetAllModals() {
            this.showModal = false
            this.showStep1 = false
            this.showStep2 = false
            this.showStep3 = false
            this.showStep4 = false
            this.showStep5 = false
            this.showStep6 = false
            this.showStep7 = false
            this.showStep9 = false
            this.showStep10 = false
            this.showStep11 = false
            this.showStep12 = false
            this.showStep13 = false
            this.showStep14 = false
            this.showStep15 = false
        },

        closeModal() {
            this.setActiveModal(0)
        },

        openModal(type) {
            if (type === "companion") {
                this.setActiveModal(2)
            }
        },

        goNext() {
            this.setActiveModal(this.currentStep + 1)
            if (this.currentStep === 3) {
                this.$nextTick(() => {
                    this.initMap()
                })
            }
        },
        confirmDestination () {
            this.setActiveModal(this.currentStep + 1)
        },

        goBack() {
            if (this.currentStep === 2) {
                this.$nextTick(() => {
                    this.initMap()
                })
            }

            if (this.currentStep === 14) {
                this.setActiveModal(13)
            } else {
                this.setActiveModal(this.currentStep - 1)
            }
        },

        closeCompanionModal() {
            this.setActiveModal(0)
        },

        saveAndExit() {
            this.saveState()
            this.resetAllModals()
        },

        async searchLocation() {
            if (this.destinationSearch.length < 3) {
                this.searchResults = []
                return
            }

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${this.destinationSearch}&limit=5`
                )
                const data = await response.json()
                this.searchResults = data
            } catch (error) {
                this.showError("Error searching location", error)
                this.searchResults = []
            }
        },

        selectLocation(location) {
            this.selectedDestination = {
                display_name: location.display_name,
                lat: location.lat,
                lon: location.lon
            }
            this.destinationSearch = location.display_name
            this.searchResults = []

            if (this.map) {
                const latLng = L.latLng(parseFloat(location.lat), parseFloat(location.lon))
                this.map.setView(latLng, 13)

                if (this.marker) {
                    this.map.removeLayer(this.marker)
                }

                this.marker = L.marker(latLng).addTo(this.map)

                if (this.userLocation) {
                    this.drawRoute(this.userLocation, latLng)
                }
            }
        },

        async searchOriginLocation() {
            if (this.originSearch.length < 3) {
                this.originSearchResults = []
                return
            }

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${this.originSearch}&limit=5`
                )
                const data = await response.json()
                this.originSearchResults = data
            } catch (error) {
                this.showError("Error searching origin location", error)
                this.originSearchResults = []
            }
        },

        selectOriginLocation(location) {
            this.selectedOrigin = {
                display_name: location.display_name,
                lat: location.lat,
                lon: location.lon
            }
            this.originSearch = location.display_name
            this.originSearchResults = []

            if (this.map) {
                const latLng = L.latLng(parseFloat(location.lat), parseFloat(location.lon))

                if (this.userLocationMarker) {
                    this.map.removeLayer(this.userLocationMarker)
                }

                this.userLocationMarker = L.marker(latLng, {
                    icon: L.divIcon({
                        className: 'user-location-marker',
                        html: '<div style="background-color: #4285F4; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    })
                }).addTo(this.map)
                    .bindPopup(this.translate('SELECTEDORIGIN')).openPopup()

                this.userLocation = latLng

                if (this.selectedDestination) {
                    this.drawRoute(latLng, L.latLng(this.selectedDestination.lat, this.selectedDestination.lon))
                }
            }
        },

        async initMap() {
            await this.$nextTick()
            const mapElement = document.getElementById('destinationMap')
            if (!mapElement || mapElement._leaflet_id) return

            if (this.map) {
                this.map.remove()
                this.map = null
                this.marker = null
                this.userLocationMarker = null
                this.routeLine = null
            }

            this.map = L.map('destinationMap', {
                zoomControl: true,
                doubleClickZoom: true,
                closePopupOnClick: true,
                dragging: true,
                zoomSnap: 0.5
            })

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(this.map)

            this.map.setView([35.6892, 51.3890], 13)

            if (navigator.geolocation && !this.selectedOrigin) {
                navigator.geolocation.getCurrentPosition(
                    async (position) => {
                        try {
                            const userLatLng = L.latLng(
                                position.coords.latitude,
                                position.coords.longitude
                            )

                            this.userLocation = userLatLng

                            await this.updateUserLocationAddress(position.coords.latitude, position.coords.longitude)

                            this.userLocationMarker = L.marker(userLatLng, {
                                icon: L.divIcon({
                                    className: 'user-location-marker',
                                    html: '<div style="background-color: #4285F4; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.3);"></div>',
                                    iconSize: [20, 20],
                                    iconAnchor: [10, 10]
                                })
                            }).addTo(this.map)
                                .bindPopup(this.translate('Ad.YourCurrentLocation')).openPopup()

                            this.map.setView(userLatLng, 13)
                            await this.updateSelectedLocation(position.coords.latitude, position.coords.longitude)

                            if (this.selectedDestination) {
                                this.drawRoute(userLatLng, L.latLng(this.selectedDestination.lat, this.selectedDestination.lon))
                            }
                        } catch (error) {
                            this.showError("Error initializing user location", error)
                        }
                    },
                    (error) => {
                        this.showError("Error getting user location", error)
                        this.updateSelectedLocation(35.6892, 51.3890)
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 0
                    }
                )
            } else if (this.selectedOrigin) {
                const latLng = L.latLng(parseFloat(this.selectedOrigin.lat), parseFloat(this.selectedOrigin.lon))
                this.userLocation = latLng
                this.map.setView(latLng, 13)

                if (this.selectedDestination) {
                    this.drawRoute(latLng, L.latLng(this.selectedDestination.lat, this.selectedDestination.lon))
                }
            } else {
                this.showError("Geolocation is not supported by this browser")
                this.updateSelectedLocation(35.6892, 51.3890)
            }

            this.map.on('click', async (e) => {
                try {
                    const { lat, lng } = e.latlng

                    if (this.marker) {
                        this.map.removeLayer(this.marker)
                    }

                    this.marker = L.marker([lat, lng]).addTo(this.map)
                    await this.updateSelectedLocation(lat, lng)

                    if (this.userLocation) {
                        this.drawRoute(this.userLocation, e.latlng)
                    }
                } catch (error) {
                    this.showError("Error handling map click", error)
                }
            })
        },

        async updateUserLocationAddress(lat, lng) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`
                )
                const data = await response.json()

                if (data) {
                    this.userLocationAddress = data.display_name
                }
            } catch (error) {
                this.showError("Error getting user location address", error)
                this.userLocationAddress = null
            }
        },

        async drawRoute(start, end) {
            if (this.routeLine) {
                this.map.removeLayer(this.routeLine)
            }

            this.routeLine = L.polyline([start, end], {
                color: '#007bff',
                weight: 3,
                opacity: 0.7,
                dashArray: '5, 5'
            }).addTo(this.map)

            const calculatedDistance = start.distanceTo(end) / 1000
            this.distance = calculatedDistance.toFixed(1) + ' km'

            this.map.fitBounds([start, end], { padding: [50, 50] })

            const midpoint = L.latLng(
                (start.lat + end.lat) / 2,
                (start.lng + end.lng) / 2
            )

            this.routeLine.bindPopup(this.distance, {
                className: 'distance-popup',
                autoClose: false,
                closeOnClick: false
            }).openPopup()
        },

        async updateSelectedLocation(lat, lng) {
            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`
                )
                const data = await response.json()

                if (data) {
                    this.selectedDestination = {
                        display_name: data.display_name,
                        lat: lat.toString(),
                        lon: lng.toString()
                    }
                    this.destinationSearch = data.display_name
                }
            } catch (error) {
                this.showError("Error getting location details", error)
            }
        },

        selectStyle(style) {
            this.selectedStyle = style
        },

        confirmTravelStyle() {
            if (!this.selectedStyle) {
                this.styleError = true
            } else {
                this.styleError = false
                this.setActiveModal(this.currentStep + 1)
            }
        },

        toggleTrait(key) {
            if (this.selectedTraits.includes(key)) {
                this.selectedTraits = this.selectedTraits.filter((k) => k !== key)
            } else {
                this.selectedTraits.push(key)
            }
        },

        confirmPersonalityTraits() {
            console.log("Selected traits:", this.selectedTraits)
            this.setActiveModal(this.currentStep + 1)
        },

        triggerFileInput() {
            this.$refs.fileInput.click();
        },

        async handleFileUpload(event) {
            try {
                const files = event.target.files;
                if (!files.length) return;

                const newPhotos = await imageUploadService.openGallery(10, 5);

                if (newPhotos.length + this.uploadedPhotos.length > 10) {
                    alert(this.translate('MAXPHOTOSWARNING'));
                    return;
                }

                this.uploadedPhotos = [...this.uploadedPhotos, ...newPhotos];
            } catch (error) {
                console.error("Error handling file upload:", error);
                alert(error.message || this.translate('Ad.UploadError'));
            }
        },

        async handlePlanFileUpload(event) {
            try {
                const file = event.target.files[0];
                if (!file) return;

                const validTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    alert(this.translate('INVALIDFILETYPE'));
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    alert(this.translate('FILETOOLARGE'));
                    return;
                }

                this.uploadedPlanFile = file;
                this.travelPlanText = '';

                if (file.type.includes('image')) {
                    // استفاده از سرویس برای خواندن فایل تصویر
                    this.uploadedPlanFilePreview = await imageUploadService.readFileAsDataURL(file);
                }
            } catch (error) {
                console.error("Error handling plan file upload:", error);
                alert(this.translate('Ad.UploadError'));
            }
        },
        removePhoto(index) {
            this.uploadedPhotos.splice(index, 1);
        },

        getPhotoPreviews() {
            return this.uploadedPhotos.map(photo => photo.preview);
        },

        async openCamera() {
            try {
                const photo = await imageUploadService.openCamera(5);
                if (photo && this.uploadedPhotos.length < 10) {
                    this.uploadedPhotos.push(photo);
                }
            } catch (error) {
                console.error("Error opening camera:", error);
                alert(error.message || this.translate('Ad.CameraError'));
            }
        },

        triggerPlanFileInput() {
            this.$refs.planFileInput.click();
        },


        removeUploadedFile() {
            this.uploadedPlanFile = null
            this.uploadedPlanFilePreview = null
        },

        getFileIcon(fileType) {
            if (fileType.includes('image')) return 'mdi-image'
            if (fileType.includes('pdf')) return 'mdi-file-pdf'
            return 'mdi-file'
        },

        isImageFile(fileType) {
            return fileType.includes('image')
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes'
            const k = 1024
            const sizes = ['Bytes', 'KB', 'MB', 'GB']
            const i = Math.floor(Math.log(bytes) / Math.log(k))
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i]
        },

        confirmTravelPlan() {
            console.log('Travel plan:', {
                text: this.travelPlanText,
                file: this.uploadedPlanFile
            })
            this.setActiveModal(this.currentStep + 1)
        },

        incrementCompanionCount(type) {
            switch(type) {
                case 'male': this.maleCompanionCount++; break
                case 'female': this.femaleCompanionCount++; break
                case 'any': this.anyGenderCompanionCount++; break
                case 'current': this.currentCompanionCount++; break
                case 'needed': this.neededCompanionCount++; break
            }
        },

        decrementCompanionCount(type) {
            switch(type) {
                case 'male': if (this.maleCompanionCount > 0) this.maleCompanionCount--; break
                case 'female': if (this.femaleCompanionCount > 0) this.femaleCompanionCount--; break
                case 'any': if (this.anyGenderCompanionCount > 0) this.anyGenderCompanionCount--; break
                case 'current': if (this.currentCompanionCount > 0) this.currentCompanionCount--; break
                case 'needed': if (this.neededCompanionCount > 0) this.neededCompanionCount--; break
            }
        },

        confirmCompanionCount() {
            this.setActiveModal(this.currentStep + 1)
        },

        clearSelectedDates() {
            this.selectedDates = []
        },

        formatSelectedDates() {
            if (this.selectedDates.length === 0) return ''

            const formattedDates = this.selectedDates.map(date => {
                const d = new Date(date)
                return `${d.getMonth()+1}/${d.getDate()}/${d.getFullYear()}`
            }).sort((a, b) => new Date(a) - new Date(b))

            return formattedDates.join(', ')
        },

        formatSelectedDatesRange() {
            if (this.selectedDates.length === 0) return ''

            const sortedDates = [...this.selectedDates].sort()
            const firstDate = new Date(sortedDates[0])
            const lastDate = new Date(sortedDates[sortedDates.length - 1])

            return `${firstDate.getDate()} ${this.translate(`Month.${firstDate.getMonth()}`)} - ${lastDate.getDate()} ${this.translate(`Month.${lastDate.getMonth()}`)}`
        },

        showEssentialTips() {
            this.showEssentialTipsModal = true
        },

        confirmSafetyGuidelines() {
            console.log('Safety guidelines confirmed')
            this.setActiveModal(this.currentStep + 1)
        },

        publishListing() {
            this.setActiveModal(this.currentStep + 1)
        },

        publishAd() {
            console.log('Ad published:', {
                destination: this.selectedDestination,
                dates: this.selectedDates,
                style: this.selectedStyle,
                budget: this.budgetAmount,
                traits: this.selectedTraits,
                photos: this.uploadedPhotos,
                plan: {
                    text: this.travelPlanText,
                    file: this.uploadedPlanFile
                },
                companions: {
                    current: this.currentCompanionCount,
                    needed: this.neededCompanionCount,
                    male: this.maleCompanionCount,
                    female: this.femaleCompanionCount,
                    any: this.anyGenderCompanionCount
                },
                description: this.additionalDescription
            })

            this.clearSavedData()
            this.resetAllModals()
        },

        saveState() {
            localStorage.setItem('travelCompanionState', JSON.stringify({
                currentStep: this.currentStep,
                selectedOrigin: this.selectedOrigin,
                selectedDestination: this.selectedDestination,
                selectedStyle: this.selectedStyle,
                budgetAmount: this.budgetAmount,
                selectedTraits: this.selectedTraits,
                uploadedPhotos: this.uploadedPhotos,
                travelPlanText: this.travelPlanText,
                uploadedPlanFile: this.uploadedPlanFile
            }))
        },

        loadState() {
            try {
                const savedState = localStorage.getItem('travelCompanionState')
                if (savedState) {
                    const state = JSON.parse(savedState)
                    this.currentStep = state.currentStep
                    this.selectedOrigin = state.selectedOrigin || null
                    this.selectedDestination = state.selectedDestination
                    this.selectedStyle = state.selectedStyle
                    this.budgetAmount = state.budgetAmount
                    this.selectedTraits = state.selectedTraits || []
                    this.uploadedPhotos = state.uploadedPhotos || []
                    this.travelPlanText = state.travelPlanText || ''
                    this.uploadedPlanFile = state.uploadedPlanFile || null
                }
            } catch (error) {
                this.showError("Error loading saved state", error)
            }
        },

        clearSavedData() {
            localStorage.removeItem('travelCompanionState')
        },

        showError(message, error = null) {
            console.error(message, error)
        }
    },
    mounted() {
        delete L.Icon.Default.prototype._getIconUrl
        L.Icon.Default.mergeOptions({
            iconRetinaUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png',
            iconUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png',
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png'
        })

        this.loadState()
        if (this.modelValue) {
            this.setActiveModal(this.currentStep || 1)
        }
    },
    beforeUnmount() {
        if (this.map) {
            this.map.remove()
            this.map = null
        }
    }

}
</script>


<style scoped>
#destinationMap {
    height: 400px;
    width: 100%;
    margin-top: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    z-index: 0;
}
.option-card {
    text-align: center;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
}

.option-btn {
    color: white;
}
.descriptionModal {
    font-size: 20px;
    margin-bottom: 10px;
    margin-top: 15px;
}

.v-card-actions {
    padding: 0 16px 16px;
}

#destinationMap {
    border-radius: 8px;
    border: 1px solid #ddd;
}
.v-card-actions {
    justify-content: flex-end !important;
    padding: 16px;
    gap: 8px;
}

.user-location-marker {
    background-color: #4285F4;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}
.trait-item {
    cursor: pointer;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: 100%;
    text-align: center;
}

.trait-item:hover {
    background-color: #f5f5f5;
}

.selected-trait {
    background-color: #e3f2fd;
    border: 1px solid #2196f3;
    color: black;
}

.trait-image {
    margin-bottom: 8px;
}

.trait-label {
    word-break: break-word;
    line-height: 1.2;
}
.v-textarea textarea {
    font-size: 16px !important;
    line-height: 1.5 !important;
}

.Text1{
    font-size: 12px;
}

.Text2{
    color: #007bff;
    font-weight: bold;

}
.Text3{
    color: #ffc900;
}
.photo-gallery {
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 16px;
    margin: 16px 0;
}

.info-section {
    background-color: #f5f5f5;
    border-radius: 8px;
    padding: 16px;
    margin: 16px 0;
}

.modal-image {
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
.distance-popup {
    font-weight: bold;
    text-align: center;
    margin-bottom: 20px;
}

.distance-display {
    font-size: 1.1em;
    font-weight: bold;
}

.user-location-marker {
    background-color: #4285F4;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
}
.location-info .v-alert {
    margin-bottom: 8px;
}

.location-info .v-icon {
    color: #007bff;
}
</style>
