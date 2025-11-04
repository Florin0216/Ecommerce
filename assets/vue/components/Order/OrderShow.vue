<script setup>
import {computed, onMounted, ref} from "vue";
import OrderService from "../../Services/OrderService";
import OrderCreateDto from "../../dto/Order/OrderCreateDto";
import OrderItemService from "../../Services/OrderItemService";
import OrderItemCreateDto from "../../dto/OrderItem/OrderItemCreateDto";
import UserService from "../../Services/UserService";

const cartItems = ref([]);
const user = ref(null);
const order = ref({});

const getCartItems = () => {
    cartItems.value = JSON.parse(localStorage.getItem('cart'));
}

const totalPrice = computed(() => {
    return cartItems.value?.reduce((sum, item) => {
        return sum + item.product.price * item.quantity;
    }, 0);
});

const onConfirm = () => {
    OrderService
        .new(new OrderCreateDto({
            ...order.value,
            total: totalPrice.value,
            user: user.value.id
        }))
        .then((response) => {
            const itemPromises = cartItems.value.map((item) => {
                return OrderItemService.new(
                    new OrderItemCreateDto({
                        quantity: item.quantity,
                        product: item.product.id,
                        order: response.data?.data.id,
                    })
                );
            });

            return Promise.all(itemPromises);
        })
        .then(() => {
            localStorage.removeItem("cart");
            cartItems.value = [];
        })
};

onMounted(() => {
    getCartItems();
    UserService
        .list()
        .then((response) => {
            user.value = response.data.data;
        })
})
</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">
            <div class="p-8 lg:p-10 space-y-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
                    <p class="text-gray-600">Complete your order below</p>
                </div>

                <form @submit.prevent="onConfirm" class="space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3">Shipping Information</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input v-model="order.firstName" type="text" placeholder="First Name" class="input"
                                   name="firstName"/>
                            <input v-model="order.lastName" type="text" placeholder="Last Name" class="input"
                                   name="lastName"/>
                            <input v-model="order.email" type="email" placeholder="Email Address"
                                   class="input sm:col-span-2" name="email"/>
                            <input v-model="order.address" type="text" placeholder="Street Address"
                                   class="input sm:col-span-2" name="address"/>
                            <input v-model="order.city" type="text" placeholder="City" class="input" name="city"/>
                            <input v-model="order.country" type="text" placeholder="Country" class="input"
                                   name="country"/>
                            <input v-model="order.postalCode" type="text" placeholder="Postal Code"
                                   class="input sm:col-span-2" name="postalCode"/>
                            <input v-model="order.phoneNumber" type="tel" placeholder="Phone Number"
                                   class="input sm:col-span-2" name="phoneNumber"/>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition duration-200 transform hover:scale-105"
                    >
                        Complete Purchase
                    </button>
                </form>
            </div>

            <div v-if="cartItems?.length"
                 class="bg-gray-50 p-8 lg:p-10 border-t lg:border-t-0 lg:border-l border-gray-200 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Order Summary</h2>
                    <div class="space-y-4">
                        <div v-for="(item, id) in cartItems" :key="id" class="flex justify-between text-gray-700">
                            <span>{{ item.product.name }}</span>
                            <span>{{ item.quantity }} x {{ item.product.price }}</span>
                        </div>

                        <hr class="my-4"/>

                        <div class="flex justify-between text-lg font-semibold text-gray-900">
                            <span>Total</span>
                            <span>{{ totalPrice.toFixed(2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10 text-center text-gray-500 text-sm">
                    <p>Secure payment powered by <span class="text-indigo-600 font-medium">Stripe</span></p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
