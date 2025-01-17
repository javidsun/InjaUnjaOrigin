import '../css/app.css'
import './bootstrap'

import { createApp, h } from 'vue';
import { createInertiaApp , Link} from '@inertiajs/vue3';
import vuetify from '@/pages/plugins/vuetify/vuetify.js'
import pinia from '@/pages/plugins/pinia/index';
import App from "@/pages/Layout/App.vue";
import 'vuetify/dist/vuetify.min.css';
import apiService from "@/globalServices/apiService.js";

const start = window.performance.now();

// Restore state after reload
const savedState = sessionStorage.getItem("piniaAppState");
if (savedState) {
    pinia.state.value = JSON.parse(savedState);
}

// Save state before unload
window.addEventListener("beforeunload", () => {
    sessionStorage.setItem("piniaAppState", JSON.stringify(pinia.state.value));
});

createInertiaApp({
    resolve: async name => {
        const pages = import.meta.glob('./pages/*.vue');
        let page = await pages[`./pages/${name}.vue`]();
        page.default.layout = (h,page) => h(App,{},[page]);
        page.default.layout = App;
        return page
    },
    setup({ el, App, props, plugin }) {
        const vue = createApp({ render: () => h(App, props) })
        .use(plugin)
        .use(vuetify)
        .use(pinia)
        .component('InertiaLink', Link)

        return vue.mount(el);
    },


});
const end = window.performance.now();
const duration = end - start;

