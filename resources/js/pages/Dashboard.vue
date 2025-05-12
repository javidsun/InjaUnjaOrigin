<template>
    <v-container class="container__dashboard">
        <template v-if="userRole === 'admin'">
            <AdminDashboard />
        </template>
        <template v-else-if="userRole === 'user'">
            <UserDashboard />
        </template>
        <template v-else>
            <p>You do not have permission to access this section..</p>
        </template>
    </v-container>
</template>

<script>
import AdminDashboard from './Admin/AdminDashboard.vue';
import UserDashboard from './Users/UserDashboard/UserDashboard.vue';

export default {
    name: 'Dashboard',
    components: {
        AdminDashboard,
        UserDashboard
    },
    data() {
        return {
            userRole: null
        }
    },
    mounted() {
        this.userRole = 'user';//فقط برای تست
    }


};
</script>
