<template>
    <v-dialog v-model="DialogIsOpen" class="dialog" @click:outside="closeDialog" persistent="false" >
        <template #default>

        <v-card class="about-us-container">
            <div class="d-flex justify-end align-center" style="padding-top: 10px">
                <v-icon class="mr-2 close-btn" @click="closeDialog">mdi-close</v-icon>
            </div>

            <v-card-title class="text-h4 text-center mb-4">
                {{ translate("INJAUNJA_TITLE") }}
            </v-card-title>

            <v-card-text class="text-body-1 text-center">
                <p>{{ translate("INJAUNJA_DESCRIPTION") }}</p>
            </v-card-text>

            <h2 class="text-h5 text-center mt-8 mb-4">
                {{ translate("TEAM_TITLE") }}
            </h2>

            <div class="team-members">
                <div v-for="(member, index) in team" :key="index" class="team-member">
                    <v-avatar size="100" class="mb-3">
                        <img :src="member.image" :alt="member.name" />
                    </v-avatar>
                    <h3 class="text-h6">{{ member.name }}</h3>
                    <p class="text-body-2">{{ member.role }}</p>
                </div>
            </div>
        </v-card>
        </template>
    </v-dialog>

</template>

<script>
import { translate } from "@/store/languageStore";

export default {
    name: "AboutUs",
    data() {
        return {
            DialogIsOpen: true,
            team: [],
        };
    },
    created() {
        try {
            this.team = [
                { name: "Armin Shamseddini", role: "Founder-C.E.O", image: "profile (1).jpg" },
                { name: "Javid Shams", role: "Founder-C.T.O", image: "profile (2).jpg" },
                { name: "Zahra Azizi", role: "Founder-C.O.O", image: "profile (3).jpg" },
                { name: "Ahmad Sadeghi", role: "Backend Developer", image: "profile (9).jpg" }
            ];
        } catch (error) {
            console.error("Error loading team data:", error);
        }
    },
    methods: {
        translate,

        closeDialog() {
            this.DialogIsOpen = false;
            this.$emit("close");
        }
    }
};
</script>

<style scoped>
.dialog {
    max-width: 800px;
    margin: 0 auto;
}

.about-us-container {
    padding: 24px;
    background-color: var(--background-color);
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
    font-size: 1rem;
}

.team-member p {
    color: #666;
    font-size: 0.9rem;
}

.team-member img {
    object-fit: cover;
    width: 100%;
    height: 100%;
}
.close-btn {
    transition: transform 0.2s ease;
}

.close-btn:hover {
    transform: rotate(90deg);
}

@media (max-width: 600px) {
    .about-us-container {
        padding: 16px;
    }

    .team-member {
        max-width: 100px;
    }

    .team-member h3 {
        font-size: 0.9rem;
    }

    .team-member p {
        font-size: 0.8rem;
    }

    .v-avatar {
        width: 70px !important;
        height: 70px !important;
    }

    .text-h4, .text-h5 {
        font-size: 1.2rem !important;
    }
}

@media (min-width: 601px) and (max-width: 960px) {
    .team-member {
        max-width: 120px;
    }

    .v-avatar {
        width: 90px !important;
        height: 90px !important;
    }

    .text-h4 {
        font-size: 1.6rem !important;
    }

    .text-h5 {
        font-size: 1.3rem !important;
    }
}
</style>
