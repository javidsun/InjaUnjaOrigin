<template>
    <v-container class="container__dashboard">
        <v-navigation-drawer v-model="drawer" app>
            <v-list>
                <v-list-item prepend-avatar="https://randomuser.me/api/portraits/men/85.jpg" title="John Doe" subtitle="Admin"></v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-list density="compact" nav>
                <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" value="dashboard"></v-list-item>
                <v-list-item prepend-icon="mdi-account" title="Utenti" value="users"></v-list-item>
                <v-list-item prepend-icon="mdi-cog" title="Impostazioni" value="settings"></v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app>
            <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Dashboard</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="toggleTheme">
                <v-icon>{{ theme.value === 'light' ? 'mdi-weather-night' : 'mdi-weather-sunny' }}</v-icon>
            </v-btn>
            <v-btn icon>
                <v-badge dot color="error">
                    <v-icon>mdi-bell</v-icon>
                </v-badge>
            </v-btn>
            <v-menu>
                <template v-slot:activator="{ props }">
                    <v-btn icon v-bind="props">
                        <v-avatar size="small">
                            <v-img src="https://randomuser.me/api/portraits/men/85.jpg" alt="John"></v-img>
                        </v-avatar>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-item title="Profilo" value="profile"></v-list-item>
                    <v-list-item title="Logout" value="logout"></v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-main>
            <v-container fluid>
                <v-row>
                    <!-- Widget statistiche -->
                    <v-col cols="12" sm="6" md="3">
                        <v-card class="mx-auto" max-width="344">
                            <v-avatar color="primary" size="x-large" class="mt-3">
                                <v-icon icon="mdi-account-group"></v-icon>
                            </v-avatar>
                            <v-card-title>Utenti</v-card-title>
                            <v-card-subtitle>Totale utenti registrati</v-card-subtitle>
                            <v-card-text>5,297</v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-card class="mx-auto" max-width="344">
                            <v-avatar color="success" size="x-large" class="mt-3">
                                <v-icon icon="mdi-currency-eur"></v-icon>
                            </v-avatar>
                            <v-card-title>Vendite</v-card-title>
                            <v-card-subtitle>Vendite questo mese</v-card-subtitle>
                            <v-card-text>€12,574</v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-card class="mx-auto" max-width="344">
                            <v-avatar color="warning" size="x-large" class="mt-3">
                                <v-icon icon="mdi-cart"></v-icon>
                            </v-avatar>
                            <v-card-title>Ordini</v-card-title>
                            <v-card-subtitle>Ordini in attesa</v-card-subtitle>
                            <v-card-text>23</v-card-text>
                        </v-card>
                    </v-col>
                    <v-col cols="12" sm="6" md="3">
                        <v-card class="mx-auto" max-width="344">
                            <v-avatar color="info" size="x-large" class="mt-3">
                                <v-icon icon="mdi-eye"></v-icon>
                            </v-avatar>
                            <v-card-title>Visite</v-card-title>
                            <v-card-subtitle>Visite oggi</v-card-subtitle>
                            <v-card-text>1,287</v-card-text>
                        </v-card>
                    </v-col>

                    <!-- Calendario -->
                    <v-col cols="12" md="4">
                        <v-card title="Calendario Eventi">
                            <v-card-text>
                                <v-date-picker v-model="date" :events="events" elevation="0"></v-date-picker>
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <!-- Tabella dati -->
                    <v-col cols="12">
                        <v-card title="Ultimi Ordini">
                            <v-card-text>
                                <v-text-field
                                    v-model="search"
                                    append-icon="mdi-magnify"
                                    label="Cerca"
                                    single-line
                                    hide-details
                                ></v-text-field>
                                <v-data-table
                                    :headers="headers"
                                    :items="orders"
                                    :search="search"
                                    :items-per-page="5"
                                    class="elevation-1"
                                ></v-data-table>
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-main>
    </v-container>
</template>

<script>
import { ref, computed } from 'vue';

export default {
    // TODO  : is option but const
    name: "Dashboard",
    setup() {
        const drawer = ref(false);
        //const date = ref(new Date().toISOString().substr(0, 10));
        const events = ['2023-05-01', '2023-05-15', '2023-05-22'];
        const search = ref('');
        const theme = ref('light');

        const headers = [
            { title: 'ID Ordine', align: 'start', sortable: true, key: 'id' },
            { title: 'Cliente', align: 'start', sortable: true, key: 'customer' },
            { title: 'Data', align: 'start', sortable: true, key: 'date' },
            { title: 'Stato', align: 'start', sortable: true, key: 'status' },
            { title: 'Totale', align: 'end', sortable: true, key: 'total' },
        ];

        const orders = [
            { id: 1, customer: 'Mario Rossi', date: '2023-05-01', status: 'Completato', total: '€120.00' },
            { id: 2, customer: 'Giulia Bianchi', date: '2023-05-02', status: 'In elaborazione', total: '€75.50' },
            { id: 3, customer: 'Luca Verdi', date: '2023-05-03', status: 'Spedito', total: '€200.00' },
            { id: 4, customer: 'Anna Neri', date: '2023-05-04', status: 'Completato', total: '€50.00' },
            { id: 5, customer: 'Marco Gialli', date: '2023-05-05', status: 'In attesa di pagamento', total: '€180.00' },
        ];

        const toggleTheme = () => {
            theme.value = theme.value === 'light' ? 'dark' : 'light';
        };

        return {
            drawer,
           // date,
            events,
            search,
            theme,
            headers,
            orders,
            toggleTheme,
        };
    },
};
</script>

<style scoped lang="scss">
.container__dashboard {
    .v-card {
        transition: all 0.3s ease-in-out;
    }

    .v-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.1);
    }

    .v-btn {
        transition: all 0.2s ease-in-out;
    }

    .v-btn:hover {
        transform: scale(1.05);
    }

    .text-center {
        text-align: center;
    }

    .mb-3 {
        margin-bottom: 1rem;
    }
}
</style>
