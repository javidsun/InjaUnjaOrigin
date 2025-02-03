<template>
    <v-select
        v-model="selectedCategory"
        :items="categories"
        label="انتخاب دسته‌بندی"
        item-title="name"
        item-value="id"
        @update:modelValue="filterByCategory"
    ></v-select>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const selectedCategory = ref(null);
const categories = ref([]);

const filterByCategory = () => {
    // ارسال دسته‌بندی انتخاب‌شده به والد
    emit("categorySelected", selectedCategory.value);
};

// دریافت دسته‌بندی‌ها از API هنگام لود شدن کامپوننت
onMounted(async () => {
    try {
        const response = await axios.get("/api/categories");
        categories.value = response.data;
    } catch (error) {
        console.error("خطا در دریافت دسته‌بندی‌ها:", error);
    }
});
</script>
