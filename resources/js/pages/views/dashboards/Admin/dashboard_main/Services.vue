<template>
  <VContainer>
    <VRow>
      <VCol
          v-for="(card, index) in cards"
          :key="index"
          cols="12"
          md="3"
      >
        <VCard class="custom-card fontsize">
          <VCardTitle class="text-h6 text-center">
            {{ translate(card.title) }}
          </VCardTitle>
          <VCardText class="text-center">
            <h3 class="text-h4">{{ card.count }}</h3>
            <VProgressLinear color="primary" :value="100" height="10" rounded-bar />
          </VCardText>
        </VCard>
      </VCol>
    </VRow>
  </VContainer>
</template>

<script setup>
//TODO : composition --> option & const & error warning
import { translate } from "@/store/languageStore.js";

const cards = [
  {
    title: "Services.house",
    count: 45,
  },
  {
    title: "Services.car",
    count: 12,
  },
  {
    title: "Services.event",
    count: 7,
  },
  {
    title: "Services.travel",
    count: 20,
  }
];
</script>

<style scoped>
@import '../../../../../../css/@core/template/lib/@layouts/styles/cards.scss';

.custom-card {
  background-color: var(--backgroundcards3-color--groups) !important;
  border: 1px solid #d1d9e6;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    color: black;
}

.text-center {
  text-align: center;
  font-family: "2 Baran", serif !important;
}

.v-progress-linear {
  margin-top: 10px;
  width: 100%;
}
</style>
