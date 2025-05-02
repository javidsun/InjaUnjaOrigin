<template>
    <div v-if="ad">
        <h2>{{ ad.title }}</h2>
        <p>{{ ad.description }}</p>
        <img :src="ad.image" alt="Ad Image" />
        <p>Price: {{ ad.price }} Euro</p>

        <h3>User comments</h3>
        <v-list>
            <v-list-item v-for="comment in ad.comments" :key="comment.id">
                <v-list-item-content>
                    <v-list-item-title>{{ comment.user.name }}</v-list-item-title>
                    <v-list-item-subtitle>{{ comment.content }}</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
        </v-list>

        <v-alert v-if="errorMessage" type="error" dismissible>
            {{ errorMessage }}
        </v-alert>
    </div>
</template>

<script>
//Todo: {id / title / description/ image /price /comments:id / content /createdAt /user : id /name}

import adService from "../../services/adService";

export default {
    name: 'AdDetailView',
    data() {
        return {
            ad: null,
            errorMessage: '',
            isLoading: false
        }
    },
    methods: {
        async fetchAd() {
            this.isLoading = true;
            this.errorMessage = '';

            try {
                const adId = this.$route.params.id;
                const response = await adService.getAdById(adId);
                this.ad = response.data;
            } catch (error) {
                this.errorMessage = 'Failed to load ad details. Please try again later.';
                this.$logger.error("Error fetching ad:", error);
            } finally {
                this.isLoading = false;
            }
        }
    },
    mounted() {
        this.fetchAd();
    }
}
</script>
