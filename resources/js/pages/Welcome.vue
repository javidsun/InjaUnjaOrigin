<template>
    <v-container class="container__welcomeStep">

        <v-row class="justify-center text-center">
            <h1>{{ 'WELCOME_IN_INJA_UNJA' }}</h1>
            <v-col cols="12" class="pt-6 text-center">
                <v-row class="ga-10" justify="center" no-gutters>
                    <v-btn  color="green" prepend-icon="mdi-home" stacked variant="outlined">
                        HOME
                    </v-btn>
                    <v-btn  color="gray" prepend-icon="mdi-party-popper" stacked variant="outlined">
                        EVENTS
                    </v-btn>
                    <v-btn color="blue" prepend-icon="mdi-car-side" stacked variant="outlined">
                        CAR_RENTAL
                    </v-btn>
                </v-row>
            </v-col>
        </v-row>

        <v-row class="justify-center text-center">
            <v-col cols="12" class="pt-6 text-center">
                <v-row class="ga-10" justify="center" no-gutters>
                    <v-btn color="#FBC02D" prepend-icon="mdi-gauge" stacked variant="outlined">
                        {{ 'WELCOME_DASHBOARD' }}
                    </v-btn>
                    <v-btn color="#FF7043" prepend-icon="mdi-map" stacked variant="outlined">
                        {{ 'MAP' }}
                    </v-btn>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: "Welcome"
}
</script>

<style scoped lang="scss">

</style>
