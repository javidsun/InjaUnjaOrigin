<template>
    <div>
        <v-row class="content-section">
            <v-col cols="12" :md="isGroupSelected && !isExpanded ? 8 : 12"
                   class="move-down"
                   :class="{
                       'desktop-centered': !isGroupSelected && !isMobile,
                       'left-content': isGroupSelected && !isExpanded
                   }">
                <Group :groupImages="images.groups"
                       @selectGroup="handleGroupSelect"
                       :selectedGroup="selectedGroup"
                       :is-expanded="isExpanded" />
                <div class="divider"></div>

                <Advertisements
                    v-if="!isExpanded"
                    :advertisements="images.advertisements"
                    :class="{ 'shrunk-ads': isGroupSelected }"
                />
            </v-col>

            <v-col v-if="isGroupSelected && !isMobile && !isExpanded" cols="12" md="4" class="selected-group-side">
                <div class="selected-group-content">
                    <component :is="selectedComponent" @close="handleClose" @expand="handleExpand" />
                </div>
            </v-col>

            <v-col v-if="isExpanded" cols="12" class="expanded-content">
                <component :is="selectedComponent" @close="handleClose" @expand="handleExpand" />
            </v-col>
        </v-row>
    </div>
</template>

<script>
import Group from "../sections/Groups/Groups.vue";
import Advertisements from "./Advertisements.vue";
import TravelersContent from "./Groups/Travel Ads/TravelersContent.vue";
import HousesContent from "./Groups/House Ads/HousesContent.vue";
import VehiclesContent from "./Groups/Vehicles Ads/VehiclesContent.vue";
import EventsContent from "./Groups/Event Ads/EventsContent.vue";

export default {
    name: 'ContentSection',
    components: {
        Group,
        Advertisements,
        TravelersContent,
        HousesContent,
        VehiclesContent,
        EventsContent
    },
    data() {
        return {
            images: {
                groups: [
                    "Traveler.ico",
                    "House.ico",
                    "Vehicles.ico",
                    "Event.ico",
                ],
                advertisements: [
                    { image: "untitled-design-18-60.png", text: "First advertisement text" },
                    { image: "untitled-design-19-20.png", text: "Second advertisement text" },
                    { image: "untitled-design-19-21.png", text: "third advertisement text" },
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
        },
        isGroupSelected() {
            return this.selectedGroup !== null;
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
                this.isExpanded = false;
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
        },
    }
}
</script>

<style scoped>
.left-content {
    animation: slideLeft 0.5s ease-out forwards;
}
@keyframes slideLeft {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-16.66%);
    }
}
.expanded-content {
    margin-top: 30px;
    animation: fadeIn 0.3s ease-out;
}

.shrunk-ads {
    transform: scale(0.5);
    transform-origin: center;
    margin: 0 auto;
    width: 50%;
}


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
    position: relative;
    z-index: 2;
}

.selected-group-content.expanded {
    max-width: 5%;
    margin: 0 auto;
}
.selected-group-content {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.desktop-centered {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.selected-group-side {
    animation: slideFromRight 0.5s ease-out forwards;
    margin-top: 30px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}


@keyframes slideFromRight {
    from {
        opacity: 0;
        transform: translateX(100%);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@media (min-width: 960px) {
    .left-content {
        animation: none;
        transform: none;
    }

    .shrunk-ads {
        animation: none;
        transform: none;
    }

    :deep(.advertisement-item) {
        width: 200% !important;
        max-width: 1200px !important;
        margin: 0 auto;
    }
    .desktop-centered .group-row {
        justify-content: center;
    }
    .desktop-centered .divider {
        width: 70%;
        margin: 0 auto;
    }
}
</style>
