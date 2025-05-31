import '../css/app.css';
import './bootstrap';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import vuetify from '../js/pages/plugins/vuetify/vuetify.js';
import pinia from '../js/pages/plugins/pinia/index';
import App from "../js/pages/App.vue";
import { translate, setLanguage, currentLanguage } from "@/store/languageStore.js";
import 'vuetify/dist/vuetify.min.css';
import store from './store';

const start = window.performance.now();
const savedState = sessionStorage.getItem("piniaAppState");
if (savedState) {
    pinia.state.value = JSON.parse(savedState);
}
window.addEventListener("beforeunload", () => {
    sessionStorage.setItem("piniaAppState", JSON.stringify(pinia.state.value));
});

setLanguage(currentLanguage.value);

createInertiaApp({
    resolve: async name => {
        const pages = import.meta.glob('./pages/**/*.vue');
        let page = await pages[`./pages/${name}.vue`];

        if (!page) {
            throw new Error(`Page ${name} not found`);
        }
        return page();
    },
    setup({ el, App, props, plugin }) {
        const vue = createApp({ render: () => h(App, props) });

        vue.use(plugin)
            .use(vuetify)
            .use(pinia)
            .use(store)
            .component('InertiaLink', Link);

        vue.config.globalProperties.$t = translate;
        vue.config.globalProperties.$lang = currentLanguage;

        return vue.mount(el);
    },
});

const end = window.performance.now();
const duration = end - start;
