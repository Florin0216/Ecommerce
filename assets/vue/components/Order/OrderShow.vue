<script setup>
import {computed, onMounted, ref, watch} from "vue";
import UserService from "../../Services/UserService";
import ShippingList from "../Shipping/ShippingList.vue";
import BillingList from "../Billing/BillingList.vue";
import StripeService from "../../Services/StripeService";
import OrderService from "../../Services/OrderService";
import OrderCreateDto from "../../dto/Order/OrderCreateDto";
import OrderItemService from "../../Services/OrderItemService";
import OrderItemCreateDto from "../../dto/OrderItem/OrderItemCreateDto";
import PaymentService from "../../Services/PaymentService";
import PaymentCreateDto from "../../dto/Payment/PaymentCreateDto";
import CartItemService from "../../Services/CartItemService";
import CartService from "../../Services/CartService";
import OrderSummary from "./OrderSummary.vue";
import DeliveryService from "../../Services/DeliveryService";
import {useCartStore} from "../../stores/useCartStore";

const cartItems = ref([]);
const order = ref({});
const step = ref(2);
const user = ref();
const paymentMethod = ref();
const deliveryOptions = ref({});
const cartStore = useCartStore();
const isLoading = ref(false);
const nextStep = () => {
    if (step.value < 3) step.value++;
};

const prevStep = () => {
    if (step.value > 2) step.value--;
};

const onConfirm = () => {
    isLoading.value = true;

    CartService.list(user.value.id)
        .then(cartResponse => CartItemService.list(cartResponse.data.data.id))
        .then(cartItemsResponse => {
            cartItems.value = cartItemsResponse.data.data;

            return PaymentService.new(new PaymentCreateDto({method: paymentMethod.value}));
        })
        .then(paymentResponse => {
            return OrderService.new(new OrderCreateDto({
                ...order.value,
                user: user.value.id,
                payment: paymentResponse.data.data.id,
                status: 'pending'
            }));
        })
        .then(orderResponse => {
            const itemPromises = cartItems.value.map(item =>
                OrderItemService.new(new OrderItemCreateDto({
                    quantity: item.quantity,
                    product: item.product.id,
                    order: orderResponse.data.data.id
                }))
            );
            return Promise.all(itemPromises);
        })
        .then(orderItemsResponses => {
            const deletePromises = cartItems.value.map(item => CartItemService.delete(item));
            return Promise.all(deletePromises).then(() => {
                localStorage.removeItem('cart');
                return orderItemsResponses.map(res => res.data.data);
            });
        })
        .then(orderItems => {
            if (paymentMethod.value === "card" && orderItems.length > 0) {
                return StripeService.new({
                    orderItems: orderItems,
                    delivery: selectedDeliveryOption.value
                }).then(stripeResponse => {
                    window.location.href = stripeResponse.data.url;
                });
            }
        })
        .finally(() => {
            isLoading.value = false;
        });
};


const selectedDeliveryOption = computed(() => {
    return deliveryOptions.value.find(d => d.id === order.value.delivery);
});

watch(cartStore.cart, () => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;

            return CartService.list(user.value.id);
        }).then((cartResponse) => {
        return CartItemService.list(cartResponse.data.data.id);
    })
        .then((cartItemsResponse) => {
            cartItems.value = cartItemsResponse.data.data;

            return DeliveryService.list();
        })
        .then((deliveryResponse) => {
            deliveryOptions.value = deliveryResponse.data.data;
        })
})

