<script setup>
import {computed, ref} from "vue";
import ToastService from "../../Services/ToastService";
import BillingService from "../../Services/BillingService";
import BillingCreateDto from "../../dto/Billing/BillingCreateDto";
import BillingEditDto from "../../dto/Billing/BillingEditDto";

const props = defineProps({
    instance: {type: Object, required: true},
    billing: {type: Object, required: true},
    user: {type: Object, required: true},
    isEditing: {type: Boolean, default: false},
});


const billing = ref(JSON.parse(JSON.stringify(props.billing)));

const isNewBilling = computed(() => !billing.value.id);

const onConfirm = () => {
    const promise = isNewBilling.value
        ? BillingService.new(new BillingCreateDto({
            ...billing.value,
            user: props.user.id
        }))
        : BillingService.edit(billing.value.id, new BillingEditDto(billing.value));

    promise
        .then((response) => {
            billing.value = response.data.data;
            props.isEditing = false;

            ToastService.show(
                isNewBilling.value
                    ? "Billing details created successfully!"
                    : "Billing details updated successfully!",
                "success"
            );

            props.instance.value.close(true);
        })
        .catch((err) => {
            console.error(err);
        });
};

const dismissModal = () => {
    props.instance.value.close(undefined);
};
</script>

<template>
    <div
        id="modalEl"
        tabindex="-1"
        aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
           justify-center items-center md:inset-0 w-full h-[calc(100%-1rem)] min-h-full
           bg-black/60 transition-transform duration-600 ease-in-out"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-400">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <template v-if="isNewBilling">Add billing</template>
                        <template v-else>Billing details</template>
                    </h3>
                    <button
                        @click="dismissModal"
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                   rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                    </button>
                </div>

                <div class="p-4 md:p-5 space-y-4">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="shippingFirstName" class="block text-sm font-medium text-gray-700 mb-2">First
                                    Name</label>
                                <input
                                    id="shippingFirstName"
                                    v-model="billing.firstName"
                                    type="text"
                                    placeholder="John"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                            <div>
                                <label for="shippingLastName" class="block text-sm font-medium text-gray-700 mb-2">Last
                                    Name</label>
                                <input
                                    id="shippingLastName"
                                    v-model="billing.lastName"
                                    type="text"
                                    placeholder="Doe"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                        </div>

                        <div>
                            <label for="shippingAddress" class="block text-sm font-medium text-gray-700 mb-2">Street
                                Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <input
                                    id="shippingAddress"
                                    v-model="billing.address"
                                    type="text"
                                    placeholder="123 Main Street, Apt 4B"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="shippingCity" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input
                                    id="shippingCity"
                                    v-model="billing.city"
                                    type="text"
                                    placeholder="New York"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                            <div>
                                <label for="shippingCountry"
                                       class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <input
                                    id="shippingCountry"
                                    v-model="billing.country"
                                    type="text"
                                    placeholder="United States"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="shippingPostalCode" class="block text-sm font-medium text-gray-700 mb-2">Postal
                                    Code</label>
                                <input
                                    id="shippingPostalCode"
                                    v-model="billing.postalCode"
                                    type="text"
                                    placeholder="10001"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                            <div>
                                <label for="shippingPhoneNumber" class="block text-sm font-medium text-gray-700 mb-2">Phone
                                    Number</label>
                                <input
                                    id="shippingPhoneNumber"
                                    v-model="billing.phoneNumber"
                                    type="tel"
                                    placeholder="07312321"
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 placeholder-gray-400"
                                />
                            </div>
                        </div>

                        <div class="flex justify-center items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                            <button
                                @click.prevent="onConfirm"
                                type="button"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                       focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
                       dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                <template v-if="isNewBilling">Add</template>
                                <template v-else>Edit</template>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
