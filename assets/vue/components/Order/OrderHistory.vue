<script setup>
import {onMounted, ref} from "vue";
import UserService from "../../Services/UserService";
import OrderService from "../../Services/OrderService";
import OrderItemHistory from "./OrderItemHistory.vue";

const user = ref();
const orders = ref();

const getOrders = () => {
    OrderService
        .list(user.value)
        .then((response) => {
            orders.value = response.data.data;
        })
}

onMounted(() => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;
        })
        .then(() => {
            getOrders();
        })
})
</script>

<template>
    <div class="min-h-screen bg-white p-4 sm:p-6 lg:p-8 max-w-5xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Orders</h1>
        </header>

        <div v-if="orders && orders.length" class="space-y-6 ">
            <div
                v-for="order in orders"
                :key="order.id"
                class="bg-white rounded-lg shadow-xl border border-gray-100 overflow-hidden
                       hover:shadow-2xl transition-shadow duration-300"
            >
                <div class="bg-gray-50 p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Order #{{ order.id }}</h3>

                    <span
                        class="px-3 py-1 text-xs font-semibold uppercase tracking-wide rounded-full"
                        :class="{
                            'bg-green-100 text-green-800': order.status === 'completed',
                            'bg-yellow-100 text-yellow-800': order.status === 'pending',
                            'bg-red-100 text-red-800': order.status === 'cancelled'
                        }"
                    >
                        {{ order.status }}
                    </span>
                </div>
                <div class="p-4 sm:p-6 flex flex-col lg:flex-row gap-4 sm:gap-6 items-start">
                    <div class="w-full">
                        <order-item-history :order="order"></order-item-history>
                    </div>
                </div>
                <div class="p-4 sm:p-6 pt-3 flex flex-col sm:flex-row justify-between gap-4 border-t">
                    <div class="flex justify-start gap-2 flex-shrink-0">
                        <div class="font-medium text-gray-500 text-sm uppercase">ORDER DATE:</div>
                        <div class="text-gray-900 font-semibold text-sm">
                            {{
                                new Date(order.createdAt + 'Z').toLocaleDateString('en-US', {
                                    dateStyle: 'medium',
                                })
                            }}
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 w-full sm:w-auto">

                        <button
                            @click="viewOrderDetails(order.id)"
                            class="w-full sm:w-auto px-4 py-2 text-blue-600 border border-blue-600 rounded-md text-sm font-medium
                   hover:bg-blue-50 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                            View Details
                        </button>

                        <button
                            @click="cancelOrder(order.id)"
                            :disabled="order.status !== 'pending'"
                            class="w-full sm:w-auto px-4 py-2 text-red-600 border border-red-600 rounded-md text-sm font-medium
                   hover:bg-red-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed
                   focus:outline-none focus:ring-2 focus:ring-red-500"
                        >
                            Cancel Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="orders && !orders.length" class="text-center py-20 bg-gray-50 rounded-xl shadow-lg">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                 aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h2 class="mt-2 text-xl font-semibold text-gray-900">No Orders Found</h2>
            <p class="mt-1 text-sm text-gray-500">You haven’t placed any orders yet. Time to explore!</p>
        </div>
    </div>
</template>

<style scoped>

</style>
