<template class="main">
    <UserSidebar>
        <v-container fluid class="d-flex ">
            <v-container class="content text-center">
            <v-btn icon @click="$router.go(-1)" class="back-btn">
                <v-icon>mdi-arrow-right</v-icon>
            </v-btn>
            <h2 class="text-h5 font-weight-bold ">{{ translate('Ad.NewAd') }}</h2>
            <br>
            <p class="text-body-2 Txt">{{ translate('Ad.SelectOption') }}</p>

            <v-row class="mt-6" justify="center">
                <v-col cols="4" sm="6" md="3">
                    <v-card class="option-card Txt2" @click="StepOne = true">
                        <v-img src="/Untitled design (1) 10.png" contain height="100"></v-img>
                        <v-btn class="mt-2 option-card2 Txt3 Txt2 " block>{{ translate('Ad.Accommodation') }}</v-btn>
                    </v-card>
                </v-col>
                <v-col cols="4" sm="6" md="3">
                    <v-card class="option-card Txt2" @click="comingSoon">
                        <v-img src="/Untitled design (1) 11.png" contain height="100"></v-img>
                        <v-btn class="mt-2 option-card2 Txt2 " block>{{ translate('Ad.Vehicle') }}</v-btn>
                    </v-card>
                </v-col>
                <v-col cols="4" sm="6" md="3">
                    <v-card class="option-card Txt2" @click="comingSoon">
                        <v-img src="/Untitled design (1) 12.png" contain height="100"></v-img>
                        <v-btn class="mt-2 option-card2 Txt2 " block>{{ translate('Ad.Companion') }}</v-btn>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        </v-container>

        <StepOneModal
            :modelValue="StepOne"
            @update:modelValue="StepOne = $event"
        />

        <Footer />

    </UserSidebar>
</template>

<script setup>
import { ref } from "vue";
import Header from '../layout/Header/Header.vue';
import Footer from '../layout/Footer.vue';
import StepOneModal from './CreateAd/StepOneModal.vue';
import { translate } from "../../store/languageStore";
import UserSidebar from '../Users/Layout.vue';

const StepOne = ref(false);

const comingSoon = () => {
    alert("Coming soon!");
};
</script>


<style scoped>

.Container {
    background-color: var(--background-color);
}
.back-btn {
    position: absolute;
    left: 16px;
    top: 16px;
}
.option-card {
    text-align: center;
    padding: 16px;
    border-radius: 12px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    background-color: var(--background-color--groups);
}
.Txt {
    color: var(--text-color);
}
@media (max-width: 600px) {
    .option-card {
        padding: 12px;
    }

    .option-card2 {
        font-size: 14px;
        padding: 6px;
    }


    .back-btn {
        left: 8px;
        top: 8px;
    }

    .Txt {
        font-size: 12px!important;
    }
    .Txt2 {
        font-size: 10px!important;
    }
    .Txt3 {
        font-size: 8px!important;
    }
}


.v-dialog #map {
    height: 100%;
}

.text-center {
    text-align: center;
}

.title{
    background-color: var(--background-color--groups3);
    text-align: center;
    color: var(--text-color);
}
.back{
    background-color: var(--background-color--groups3);

}

</style>