onMounted(() => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;

            return DeliveryService.list();
        })
        .then((deliveryResponse) => {
            deliveryOptions.value = deliveryResponse.data.data;
        })
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 py-8 px-4 sm:px-6 lg:p-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">Checkout</h1>
                <p class="text-gray-600">Complete your order in just a few steps</p>
            </div>
            <div class="mb-8">
                <div class="flex items-center justify-center px-4">
                    <div class="flex items-center w-full max-w-4xl">
                        <div class="flex items-center justify-center flex-col">
                            <div
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition-all duration-300 bg-blue-600 text-white z-10">
                                <span class="font-semibold">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-6 sm:h-6 text-white"
                                         fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                            </div>
                            <div
                                class="text-sm font-medium mt-3 md:mt-5 mb-10 md:mb-7 text-center justify-center leading-tight text-blue-600">
                                Checkout<br class="sm:hidden"> Cart
                            </div>
                        </div>
                        <div
                            class="flex-1 h-0.5 sm:h-1 -mx-4 sm:-ms-16 sm:-me-20 mb-auto mt-4 sm:mt-5 transition-all duration-300 bg-blue-600">
                        </div>
                        <div class="flex items-center  flex-col">
                            <div
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition-all duration-300 z-10"
                                :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'">
                            <span v-if="step > 2" class="font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-6 sm:h-6 text-white"
                                     fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            </div>
                            <div class="text-sm font-medium mt-4 text-center leading-tight mb-5 md:mb-8"
                                 :class="step >= 2 ? 'text-blue-600' : 'text-gray-500'">
                                Shipping,<br class="sm:hidden"> Billing &<br class="sm:hidden"> Payment
                            </div>
                        </div>
                        <div
                            class="flex-1 h-0.5 sm:h-1 -mx-5 sm:-ms-20 mb-auto mt-4 sm:mt-5 transition-all duration-300"
                            :class="step >= 3 ? 'bg-blue-600' : 'bg-gray-300'">
                        </div>
                        <div class="flex items-center flex-col">
                            <div
                                class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 rounded-full transition-all duration-300 z-10"
                                :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'">
                            </div>
                            <span class="text-sm font-medium mt-5 text-center leading-tight mb-12 md:mb-8"
                                  :class="step >= 3 ? 'text-blue-600' : 'text-gray-500'">Summary
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 sm:p-8 lg:p-10">
                    <div class="min-h-[400px]">
                        <div v-if="step === 2">
                            <div class="mb-10">
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Shipping Information</h2>
                                    <p class="text-gray-600 text-sm">Where should we deliver your order?</p>
                                </div>
                                <shipping-list v-if="user" :user="user" :order="order"></shipping-list>
                            </div>
                            <div class="mb-10">
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Billing Information</h2>
                                    <p class="text-gray-600 text-sm">Please provide your contact details</p>
                                </div>
                                <billing-list v-if="user" :user="user" :order="order"></billing-list>
                            </div>
                            <div>
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Information</h2>
                                    <p class="text-gray-600 text-sm mb-4">Please choose a payment method</p>
                                    <div
                                        class="bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6 lg:p-8 w-full">
                                        <div
                                            class="bg-white shadow-sm divide-y divide-slate-100 max-w-5xl mx-auto">
                                            <div class="flex items-center gap-4 px-6 py-4">
                                                <input
                                                    type="radio"
                                                    name="paymentMethod"
                                                    class="h-4 w-4"
                                                    value="card"
                                                    v-model="paymentMethod"
                                                />
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-800">
                                                        Pay Online (Card)
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-4 px-6 py-4">
                                                <input
                                                    type="radio"
                                                    name="paymentMethod"
                                                    class="h-4 w-4"
                                                    value="cash"
                                                    v-model="paymentMethod"
                                                />
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-800">
                                                        Pay on delivery
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="mb-6">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Delivery Options</h2>
                                    <p class="text-gray-600 text-sm mb-4">Please choose a delivery provider</p>
                                    <div
                                        class="bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-6 lg:p-8 w-full">
                                        <div v-for="delivery in deliveryOptions"
                                             :key="delivery.id"
                                             class="bg-white shadow-sm divide-y divide-slate-100 max-w-5xl mx-auto">
                                            <div class="flex items-center gap-4 px-6 py-4">
                                                <input
                                                    type="radio"
                                                    name="deliveryProvider"
                                                    class="h-4 w-4"
                                                    :value="delivery.id"
                                                    v-model="order.delivery"
                                                />
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-800">
                                                        {{ delivery.name }}
                                                        <span class="text-slate-500"> - ${{ delivery.price }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="step === 3">
                            <order-summary :cart-items="cartItems" :order="order"
                                           :delivery-option="selectedDeliveryOption"></order-summary>
                        </div>
                    </div>

                    <!--                    <div class="mt-8 pt-6 border-t border-gray-200">
                                            <div class="flex items-center justify-between text-lg font-semibold">
                                                <span class="text-gray-700">Total:</span>
                                                <span class="text-2xl text-blue-600">${{ cartStore.totalPrice?.toFixed(2) }}</span>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1 text-right">
                                                {{ cartStore.cart.length }} item(s) in cart
                                            </p>
                                        </div>-->
                </div>
                <div class="bg-gray-50 px-6 py-4 sm:px-8 sm:py-5 flex flex-col sm:flex-row gap-3 sm:justify-between">
                    <button
                        v-if="step > 2"
                        @click="prevStep"
                        class="w-full sm:w-auto px-6 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                    >
                        ← Back
                    </button>

                    <div class="sm:ml-auto flex gap-3">
                        <button
                            v-if="step < 3"
                            @click="nextStep"
                            class="w-full sm:w-auto px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            Next →
                        </button>

                        <button
                            v-if="step === 3"
                            @click="onConfirm"
                            class="w-full sm:w-auto px-8 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                        >
                            ✓ Confirm Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
