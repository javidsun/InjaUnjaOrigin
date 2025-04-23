<template class="back">
    <UserSidebar class="back">
        <travelers/>
    </UserSidebar>
</template>

<script>
import UserSidebar from '../../Users/Layout.vue';
import travelers from '../../layout/sections/Groups/Travel Ads/TravelersContent.vue';
export default {
    components: {
        UserSidebar,
        travelers,
    }
};

</script>

<style scoped>
.back{
    background-color: var(--background-color) !important;
    color: var(--text-color) !important;

}
</style>
