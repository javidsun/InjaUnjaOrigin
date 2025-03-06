<script setup>
const props = defineProps({
  bannerImage: String,
});
</script>

<template>
  <div class="main-banner">
    <v-img :src="bannerImage" alt="Main Banner" />
  </div>
</template>

<style>
@media (max-width: 960px) {
  .main-banner-container {
    justify-content: center;

  }
}
.main-banner-container {
  display: flex;
  justify-content: flex-end;
  width: 100%;
}
.main-banner {
  width: 85%;
  border-radius: 8px;
  padding-top: 45px;

}
</style>