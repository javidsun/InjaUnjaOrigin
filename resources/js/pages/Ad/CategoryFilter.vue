<template>
    <v-select
        v-model="selectedCategory"
        :items="categories"
        label="Choose a category"
        item-title="name"
        item-value="id"
        @update:modelValue="filterByCategory"
    ></v-select>
</template>

<script>

import axios from "axios";

export default {
    name: "CategorySelector",
    data() {
        return {
            selectedCategory: null,
            categories: []
        };
    },
    methods: {

        filterByCategory(categoryId) {
            try {
                this.$emit("categorySelected", categoryId);
            } catch (error) {
                this.showError("Error filtering category", error);
            }
        },


        async fetchCategories() {
            try {
                const response = await axios.get("/api/categories");
                this.categories = response.data;
            } catch (error) {
                this.showError("Error retrieving categories", error);
            }
        },

        showError(message, error) {
            console.error(message, error);
            this.$alert({
                title: "error",
                text: `${message}. Please try again..`,
                type: "error",
                confirmButtonText: "I understand"
            });
        }
    },
    mounted() {
        this.fetchCategories();
    }
};
</script>
