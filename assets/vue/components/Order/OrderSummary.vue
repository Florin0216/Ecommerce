<script setup>
import {useCartStore} from "../../stores/useCartStore";
import {computed, watch} from "vue";

const props = defineProps({
    cartItems: {
        type: Array,
        required: true
    },
    order: {
        type: Object,
        required: true
    },
    deliveryOption: {
        type: Number,
        required: true
    }
});

const cartStore = useCartStore();

const total = computed(() => {
    return cartStore.totalPrice + props.deliveryOption.price ;
});

watch(total, () => {
    props.order.total = total;
}, { immediate: true });
</script>

<template>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Order Summary</h2>
            <p class="text-gray-600">Review your order before confirming</p>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-4 md:p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                Order Items ({{ props.cartItems.length }})
            </h3>

            <div class="space-y-4">
                <div
                    v-for="(item, index) in cartStore.cart"
                    :key="index"
                    class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200"
                >
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-full sm:w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <h4 class="text-base font-semibold text-gray-900 mb-1 truncate">
                                {{ item.product.name }}
                            </h4>
                            <div class="flex items-center gap-4 text-sm">
                                <span class="text-gray-600">
                                    Qty: <span class="font-semibold text-gray-900">{{ item.quantity }}</span>
                                </span>
                                <span class="text-gray-400">•</span>
                                <span class="text-gray-600">
                                    Unit Price: <span class="font-semibold text-gray-900">${{ item.product.price.toFixed(2) }}</span>
                                </span>
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center">
                            <span class="text-sm text-gray-600 sm:hidden">Item Total:</span>
                            <span class="text-lg font-bold text-blue-600">
                                ${{ (item.product.price * item.quantity).toFixed(2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Payment Details
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-900 font-semibold">${{ cartStore.totalPrice.toFixed(2) }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-gray-200">
                    <div class="flex flex-col">
                        <span class="text-gray-600">Shipping Fee</span>
                    </div>
                    <span v-if="deliveryOption.price > 0" class="text-gray-900 font-semibold">${{ props.deliveryOption.price }}</span>
                    <span v-else class="text-green-700 font-semibold"> FREE </span>
                </div>
                <div class="flex justify-between items-center pt-2">
                    <span class="text-xl font-bold text-gray-900">Total</span>
                    <span class="text-2xl md:text-3xl font-bold text-blue-600">${{ total }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
