import '../css/app.css'
import './bootstrap'

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import vuetify from '../js/pages/plugins/vuetify/vuetify.js';
import pinia from '../js/pages/plugins/pinia/index';
import App from "../js/pages/App.vue"; // تغییر مسیر به pages/App.vue
import 'vuetify/dist/vuetify.min.css';
import apiService from "@/globalServices/apiService.js";

const start = window.performance.now();

// بازیابی state پس از reload
const savedState = sessionStorage.getItem("piniaAppState");
if (savedState) {
    pinia.state.value = JSON.parse(savedState);
}

// ذخیره state قبل از خروج از صفحه
window.addEventListener("beforeunload", () => {
    sessionStorage.setItem("piniaAppState", JSON.stringify(pinia.state.value));
});

createInertiaApp({
    resolve: async name => {
        const pages = import.meta.glob('./pages/*.vue');
        let page = await pages[`./pages/${name}.vue`]();
        // حذف لایه‌بندی پیش‌فرض و استفاده مستقیم از کامپوننت‌ها
        return page;
    },
    setup({ el, App, props, plugin }) {
        const vue = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(vuetify)
            .use(pinia)
            .component('InertiaLink', Link);

        return vue.mount(el);
    },
});

const end = window.performance.now();
const duration = end - start;
