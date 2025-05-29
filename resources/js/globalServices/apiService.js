import axios from 'axios';


class ApiService {
    #instanceAxiosBackend;

    constructor() {
        this.#instanceAxiosBackend = axios.create({
            baseURL: this.getBaseUrl(),
            xsrfCookieName: "XSRF-TOKEN",
            withCredentials: true,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
        });

        this.setupSanctumCSRF();
    }

    /**
     * Determina la base URL per le richieste Axios.
     * Utilizza window.location.origin per includere protocollo, host e porta.
     * Oppure puoi configurare direttamente l'URL del tuo backend Laravel.
     */
    getBaseUrl() {
        return 'http://localhost:8003/api';
    }

    /**
     * Configura l'interceptor per la richiesta CSRF di Laravel Sanctum.
     * Deve essere chiamato una volta all'avvio dell'applicazione.
     */
    setupSanctumCSRF() {
        this.#instanceAxiosBackend.get('/sanctum/csrf-cookie')
            .then(response => {
                console.log('Sanctum CSRF cookie obtained successfully.', response);
            })
            .catch(error => {
                console.error('Failed to obtain Sanctum CSRF cookie:', error);
            });
    }

    axiosToBackend() {
        return this.#instanceAxiosBackend;
    }

    // Questi metodi `setInstance` e `getInstance` sembrano sovrascrivere la base URL
    // e restituire l'URL corrente della finestra, il che è un po' confuso.
    // Se il tuo intento è avere la possibilità di cambiare la base URL in runtime,
    // dovresti chiarire lo scopo. Per le API di un backend Laravel,
    // la `baseURL` dell'istanza Axios dovrebbe essere fissa per il backend.
    //
    // Se `setInstance` serve per cambiare la base URL del backend:
    setInstance(instance) {
        if (!instance) {
            // Se `instance` è nullo, imposta la base URL all'URL del backend senza API prefix.
            // Esempio: 'http://localhost:8000'
            this.#instanceAxiosBackend.defaults.baseURL = 'http://localhost:8000'; // Sostituisci con il tuo root URL del backend
        } else {
            // Se `instance` è fornito, lo aggiunge alla base URL.
            // Esempio: se instance è 'api', la base URL diventa 'http://localhost:8000/api'
            this.#instanceAxiosBackend.defaults.baseURL = 'http://localhost:8000/' + instance; // Sostituisci con il tuo root URL del backend
        }
    }
    // Questo metodo getInstance() restituisce l'URL corrente del browser, non l'istanza Axios né la sua base URL.
    // Il nome è fuorviante. Se vuoi la base URL corrente di Axios, fai:
    getAxiosBaseUrl() {
        return this.#instanceAxiosBackend.defaults.baseURL;
    }
    // Se il tuo scopo era restituire l'istanza Axios stessa, il metodo axiosToBackend() già lo fa.
    // getAxiosInstance() {
    //     return this.#instanceAxiosBackend;
    // }
}

export default new ApiService();
