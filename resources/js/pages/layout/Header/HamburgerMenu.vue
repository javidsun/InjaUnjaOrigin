<template>
    <div>
        <v-btn
            icon
            @click="menuActive = !menuActive"
            :class="['menu-button', { 'menu-active': menuActive }]">
            <v-icon>mdi-menu</v-icon>
        </v-btn>

        <v-menu v-model="menuActive" class="menu_open">
            <v-list dense>
                <v-list-item-group>
                    <v-list-item
                        v-for="(item, index) in menuItems"
                        :key="index"
                        @click="openModal(item.component)">
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

        <v-dialog v-show="modalActive" v-model="modalActive" max-width="900px" @update:modelValue="closeModal">
            <v-card-text>
                <component :is="selectedComponent" ref="modalRef"></component>
            </v-card-text>
        </v-dialog>

    </div>
</template>

<script setup>
import { ref, shallowRef, nextTick } from "vue";
import { translate } from "../../../store/languageStore";
import RegisterUser from "../../RegisterUser.vue";
import Login from "../../Login.vue";
import GiftModal from "../../layout/menu_component/GiftCardatFirst.vue";
import InjaUnja from "../../layout/menu_component/InjaUnja.vue";
import HelpCenter from "../../Users/SettingModals/SupportModal.vue";

const isSupportModalOpen = ref(false);

const closeSupportModal = () => {
    isSupportModalOpen.value = false;
};


const menuActive = ref(false);
const modalActive = ref(false);
const selectedComponent = shallowRef(null);
const modalRef = ref(null);

const openModal = async (component) => {
    console.log("Opening modal for component:", component);
    selectedComponent.value = component;
    modalActive.value = true;

    await nextTick();

    console.log("Modal ref:", modalRef.value);
    if (modalRef.value && modalRef.value.openModal) {
        modalRef.value.openModal();
    } else {
        console.error("Modal ref or openModal method is not available.");
    }
};

const closeModal = () => {
    modalActive.value = false;
    selectedComponent.value = null;
};

const menuItems = [
    { title: "menu.register", icon: "mdi-account-plus", component: RegisterUser },
    { title: "menu.login", icon: "mdi-login", component: Login },
    { title: "menu.giftCard", icon: "mdi-gift", component: GiftModal },
    { title: "menu.injaUnja", icon: "mdi-map-marker", component: InjaUnja },
    { title: "menu.helpCenter", icon: "mdi-help-circle", component: HelpCenter }
];
defineExpose({ openModal });
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

