
<template>
  <div
      class="access-container"
      @mouseenter="isHovered = true"
      @mouseleave="isHovered = false"
  >

    <v-btn icon class="hand-icon">
      <v-icon>mdi-hand-extended</v-icon>
    </v-btn>


    <v-row v-if="isHovered" class="access-list">
      <v-col
          v-for="(image, index) in props.accessImages"
          :key="index"
          cols="12"
          class="access-item"
      >
        <v-img :src="image" class="access-image" />
      </v-col>
    </v-row>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
    accessImages: Array,
});

const isHovered = ref(false);
</script>

<style scoped>
.access-container {
  position: fixed;
  top: 20%;
  left: 10px;
  z-index: 1000;
}

.hand-icon {
  background-color: var(--search-background-color);
  border: 1px solid #ddd;
  border-radius: 50%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.access-list {
  background-color: rgba(255, 255, 255, 0.3);
  backdrop-filter: blur(10px);
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  border: 1px solid rgba(255, 255, 255, 0.5);
  border-radius: 8px;
  padding: 10px;
}

.access-item {
  margin-bottom: 10px;
}

.access-image {
  width: 50px;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
</style>
