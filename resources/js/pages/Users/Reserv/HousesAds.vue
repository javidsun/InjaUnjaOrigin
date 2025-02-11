<template class="back">
    <UserSidebar class="back">
        <Houses/>
    </UserSidebar>
</template>

<script>
import { t } from "../../../store/languageStore";
import UserSidebar from '../../Users/Layout.vue';
import Houses from '../../layout/sections/Groups/House Ads/HousesContent.vue';
export default {
    components: {
        UserSidebar,
        Houses,
    }
};

</script>

<style scoped>
.back{
    background-color: var(--background-color) !important;
    color: var(--text-color) !important;

}
</style>
