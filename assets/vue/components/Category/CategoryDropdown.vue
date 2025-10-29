<script setup>
import {onMounted, ref} from "vue";
import CategoryService from "../../Services/CategoryService";
import FosJsRouting from "../../../js/fosJsRouting";

const categories = ref([]);

const getCategories = () => {
    CategoryService.categoriesList().then((response) => {
        categories.value = response.data.data;
    });
};

onMounted(() => {
    getCategories();
});
</script>

<template>
    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="hidden lg:flex items-center hover:text-yellow-300 lg:duration-300 py-2 px-3 rounded-lg hover:bg-gray-800 transition-all" type="button">Categories<svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
    </svg>
    </button>

    <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <template
                v-for="category in categories"
                :key="category.id">
                <li>
                    <a :href="FosJsRouting.generate('shop_product_list',{id: category.id})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"> {{ category.name }}</a>
                </li>
            </template>
        </ul>
    </div>

    <div class="z-10 block lg:hidden bg-gray-800 font-medium text-lg divide-gray-100 rounded-lg">
        <ul class="text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
            <template
                v-for="category in categories"
                :key="category.id">
                <li>
                    <a :href="FosJsRouting.generate('shop_product_list',{id: category.id})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"> {{ category.name }}</a>
                </li>
            </template>
        </ul>
    </div>

</template>

<style scoped>

</style>
