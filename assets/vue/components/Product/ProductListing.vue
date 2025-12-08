<script setup>
import {onMounted, ref} from "vue";
import ProductItem from "./ProductItem.vue";
import UserService from "../../Services/UserService";

const user = ref();

const props = defineProps({
    products: {
        type: Array,
        required: true
    }
})


onMounted(() => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;
        })
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Our Products</h1>
            </div>

            <div v-if="props.products.length"
                 class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <div v-for="product in props.products" :key="product.id">
                    <ProductItem :product="product" :user="user"></ProductItem>
                </div>
            </div>
            <div v-else class="text-center py-20">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-600">Check back later for new products</p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
