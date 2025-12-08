<script setup>
import {onMounted, ref} from "vue";
import ShippingService from "../../Services/ShippingService";
import ModalService from "../../Services/ModalService";
import ShippingModal from "./ShippingModal.vue";
import ShippingModel from "../../models/ShippingModel";

const shipments = ref([]);

const props  = defineProps({
    user: {type: Object, required: true},
    order: {type: Object, required: true}
})

const getShipments = () => {
    ShippingService.list(props.user).then((response) => {
        shipments.value = response.data.data.flat();
    })
};

const openShippingModal = (shipping = null, isEditing = false) => {
    ModalService.open({
        component: ShippingModal,
        props: {
            shipping: shipping ?? new ShippingModel(),
            user: props.user,
            isEditing: isEditing,
        },
    }).then(() => {
        getShipments();
    });
};

onMounted(() => {
    getShipments();
});
</script>

<template>
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6 lg:p-8 w-full">
        <div class="max-w-5xl mx-auto">
            <div class="mb-8 flex justify-between items-center">
                <button
                    @click="openShippingModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition-transform duration-200 hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Shipment
                </button>
            </div>
            <div v-if="shipments.length > 0" class="bg-white shadow-sm divide-y divide-slate-100">
                <div
                    v-for="shipment in shipments"
                    :key="shipment.id"
                    class="flex items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors"
                >
                    <div class="flex items-center gap-4">
                        <input
                            type="radio"
                            name="selectedShipping"
                            :value="shipment.id"
                            v-model="order.shipping"
                            class="h-4 w-4"
                        />
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ shipment.firstName }} {{ shipment.lastName }}
                                <span class="text-slate-500"> - {{ shipment.phoneNumber }}</span>
                            </p>
                            <p class="text-sm text-slate-600 mt-0.5">
                                {{ shipment.address }}, {{ shipment.city }}, {{ shipment.country }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <button
                            @click="openShippingModal(shipment, true)"
                            class="inline-flex items-center px-3 py-1.5 text-sm text-slate-600 hover:text-slate-800 border border-slate-200 rounded-lg hover:bg-slate-100 transition-colors"
                        >
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
             a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </button>
                    </div>
                </div>
            </div>
            <div v-else class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586
                       a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172
                       a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">No Shipments Yet</h3>
                    <p class="text-slate-600 mb-6">Get started by creating your first shipment</p>
                </div>
            </div>
        </div>
    </div>
</template>


<style scoped>

</style>
