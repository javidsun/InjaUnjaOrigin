<template class="main">
  <Layout>
    <template #sidebar>
      <v-list dense>
        <v-list-item v-for="(item, index) in menuItems" :key="index" :to="item.link">
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>{{ item.title }}</v-list-item-title>
        </v-list-item>
      </v-list>
    </template>

  <v-dialog v-model="showModal" persistent max-width="400">
      <v-card>
        <v-card-text class="text-body-1">
          <span>{{ t("Tutorial.Step" + (currentStep + 1)) }}</span>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" @click="nextStep" v-if="currentStep < steps.length - 1">
            {{ t("Tutorial.NextStep") }}
          </v-btn>
          <v-btn color="primary" @click="finishTutorial" v-if="currentStep === steps.length - 1">
            {{ t("Tutorial.Finish") }}
          </v-btn>
          <v-btn text @click="skipTutorial">{{ t("Tutorial.Skip") }}</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-main :class="{ 'main-expanded': drawer, 'main-collapsed': !drawer }">
      <v-container fluid >
        <v-row>
          <v-col cols="9" id="userInfo">
            <WarningUser />
          </v-col>
          <v-col cols="3" id="userSpecifications">
            <userSpecifications />
          </v-col>
          <v-col cols="12" id="specialOffer">
            <SpecialOffer class="SpecialOffer" />
          </v-col>

          <v-col cols="12" id="userReservations">
            <UserReservations class="UserReservations" />
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <Footer app class="footer">...</Footer>
  </Layout>
</template>
<script setup>
import { ref, nextTick } from 'vue';
import Footer from "../../layout/Footer.vue";
import WarningUser from '../../Users/UserDashboard/WarningUser.vue';
import userSpecifications from '../../Users/UserDashboard/userSpecifications.vue';
import SpecialOffer from '../SpecialOffer.vue';
import { t } from "../../../store/languageStore";
import UserProfile from '../../Users/UserDashboard/UserProfile.vue';
import UserReservations from '../Reserv/UserReservations.vue';
import Layout from '../Layout.vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const tutorialCompleted = ref(false);
const showModal = ref(false);
const currentStep = ref(0);
const steps = [
  { id: "dashboardIcon", message: "در ده ثانیه سایت رو آموزش ببینید." },
  { id: "userInfo", message: "این بخش اطلاعات مهم اکانت شما را نمایش می‌دهد." },
  { id: "specialOffer", message: "پیشنهادات ویژه را از اینجا پیگیری کنید." },
  { id: "userReservations", message: "رزروهای اخیر شما در این بخش قرار دارند." },
];

const startTutorial = () => {
  showModal.value = true;
  highlightStep(steps[currentStep.value]?.id);
  localStorage.setItem("tutorialShown", "true");
};

const skipTutorial = () => {
  showModal.value = false;
  localStorage.setItem("tutorialShown", "true");
  removeHighlights();
};

const nextStep = () => {
  if (currentStep.value < steps.length - 1) {
    currentStep.value++;
    highlightStep(steps[currentStep.value]?.id);
  } else {
    finishTutorial();
  }
};

const finishTutorial = () => {
  tutorialCompleted.value = true;
  showModal.value = false;
  drawer.value = true;
  removeHighlights();
};

const removeHighlights = () => {
  steps.forEach(step => {
    const element = document.getElementById(step.id);
    if (element) {
      element.style.outline = '';
    }
  });
};

const highlightStep = (elementId) => {
  nextTick(() => {
    const element = document.getElementById(elementId);
    if (element) {
      element.style.outline = "3px solid #42A5F5";
      element.style.transition = "outline 0.3s ease-in-out";
      element.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
      console.error(`Element with id ${elementId} not found.`);
    }
  });
};

const isTutorialShown = localStorage.getItem("tutorialShown") === "true";
if (!isTutorialShown) {
  startTutorial();
}
</script>

<style scoped>

.UserReservations {
  background-color: var(--background-color);
}
.img img {
  border-radius: 50%;
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.main-expanded {
    padding-left: 240px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
    padding-top: 64px;
    margin-left: 240px;
}

.main-collapsed {
    padding-left: 80px;
    transition: padding-left 0.3s ease;
    background-color: var(--background-color) !important;
}

* {
  box-sizing: border-box;
}

body {
  overflow-x: hidden;

}

@media (max-width: 600px) {
    .main {
        padding-left: 0;
        margin-left: 0;
        margin-bottom: 70px;
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

</style>
