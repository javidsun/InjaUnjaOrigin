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

<script>
//Todo:image/user_id/is_uploaded

import { translate } from "@/store/languageStore";

export default {
    data() {
        return {
            avatar: "/avatar-2.png",
            avatarPreview: null,
            isUploaded: false,
        };
    },
    methods: {
        translate,

        onFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    this.avatarPreview = reader.result;
                    this.isUploaded = true;
                };
                reader.readAsDataURL(file);
            }
        },
        handleButtonClick() {
            if (!this.isUploaded) {
                this.$refs.fileInput.click();
            } else {
                this.avatar = this.avatarPreview;
                this.isUploaded = false;
            }
        },
    },
    watch: {
        avatar(newAvatar) {
            const event = new CustomEvent("update-avatar", { detail: newAvatar });
            window.dispatchEvent(event);
        },
    },
};
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
</style>


