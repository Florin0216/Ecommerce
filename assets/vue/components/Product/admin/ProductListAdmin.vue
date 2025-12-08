<script setup>
import {onMounted, ref} from "vue";
import ProductService from "../../../Services/ProductService";
import ProductModal from "./ProductModal.vue";
import ModalService from "../../../Services/ModalService";
import ProductModel from "../../../models/ProductModel";
import ToastService from "../../../Services/ToastService";

const products = ref([]);

const getProducts = () => {
    ProductService.listAdmin().then((response) => {
        products.value = response.data.data;
    });
};

const openProductModal = (product = null, isEditing = false) => {
    ModalService.open({
        component: ProductModal,
        props: {
            product: product ?? new ProductModel(),
            isEditing: isEditing,
        },
    }).then(() => {
        getProducts();
    });
};

const onDelete = (product) => {
    ProductService.deleteAdmin(product).then(() => {
        const index = products.value.findIndex((p) => p.id === product.id);
        if (index !== -1) {
            products.value.splice(index, 1);
        }
        ToastService.show("Product deleted successfully!", "success");
    });
};

onMounted(() => {
    getProducts();
});
</script>

<template>
    <div class="min-h-screen bg-gray-50 p-4 md:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">
                            Products
                        </h1>
                        <p class="text-slate-600">
                            Manage your products
                        </p>
                    </div>
                    <button
                        @click="openProductModal()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="w-full sm:w-96">
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Search products..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="products.length" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow overflow-hidden"
                >
                    <div class="aspect-square bg-gray-100 relative">
                        <img
                            v-if="product.image"
                            :src="product.image"
                            :alt="product.name"
                            class="w-full h-full object-cover"
                        >
                        <div v-else class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span
                            :class="[
                                'absolute top-2 right-2 px-2 py-1 rounded-full text-xs font-medium',
                                product.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                            ]"
                        >
                            {{ product.status }}
                        </span>
                    </div>

                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 truncate">{{ product.name }}</h3>
                        <p class="text-sm text-gray-500 mb-2">{{ product.category }}</p>

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-bold text-gray-900">${{ product.price }}</span>
                            <span class="text-sm text-gray-600">Stock: {{ product.stock }}</span>
                        </div>

                        <div class="flex gap-2">
                            <button
                                @click="openProductModal(product, true)"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors flex items-center justify-center gap-1"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </button>
                            <button
                                @click="onDelete(product)"
                                class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg font-medium transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
                <p class="text-gray-500 mb-4">Get started by adding your first product</p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
