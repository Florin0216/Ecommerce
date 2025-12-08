<script setup>
import {onMounted, ref} from "vue";
import OrderService from "../../../Services/OrderService";

const orders = ref([]);

const getOrders = () => {
    OrderService.listAdmin().then((response) => {
        orders.value = response.data.data;
    });
};

onMounted(() => {
    getOrders();
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-8">
        <div class="max-w-full ml-0 md:ml-14 lg:ml-56 transition-all duration-300">
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">
                            Orders
                        </h1>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div v-if="orders.length > 0" class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                ID
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                Total
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                                User
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                                Created At
                            </th>
                            <th class="px-3 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="order in orders"
                            :key="order.id"
                            class="hover:bg-slate-50 transition-colors duration-150"
                        >
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-slate-900">
                                        #{{ order.id }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-3 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">
                                    ${{ order.total.toFixed(2) }}
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <div class="text-sm text-slate-600 max-w-xs truncate">
                                    {{ order.user.firstName }} {{ order.user.lastName }}
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <div class="text-sm text-slate-600 max-w-xs truncate">
                                    {{ order.status }}
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <div class="text-sm text-slate-600 max-w-xs truncate">
                                    {{
                                        new Date(order.createdAt + 'Z').toLocaleDateString('en-US', {
                                            dateStyle: 'medium',
                                        })
                                    }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        class="inline-flex items-center px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors duration-200"
                                        title="Edit"
                                    >
                                        <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="hidden md:inline">Edit</span>
                                    </button>
                                    <button
                                        class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-lg transition-colors duration-200"
                                        title="Delete"
                                    >
                                        <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden md:inline">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="p-8 md:p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <h3 class="text-lg md:text-xl font-semibold text-slate-800 mb-2">
                            No orders yet
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
