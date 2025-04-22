<!--فایل  OptionCard.js در services      فایل   OptionCard.json در پوشه docs -->


<template>
    <v-container class="text-center">
        <v-btn icon @click="$router.go(-1)" class="back-btn">
            <v-icon>mdi-arrow-right</v-icon>
        </v-btn>
        <h2 class="text-h5 font-weight-bold ">New ad</h2>
        <p class="text-body-2 Txt">Select the desired option.</p>

        <v-row class="mt-6" justify="center">
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card Txt2" @click="openModal('accommodation')">
                    <v-img src="/Untitled design (1) 10.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 Txt3 Txt2 " block>Accommodation</v-btn>
                </v-card>
            </v-col>
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card Txt2" @click="openModal('vehicle')">
                    <v-img src="/Untitled design (1) 11.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 Txt2 " block>Vehicle</v-btn>
                </v-card>
            </v-col>
            <v-col cols="4" sm="6" md="3">
                <v-card class="option-card Txt2" @click="openModal('companion')">
                    <v-img src="/Untitled design (1) 12.png" contain height="100"></v-img>
                    <v-btn class="mt-2 option-card2 Txt2 " block>Companion</v-btn>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script setup>
// TODO  : composition --> option  &  const & warning & errore

import {ref} from "vue";

defineProps({
    title: String,
    image: String,
    cols: { type: [Number, String], default: 4 },
    sm: { type: [Number, String], default: 6 },
    md: { type: [Number, String], default: 3 }
});
const modalType = ref("");
const selectedProperty = ref(null);
const errorMessage = ref("");
const showModal = ref(false);

const openModal = (type) => {
    modalType.value = type;
    showModal.value = true;
    selectedProperty.value = null;
    errorMessage.value = "";
};

const emit = defineEmits(['click']);

const handleClick = () => {
    emit('click', title);
};
</script>
