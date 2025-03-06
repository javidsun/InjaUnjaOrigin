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
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import adService from "../../services/adService";

const route = useRoute();
const ad = ref(null);

const fetchAd = async () => {
    try {
        const response = await adService.getAdById(route.params.id);
        ad.value = response.data;
    } catch (error) {
        console.error("Error fetching ad:", error);
    }
};

onMounted(fetchAd);
</script>
