<template>
    <v-card class="about-us-container">
        <v-card-title class="text-h4 text-center mb-4">
            {{ translate("injaunja.title") }}
        </v-card-title>

        <v-card-text class="text-body-1 text-center">
            <p>{{ translate("injaunja.description") }}</p>
        </v-card-text>

        <h2 class="text-h5 text-center mt-8 mb-4">
            {{ translate("injaunja.teamTitle") }}
        </h2>

        <div class="team-members">
            <div v-for="(member, index) in team" :key="index" class="team-member">
                <v-avatar size="100" class="mb-3">
                    <img :src="member.image" :alt="member.name" class="team-image"/>
                </v-avatar>
                <h3 class="text-h6">{{ member.name }}</h3>
                <p class="text-body-2">{{ member.role }}</p>
            </div>
        </div>
    </v-card>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref } from 'vue';
import { translate } from "@/store/languageStore.js";

const isSupportModalOpen = ref(false);

const openModal = () => {
    isSupportModalOpen.value = true;
};

const team = [
    { name: "Armin Shamseddini", role: "Founder-C.E.O", image: "profile (1).jpg" },
    { name: "Javid Shams", role: "Founder-C.T.O", image: "profile (2).jpg" },
    { name: "Zahra Azizi", role: "Founder-C.O.O", image: "profile (3).jpg" },
    { name: "Mohamad Keshmiri", role: "Backend Developer", image: "profile (8).jpg" }
];

const closeModal = () => {
    dialog.value = false;
};
defineExpose({ openModal });
</script>

<style scoped>
.about-us-container {
    padding: 24px;
    background-color: Var(--background-color);
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.team-members {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

.team-member {
    text-align: center;
    max-width: 150px;
}

.team-member h3 {
    margin-top: 8px;
    font-weight: 600;
}

.team-member p {
    color: #666;
}

.team-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}
</style>
