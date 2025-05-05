<template>
    <div className="main-banner">
        <v-img :src="bannerImage" alt="Main Banner" />
    </div>
</template>

<script>
export default {
    name: 'MainBanner',
    props: {
        bannerImage: {
            type: String,
            required: true,
            default: ''
        }
    },
}
</script>

<style>
.main-banner {
    width: 85%;
    border-radius: 8px;
    padding-top: 45px;
}

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
</style>
