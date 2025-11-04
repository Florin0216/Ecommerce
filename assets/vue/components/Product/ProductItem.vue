<script setup>
import FosJsRouting from "../../../js/fosJsRouting";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    }
})

const addToCart = (product) => {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    const existingProduct = cart.find(i => i.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += product.quantity;
    } else {
        cart.push(product);
    }

    localStorage.setItem('cart', JSON.stringify(cart));
}
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
        <a :href="FosJsRouting.generate('shop_product_show',{id: props.product.id})">
            <div class="relative overflow-hidden bg-gray-200 aspect-square">
                <img v-if="product.image"
                     :src="product.image"
                     :alt="product.name"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"/>
                <div v-else
                     class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>

            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem]">
                    {{ product.name }}
                </h3>

                <p v-if="product.description"
                   class="text-sm text-gray-600 mb-4 line-clamp-2">
                    {{ product.description }}
                </p>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ product.price }}
                                </span>
                    </div>

                    <div v-if="product.stock"
                         class="text-xs text-gray-500">
                        {{ product.stock }} in stock
                    </div>
                </div>

                <button @click="addToCart(product)"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                    <span>Add to Cart</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </button>
            </div>
        </a>
    </div>
</template>

<style scoped>

</style>
