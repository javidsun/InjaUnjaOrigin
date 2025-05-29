<template>
    <div>
        <v-btn
            icon
            @click="menuActive = !menuActive"
            :class="['menu-button', { 'menu-active': menuActive }]">
            <v-icon>mdi-menu</v-icon>
        </v-btn>

        <v-menu v-model="menuActive" class="menu_open" close-on-content-click>
            <v-list dense>
                <v-list-item-group>
                    <v-list-item
                        v-for="(item, index) in menuItems"
                        :key="index"
                        @click="handleMenuItemClick(item.component)">
                        <v-list-item-content class="v-list-item-content">
                            <v-list-item-icon>
                                <v-icon class="menu-icon">{{ item.icon }}</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title class="menu-title">{{ translate(item.title) }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-menu>

        <v-dialog
            v-model="modalActive"
            max-width="900px"
            persistent
            @update:modelValue="handleModalClose"
        >
            <v-card>
                <component
                    :is="selectedComponent"
                    ref="modalRef"
                    @close="handleModalClose"
                />
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import { translate } from "@/store/languageStore";
import RegisterUser from "../../RegisterUser.vue";
import Login from "../../Login.vue";
import GiftModal from "../../layout/menu_component/GiftCardatFirst.vue";
import InjaUnja from "../../layout/menu_component/InjaUnja.vue";
import HelpCenter from "../../Users/SettingModals/SupportModal.vue";

export default {
    name: 'HamburgerMenu',

    data() {
        return {
            menuActive: false,
            modalActive: false,
            selectedComponent: null,
            modalRef: null,
            menuItems: [
                { title: "menu.register", icon: "mdi-account-plus", component: RegisterUser },
                { title: "menu.login", icon: "mdi-login", component: Login },
                { title: "menu.giftCard", icon: "mdi-gift", component: GiftModal },
                { title: "menu.injaUnja", icon: "mdi-map-marker", component: InjaUnja },
                { title: "menu.helpCenter", icon: "mdi-help-circle", component: HelpCenter }
            ]
        };
    },

    methods: {
        translate,

        async handleMenuItemClick(component) {
            try {
                this.selectedComponent = component;
                this.modalActive = true;

                await this.$nextTick();

                if (this.modalRef && typeof this.modalRef.openModal === 'function') {
                    this.modalRef.openModal();
                } else {
                    this.showWarning("The requested modal could not be opened properly.");
                }
            } catch (error) {
                this.showError("An error occurred while opening the modal", error);
            }
        },

        handleModalClose() {
            this.modalActive = false;
            this.menuActive = false;
            this.selectedComponent = null;

            if (this.modalRef && typeof this.modalRef.closeDialog === 'function') {
                this.modalRef.closeDialog();
            }
            const overlays = document.querySelectorAll('.v-overlay');
            overlays.forEach(overlay => {
                if (overlay.style.display !== 'none') {
                    overlay.style.display = 'none';
                }
            });
        },
        showWarning(message) {
            console.warn(message);
            this.$emit('show-notification', {
                type: 'warning',
                message: message,
                timeout: 5000
            });
        },

        showError(message, error) {
            console.error(message, error);
            this.$emit('show-notification', {
                type: 'error',
                message: `${message}. Please try again later.`,
                timeout: 8000
            });
        }
    },

    mounted() {
        this.$emit('ready', {
            openModal: this.handleMenuItemClick
        });
    }
};
</script>

<style scoped>
.menu_open {
    padding-right: 0;
    display: flex;
    justify-content: right;
    align-items: inherit;
    margin-top: 60px;
    margin-right: 10px;
    background-color: rgba(255, 255, 255, 0.3);
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

.menu-title {
    font-size: 12px;
    padding-left: 5px;
    padding-right: 90px;
    margin: 0;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.3s;
}

.menu-button {
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.3s;
    margin-top: 10px;
    margin-right: 40px;
}

.menu-button.menu-active {
    background-color: #e0e0e0;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
}

.menu-icon {
    color: var(--sidebar-icon-color);
}

.v-list-item-content {
    display: flex;
    align-items: center;
}
</style>
