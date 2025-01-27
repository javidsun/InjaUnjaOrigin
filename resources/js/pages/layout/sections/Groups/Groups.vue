<script setup>
import { ref } from "vue";

defineProps({
  groupImages: Array,
});

const emit = defineEmits(["selectGroup"]);

const selectedGroup = ref(null);

const selectGroup = (index) => {
  selectedGroup.value = index;
  emit("selectGroup", index); // ارسال مقدار به والد
};
</script>

<template>
  <v-row class="group-row">
    <v-col
        v-for="(group, index) in groupImages"
        :key="index"
        cols="12"
        sm="6"
        md="3"
        class="group-image-container"
        @click="selectGroup(index)"
    >
      <div class="image-box">
        <v-img :src="group" class="group-image" />
      </div>
    </v-col>
  </v-row>
</template>

<style scoped>
.group-row {
  margin-bottom: 30px;
  margin-top: 50px;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  padding: 0 60px;
  gap: 10px;
}
.group-image-container {
  margin-bottom: 5px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 1 1 calc(25% - 10px);
  max-width: calc(25% - 10px);

}
.image-box {
  width: 80%;
  aspect-ratio: 1;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border-radius: 8px;
  overflow: visible;
  transition: transform 0.3s ease-in-out;
  background-color: var(--background-color--groups);
  min-width: 150px;
  min-height: 150px;
}

.image-box:hover {
  transform: scale(1.05);
}

.group-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.group-image-container:hover .group-image {
  transform: scale(0.9);
  cursor: pointer;
}

@media (min-width: 960px) {
  .group-row {
    justify-content: flex-start;
  }

  .group-image-container {
    flex: 1 1 25%;
  }
  .image-box {
    width: 30%;
    min-width: 110px;
    min-height: 110px;

  }
}


@media (min-width: 100px) and (max-width: 200px) {
  .group-row {
    justify-content: flex-start;
  }

  .group-image-container {
    flex: 1 1 25%;
  }
  .group-image {
    max-width: 100%;
    max-height: 100%;
  }

  .image-box {
    width: 50%;
    min-width: 40px;
    min-height: 40px;
  }
}
@media (min-width: 200px) and (max-width: 370px) {

  .image-box {
    width: 50%;
    min-width: 50px;
    min-height: 50px;
    max-width: 50%;
  }
}
@media (min-width: 371px) and (max-width: 505px) {

  .image-box {
    width: 50%;
    min-width: 60px;
    min-height: 60px;
    max-width: 50%;
  }
}
@media (min-width: 506px) and (max-width: 960px) {
  .group-row {
    justify-content: flex-start;
  }

  .image-box {
    width: 5%;
    min-width: 80px;
    min-height: 80px;
  }
}


</style>
