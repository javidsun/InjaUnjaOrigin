<template>
    <v-navigation-drawer
        v-model="localValue"
        expand-on-hover
        rail
        permanent
    >

        <v-list
            v-if="isUserLogged"
            nav
        >
            <template
                v-for="item in this.menuItems"
            >
                <v-list-item
                    :prepend-icon=item.icon
                    :title=item.title
                    :value="item.title"
                    @click="() => !!item.routeName ? goTo(item.routeName) : null"
                />
            </template>
        </v-list>

    </v-navigation-drawer>
</template>

<script>
import {router} from "@inertiajs/vue3";

export default {
    name: "AppDrawer",
    components: {},
    props: {
        value: {
            type: Boolean,
            default: false
        },
        currentInstance: {
            type: String,
            default: ''
        },
        isUserLogged: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            localValue: true,
            menuItems: [],
            appleOrAndroidConfigured: false,
        };
    },
    methods: {
        goTo(routeName) {
            router.visit(routeName);
        },
    },
    watch: {
        value(newVal) {
            this.localValue = newVal;
        }
    },
};
</script>

<style scoped lang="scss">
.v-list-item:hover {
    background-color: rgb(var(--v-theme-primary));
    color: rgb(var(--v-theme-on-primary));
}

.v-navigation-drawer--left {
    border-right: 0 !important;
}
</style>
