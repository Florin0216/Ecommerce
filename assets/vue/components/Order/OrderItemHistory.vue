<script setup>
import {onMounted, ref} from "vue";
import OrderItemService from "../../Services/OrderItemService";

const props = defineProps({
    order: {
        type: Object,
        required: true
    }
})

const orderItems = ref();

const getOrderItems = () => {
    OrderItemService
        .list(props.order)
        .then((response) => {
            orderItems.value = response.data.data;
        })
}

onMounted(() => {
    getOrderItems();
})
</script>

<template>
    <div class="flex space-x-3 overflow-x-auto p-2 -m-2 scrollbar-hide">
        <div
            v-for="item in orderItems"
            :key="item.id"
            class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden
                   hover:shadow-md transition-shadow duration-200 cursor-pointer group"
        >
            <div class="w-full h-full flex items-center justify-center bg-gray-100 relative">
                <span class="text-xs text-gray-500 text-center p-1 leading-tight">
                    {{ item.name || 'Product ' + item.id }}
                </span>
            </div>

            <span class="absolute top-0 right-0 mt-1 mr-1 px-1.5 py-0.5 text-xs font-bold text-white bg-black/60 rounded-full">
                x{{ item.quantity }}
            </span>
        </div>

        <div v-if="!orderItems || orderItems.length === 0" class="flex-shrink-0 w-24 h-24 sm:w-28 sm:h-28 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs">
            No Items
        </div>
    </div>
</template>

<style scoped>

</style>
