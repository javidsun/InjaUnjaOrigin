<!--فایل  ContentSection.js در services      فایل   ContentSection.json در پوشه docs -->

<template>
    <v-row class="content-section">
        <v-col cols="12" md="7" class="move-down">
            <Group :groupImages="images.groups" @selectGroup="handleGroupSelect" />
            <div class="divider"></div>
            <div v-if="isMobile || isExpanded">
                <Advertisements
                    v-if="selectedGroup === null"
                    :advertisements="images.advertisements"
                    :class="{ 'expanded-advertisements': isExpanded }"
                />
                <div v-else class="selected-group-content" :class="{ 'expanded': isExpanded }">
                    <component :is="selectedComponent" @close="handleClose" @expand="handleExpand" />
                </div>
            </div>

            <div v-else>
                <Advertisements :advertisements="images.advertisements" />
            </div>
        </v-col>

        <v-col cols="12" md="5" class="main-banner-container d-none d-md-block">
            <MainBanner v-if="isExpanded || selectedGroup === null" :bannerImage="images.mainBanner" />
            <div v-else class="selected-group-content">
                <component :is="selectedComponent" @close="handleClose" @expand="handleExpand" />
            </div>
        </v-col>
    </v-row>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import Group from "../sections/Groups/Groups.vue";
import Advertisements from "./Advertisements.vue";
import MainBanner from "./MainBanner.vue";
import TravelersContent from "./Groups/Travel Ads/TravelersContent.vue";
import HousesContent from "./Groups/House Ads/HousesContent.vue";
import VehiclesContent from "./Groups/Vehicles Ads/VehiclesContent.vue";
import EventsContent from "./Groups/Event Ads/EventsContent.vue";
import {
    getContentSectionData,
    getGroupData,
    getAdvertisementData,
    getMainBannerData
} from "../../../services/general/ContentSection.js";

const images = {
    mainBanner: "untitled-design-5-110.png",
    groups: [
        "untitled-design-20-250.png",
        "untitled-design-20-230.png",
        "untitled-design-20-240.png",
        "Untitled design (10) 8.png",
    ],
    advertisements: [
        { image: "untitled-design-18-60.png", text: "First advertisement text" },
        { image: "untitled-design-19-20.png", text: "Second advertisement text" },
    ],
};

const isExpanded = ref(false);
const selectedGroup = ref(null);
const isMobile = ref(false);

const handleExpand = (expanded) => {
    isExpanded.value = expanded;
};

const handleClose = () => {
    selectedGroup.value = null;
};

const updateIsMobile = () => {
    isMobile.value = window.innerWidth <= 960;
};

onMounted(() => {
    updateIsMobile();
    window.addEventListener("resize", updateIsMobile);
});

const handleGroupSelect = (index) => {
    selectedGroup.value = index;
};

const selectedComponent = computed(() => {
    if (selectedGroup.value === 0) return TravelersContent;
    if (selectedGroup.value === 1) return HousesContent;
    if (selectedGroup.value === 2) return VehiclesContent;
    if (selectedGroup.value === 3) return EventsContent;
    return null;
});
</script>

<style scoped>
.divider {
    height: 1px;
    width: 90%;
    margin-left: 25px;
    background-color: lightsteelblue;
}
.move-down {
    margin-top: 30px;
}
.content-section {
    margin-top: 30px;
}
.selected-group-content.expanded {
    max-width: 100%;
    margin: 0 auto;
}
.selected-group-content {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}
.expanded-advertisements {
    max-width: 100%;
    margin: 0 auto;
}
</style>
