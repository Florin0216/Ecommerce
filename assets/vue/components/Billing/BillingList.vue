<script setup>
import {onMounted, ref, watch} from "vue";
import ModalService from "../../Services/ModalService";
import BillingService from "../../Services/BillingService";
import BillingModel from "../../models/BillingModel";
import BillingModal from "./BillingModal.vue";
import ShippingService from "../../Services/ShippingService";
import BillingCreateDto from "../../dto/Billing/BillingCreateDto";

const billings = ref([]);
const asShipping = ref(false);

const props = defineProps({
    user: {type: Object, required: true},
    order: {type: Object, required: true}
})

const getBillings = () => {
    BillingService.list(props.user).then((response) => {
        billings.value = response.data.data.flat();
    })
};

const openBillingModal = (billing = null, isEditing = false) => {
    ModalService.open({
        component: BillingModal,
        props: {
            billing: billing ?? new BillingModel(),
            user: props.user,
            isEditing: isEditing,
        },
    }).then(() => {
        getBillings();
    });
};

watch(asShipping, (newVal) => {
    if (newVal === true && props.order.shipping) {
        ShippingService.listShipping(props.order.shipping)
            .then((response) => {
                const shippingData = response.data.data;

                return BillingService.list(props.user).then((billingResponse) => {
                    const existingBillings = billingResponse.data.data;

                    const billingExists = existingBillings.find(b =>
                        b.firstName === shippingData.firstName &&
                        b.lastName === shippingData.lastName &&
                        b.address === shippingData.address &&
                        b.city === shippingData.city &&
                        b.postalCode === shippingData.postalCode
                    );

                    if (billingExists) {
                        props.order.billing = billingExists.id
                        return null;
                    }

                    return BillingService.new(new BillingCreateDto({
                        firstName: shippingData.firstName,
                        lastName: shippingData.lastName,
                        phoneNumber: shippingData.phoneNumber,
                        address: shippingData.address,
                        city: shippingData.city,
                        country: shippingData.country,
                        postalCode: shippingData.postalCode,
                        user: props.user.id
                    }));
                })
            })
            .then(() => {
                getBillings();
            })
    } else {
        props.order.billing = null;
    }
})

onMounted(() => {
    getBillings();
});
</script>

<template>
    <div class="bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6 lg:p-8 w-full">
        <div class="max-w-5xl mx-auto">
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 shadow-sm">
                <label class="flex items-center cursor-pointer">
                    <input
                        type="checkbox"
                        v-model="asShipping"
                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                    >
                    <span class="ml-3 text-sm font-medium text-gray-900">
                        Use shipping address as billing address
                    </span>
                </label>
                <p class="mt-1 ml-8 text-xs text-gray-600">
                    Your shipping information will be used for billing
                </p>
            </div>

            <div v-if="!asShipping" class="mb-8 flex justify-between items-center">
                <button
                    @click="openBillingModal()"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md transition-transform duration-200 hover:scale-105"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Billing Address
                </button>
            </div>

            <div v-if="!asShipping && billings.length" class="bg-white shadow-sm divide-y divide-slate-100">
                <div
                    v-for="billing in billings"
                    :key="billing.id"
                    class="flex flex-col sm:flex-row sm:items-center justify-between px-6 py-4 hover:bg-slate-50 transition-colors"
                >
                    <div class="flex items-center gap-4">
                        <input
                            type="radio"
                            name="selectedBilling"
                            :value="billing.id"
                            v-model="order.billing"
                            class="h-4 w-4"
                        />
                        <div>
                            <p class="text-sm font-semibold text-slate-800">
                                {{ billing.firstName }} {{ billing.lastName }}
                                <span class="text-slate-500"> - {{ billing.phoneNumber }}</span>
                            </p>
                            <p class="text-sm text-slate-600 mt-0.5">
                                {{ billing.address }}, {{ billing.city }}, {{ billing.country }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <button
                            @click="openBillingModal(billing, true)"
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

            <div v-if="!asShipping && billings.length === 0" class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">No Billing Addresses Yet</h3>
                    <p class="text-slate-600 mb-6">Get started by creating your first billing address</p>
                </div>
            </div>

            <div v-if="asShipping" class="bg-white rounded-xl shadow-md p-12 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-800 mb-2">Billing address set to shipping address</h3>
                    <p class="text-slate-600">Your shipping information will be used for billing purposes</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
