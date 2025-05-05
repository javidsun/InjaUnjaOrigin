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

<script>
import Group from "../sections/Groups/Groups.vue";
import Advertisements from "./Advertisements.vue";
import MainBanner from "./MainBanner.vue";
import TravelersContent from "./Groups/Travel Ads/TravelersContent.vue";
import HousesContent from "./Groups/House Ads/HousesContent.vue";
import VehiclesContent from "./Groups/Vehicles Ads/VehiclesContent.vue";
import EventsContent from "./Groups/Event Ads/EventsContent.vue";

export default {
    name: 'ContentSection',
    components: {
        Group,
        Advertisements,
        MainBanner: MainBanner,
        TravelersContent,
        HousesContent,
        VehiclesContent,
        EventsContent
    },
    data() {
        return {
            images: {
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
            },
            isExpanded: false,
            selectedGroup: null,
            isMobile: false
        }
    },
    computed: {
        selectedComponent() {
            try {
                let componentMap = {
                    0: "TravelersContent",
                    1: "HousesContent",
                    2: "VehiclesContent",
                    3: "EventsContent"
                };
                return componentMap[this.selectedGroup] || null;
            } catch (error) {
                this.handleError("Error determining selected component", error);
                return null;
            }
        }
    },
    mounted() {
        try {
            this.updateIsMobile();
            window.addEventListener("resize", this.updateIsMobile);
        } catch (error) {
            this.handleError("Error during component mounting", error);
        }
    },
    beforeDestroy() {
        try {
            window.removeEventListener("resize", this.updateIsMobile);
        } catch (error) {
            this.handleError("Error during component cleanup", error);
        }
    },
    methods: {
        handleExpand(expanded) {
            try {
                this.isExpanded = expanded;
            } catch (error) {
                this.handleError("Error expanding content", error);
            }
        },
        handleClose() {
            try {
                this.selectedGroup = null;
                this.$emit('groupClosed');
            } catch (error) {
                this.handleError("Error closing group", error);
            }
        },
        updateIsMobile() {
            try {
                this.isMobile = window.innerWidth <= 960;
            } catch (error) {
                this.handleError("Error detecting screen size", error);
            }
        },
        handleGroupSelect(index) {
            try {
                this.selectedGroup = index;
                this.$emit('groupSelected', index);
            } catch (error) {
                this.handleError("Error selecting group", error);
            }
        },
        handleError(message, error) {
            this.$emit('errorOccurred', {
                message: message,
                error: error?.message || 'Unknown error'
            });
        }
    }
}
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
