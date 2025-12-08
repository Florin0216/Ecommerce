<script setup>
const props = defineProps({
    order: {
        type: Object,
        required: true
    },
    orderItems: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-8 animate-fade-in">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-emerald-100 rounded-full mb-4 animate-scale-in">
                    <svg class="w-12 h-12 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">
                    Order Confirmed!
                </h1>
                <p class="text-lg text-gray-600">
                    Thank you for your purchase.
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-6 border">
                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-200">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Order Details</h2>
                        <p class="text-sm text-gray-500">{{
                                new Date(props.order.createdAt + 'Z').toLocaleString('ro-RO', {
                                    timeZone: 'Europe/Bucharest',
                                    dateStyle: 'medium',
                                    timeStyle: 'short'
                                })
                            }}</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Order Number</p>
                        <p class="font-semibold text-gray-900">{{ }}</p>
                    </div>
                </div>
                <div class="space-y-3 mb-6 pb-6 border-b border-gray-200">
                    <div v-for="(item, index) in props.orderItems" :key="index"
                         class="flex justify-between items-start">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900">{{ item.product.name }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ item.quantity }}</p>
                        </div>
                        <p class="font-semibold text-gray-900">${{ item.product.price }}</p>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <p class="text-lg font-semibold text-gray-900">Total</p>
                    <p class="text-2xl font-bold text-emerald-600">${{ props.order.total }}</p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
