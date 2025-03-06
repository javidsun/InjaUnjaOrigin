<template>
  <v-breadcrumbs class="breadcrumb">
    <v-breadcrumbs-item>Home</v-breadcrumbs-item>
    <v-breadcrumbs-item>Category</v-breadcrumbs-item>
    <v-breadcrumbs-item class="v-breadcrumbs__item--current1"></v-breadcrumbs-item>
  </v-breadcrumbs>
</template>

<script setup>
</script>

<style >
.breadcrumb {
  border: 1px solid #4CAF50;
  border-radius: 20px;
  padding: 5px 15px;
  background-color: darkseagreen;
  font-size: 10px;

}

.v-breadcrumbs__item--current1 {
  color: #A5B68D;
}
</style>
