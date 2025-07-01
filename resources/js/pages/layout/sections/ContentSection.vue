<template>
    <div>
        <div class="hero-section">
            <h1 class="hero-title">Welcome to InjaUnja</h1>
            <p class="hero-tagline">Find your next adventure, home, ride, or event – all in one place.</p>
        </div>
        <v-row class="content-section">
            <v-col cols="12" :md="isGroupSelected && !isExpanded ? 8 : 12"
                   class="move-down"
                   :class="{
                       'desktop-centered': !isGroupSelected && !isMobile,
                       'left-content': isGroupSelected && !isExpanded
                   }">
                <div class="icon-grid">
                    <v-row justify="center" align="center" class="icon-row">
                        <v-col v-for="(icon, idx) in images.groups" :key="icon" cols="6" sm="3" class="icon-col">
                            <v-tooltip bottom>
                                <template #activator="{ on, attrs }">
                                    <v-card
                                        class="icon-card"
                                        v-bind="attrs"
                                        v-on="on"
                                        :elevation="selectedGroup === idx ? 12 : 4"
                                        :class="{ 'icon-card--active': selectedGroup === idx }"
                                        @click="handleGroupSelect(idx)"
                                        tabindex="0"
                                        aria-label="Select group"
                                        v-ripple
                                    >
                                        <v-img :src="'/' + icon" :alt="icon.replace('.ico','') + ' icon'" class="icon-img" contain />
                                        <div class="icon-label">{{ translate(`icons.${icon.replace('.ico', '')}`) }}</div>
                                    </v-card>
                                </template>
                                <span>{{ icon.replace('.ico','') }}</span>
                            </v-tooltip>
                        </v-col>
                    </v-row>
                </div>
                <div class="divider"></div>
                <template v-if="isMobile && isGroupSelected && !isExpanded">
                    <div class="selected-group-content mobile-group-content">
                        <component :is="selectedComponent" @close="handleClose" @expand="handleExpand" />
                    </div>
                </template>
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
import { translate } from "../../../store/languageStore";

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
        translate,
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
.hero-section {
    text-align: center;
    margin-bottom: 32px;
    margin-top: 8px;
}
.hero-title {
    font-size: 2.8rem;
    font-weight: 800;
    color: #1a237e;
    margin-bottom: 8px;
    letter-spacing: 1px;
}
.hero-tagline {
    font-size: 1.25rem;
    color: #374151;
    font-weight: 400;
    margin-bottom: 0;
}
.icon-grid {
    margin-bottom: 32px;
}
.icon-row {
    margin: 0 auto;
    max-width: 900px;
}
.icon-col {
    display: flex;
    justify-content: center;
    align-items: center;
}
.icon-card {
    width: 150px;
    height: 170px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    border-radius: 24px;
    box-shadow: 0 2px 16px rgba(30,34,44,0.10);
    background:var(--background-color);
    transition: box-shadow 0.25s, transform 0.18s, background 0.18s;
    outline: none;
    border: 2px solid transparent;
    margin-bottom: 8px;
    position: relative;
}
.icon-card:focus {
    border: 2px solid #4cc8ff;
    box-shadow: 0 0 0 4px rgba(76,200,255,0.15);
}
.icon-card:hover {
    box-shadow: 0 8px 32px rgba(76,200,255,0.18);
    background: rgba(236,248,255,0.95);
    transform: translateY(-4px) scale(1.04);
}
.icon-card--active {
    border: 2.5px solid #1a237e;
    background: rgba(76,200,255,0.10);
    box-shadow: 0 8px 32px rgba(76,200,255,0.22);
}
.icon-img {
    width: 120px;
    height: 120px;
    margin-bottom: 10px;
    filter: drop-shadow(0 2px 8px rgba(76,200,255,0.10));
    border-radius: 25px;
}
.icon-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--txt-color);
    text-align: center;
    letter-spacing: 0.5px;
}
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
