import axios from 'axios';
import {env} from "@inertiajs/inertia-vue3/.eslintrc.js";

class ApiService {
    #instanceAxiosBackend;
     constructor() {
        this.#instanceAxiosBackend = //axios;
            axios.create({
                xsrfCookieName: "XSRF-TOKEN",
                withCredentials: true,//TODO : devo sapere dove vengono utilizzati perchè senza questi anchè vengono funzionati
            })
    }

    axiosToBackend(){
        return this.#instanceAxiosBackend;
    }

    setInstance(instance) {
        if (!instance) {
            this.#instanceAxiosBackend.defaults.baseURL = window.location.protocol + "//" + window.location.host;
        } else {
            this.#instanceAxiosBackend.defaults.baseURL = window.location.protocol + "//" + window.location.host + '/' + instance;
        }
    }
    getInstance() {
        return window.location.href;
    }

}export default new ApiService()
