<template>
  <v-carousel hide-delimiters cycle interval="4000" class="v-carousel">
    <v-carousel-item v-for="(ad, index) in advertisements" :key="index">
      <div class="ad-container">
        <v-img :src="ad.image" alt="Ad Image" class="ad-image" />
        <p class="ad-text">
            {{ translate('advertisements.firstAd') }}
        </p>
      </div>
    </v-carousel-item>
  </v-carousel>
</template>

<script setup>
import { translate } from "../../../store/languageStore";
const setLanguage = (lang) => {
    t(lang);
};

const props = defineProps({
  advertisements: Array,
});

</script>


<style>
.v-carousel {
  width: 267px;
  height: 133px;
  margin: auto;
  position: relative;
}

.ad-container {
  margin-top: 10px;
  width: 100%;
  height: 50%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 2px solid #858585;
  border-radius: 12px;
  text-align: center;
}

.ad-image {
  width: 100%;
  height: 80%;
  object-fit: cover;
  border-radius: 8px;
}

.ad-text {
  margin-top: 10px;
  font-size: 12px;
  color: var(--txt-color);
}

.v-carousel__prev,
.v-carousel__next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 30px;
  height: 30px;
  border-radius: 50%;
  background-color: rgba(0, 123, 255, 0.7);
  color: white;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.v-carousel__prev {
  left: 10px;
}

.v-carousel__next {
  right: 10px;
}


@media (max-width: 600px) {
  .v-carousel {
    width: 267px;
    height: 133px;
  }

  .ad-image {
    height: 80%;
  }
}
</style>
