<template>
    <v-col class="field-wrapper" position="relative" @click="toggleMenu">
        <div class="field-content">
            <img src="/assets/images/location-icon.png" alt="Location Icon" class="icon-img" />
            <span class="field-text" v-show="!isMobile">{{ translate(selectedOption) || translate('Anywhere.anywhere') }}</span>
        </div>

        <v-dialog
            v-model="isActive"
            max-width="500px"
            transition="dialog-transition"
            content-class="center-modal"
        >
            <v-card class="width_1">
                <v-card-title class="headline">
                    {{ translate('Select Location') }}
                </v-card-title>
                <v-card-text>
                    <div class="options-menu-modal">
                        <v-btn block @click="selectOption('Anywhere.flexible')">{{ translate('FLEXIBLE') }}</v-btn>
                        <v-btn block @click="selectOption('Anywhere.italy')">{{ translate('ANYWHERE_ITALY') }}</v-btn>
                        <v-btn block @click="selectOption('Anywhere.spain')">{{ translate('ANYWHERE_SPAIN') }}</v-btn>
                        <v-btn block @click="selectOption('Anywhere.france')">{{ translate('ANYWHERE_FRANCE') }}</v-btn>
                        <v-btn block @click="selectOption('Anywhere.turkey')">{{ translate('ANYWHERE_TURKEY') }}</v-btn>
                        <v-btn block @click="selectOption('Anywhere.unitedStates')">{{ translate('ANYWHERE_UNITEDSTATES') }}</v-btn>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="toggleMenu">
                        {{ translate('Close') }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-col>
</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: 'anywherefield',
    props: {
        activeMenu: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            selectedOption: null,
            isMobile: false,
            translate: null
        };
    },
    computed: {
        isActive: {
            get() {
                return this.activeMenu === "anywhere";
            },
            set(value) {
                this.$emit("update-active-menu", value ? "anywhere" : null);
            }
        },
        translate() {
            return translate;
        }
    },
    methods: {
        translate,

        toggleMenu() {
            try {
                this.$emit("update-active-menu", this.isActive ? null : "anywhere");
            } catch (error) {
                console.error('Error toggling menu:', error);
                this.showError('Failed to toggle menu. Please try again.');
            }
        },
        selectOption(option) {
            try {
                this.selectedOption = option;
                this.$emit("update-active-menu", null);
                this.$emit('location-selected', option);
                this.showSuccess('Location selected successfully!');
            } catch (error) {
                console.error('Error selecting option:', error);
                this.showError('Failed to select location. Please try again.');
            }
        },
        checkScreenSize() {
            try {
                this.isMobile = window.innerWidth <= 950;
            } catch (error) {
                console.error('Error checking screen size:', error);
                this.isMobile = false;
            }
        },
        showSuccess(message) {
            this.$emit('show-alert', {
                type: 'success',
                message: message,
                duration: 3000
            });
        },
        showError(message) {
            this.$emit('show-alert', {
                type: 'error',
                message: message,
                duration: 5000
            });
        },
        handleResize() {
            try {
                this.checkScreenSize();
            } catch (error) {
                console.error('Error handling resize:', error);
            }
        }
    },
    mounted() {
        this.checkScreenSize();
        window.addEventListener("resize", this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener("resize", this.handleResize);
    }
};
</script>

<style scoped>
.field-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    cursor: pointer;
}

.field-content {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--text-color);
    background-color: var(--background-color);
    padding: 10px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: background-color 0.3s ease, color 0.3s ease;
}

.icon-img {
    width: 40px;
    height: 40px;
}

.field-text {
    font-size: 14px;
}

.options-menu-modal {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 10px 0;
}
.width_1{
    width: 50% !important;
    margin-top: 250px;
}
.options-menu-modal v-btn {
    width: 100%;
    padding: 12px;
    font-size: 14px;
    text-align: center;
    background: var(--background-color);
    color: var(--text-color);
    border: 1px solid var(--border-color);
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.options-menu-modal v-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.center-modal {
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 768px) {
    .icon-img {
        width: 24px;
        height: 24px;
    }

    .field-text {
        display: none;
    }
}
</style>
