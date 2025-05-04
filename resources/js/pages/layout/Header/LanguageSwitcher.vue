<template>
    <v-btn class="language-btn" @click="toggleLanguage">
        {{ currentLanguage === 'fa' ? 'EN' : 'FA' }}
    </v-btn>
</template>

<script setup>
import { currentLanguage, setLanguage } from '@/store/languageStore';

const toggleLanguage = () => {
    setLanguage(currentLanguage.value === 'fa' ? 'en' : 'fa');
};
</script>

<style scoped>
.language-btn {
    background-color: transparent;
    box-shadow: none;
    font-weight: bold;
    padding-right: 0;
    border: none;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 14px;
    margin-top: 10px;
}
@media (min-width: 993px) {
    .language-btn {
        font-size: 14px;
    }

}
@media (max-width: 992px) {
    .language-btn {
        font-size: 12px;
    }

}

</style>
