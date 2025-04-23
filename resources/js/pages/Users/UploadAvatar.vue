<template>
  <div class="upload-avatar">
    <v-avatar size="200px">
      <img :src="avatarPreview || avatar" alt="User Avatar" />
    </v-avatar>
    <input type="file" accept="image/*" @change="onFileChange" hidden ref="fileInput" />
    <v-btn @click="handleButtonClick" class="mt-2 btn" :color="isUploaded ? 'success' : 'primary'">
      {{ isUploaded ? translate('profile.saveChanges') : translate('profile.changeAvatar') }}
    </v-btn>
  </div>
</template>

<script setup>
//TODO : composition --> option & const & error warning

import { ref, watch } from "vue";
import { translate } from "@/store/languageStore.js";

const avatar = ref("/avatar-2.png");
const avatarPreview = ref(null);
const isUploaded = ref(false);
const fileInput = ref(null);

const onFileChange = (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      avatarPreview.value = reader.result;
      isUploaded.value = true;
    };
    reader.readAsDataURL(file);
  }
};

const handleButtonClick = () => {
  if (!isUploaded.value) {
    fileInput.value.click();
  } else {
    avatar.value = avatarPreview.value;
    isUploaded.value = false;
  }
};

watch(avatar, (newAvatar) => {
  const event = new CustomEvent("update-avatar", { detail: newAvatar });
  window.dispatchEvent(event);
});
</script>

<style scoped>
.upload-avatar {
  text-align: center;
}

.upload-avatar img {
  object-fit: cover;
  width: 50%;
  height: 50%;
  border-radius: 50%;
}
.v-btn  {
  display: block;
  margin: 0 auto 0;
}
</style>
