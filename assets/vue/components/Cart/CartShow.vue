<script setup>
import {onMounted, ref} from "vue";
import FosJsRouting from "../../../js/fosJsRouting";
import {useCartStore} from "../../stores/useCartStore";
import UserService from "../../Services/UserService";
import CartService from "../../Services/CartService";
import CartItemService from "../../Services/CartItemService";
import CartItemEditDto from "../../dto/CartItem/CartItemEditDto";

const cartItems = ref([]);
const cartStore = useCartStore();
const user = ref(null);

const getCartItems = () => {
    cartItems.value = cartStore.cart;
}

const updateCart = () => {
    localStorage.setItem('cart', JSON.stringify(cartItems.value));
};

const addToQuantity = (index) => {
    if (cartItems.value[index].quantity <= cartItems.value[index].product.stock) {
        cartItems.value[index].quantity++;
    }

    if (user.value) {
        CartService
            .list(user.value.id)
            .then((cartResponse) => {
                CartItemService.list(cartResponse.data.data.id).then(cartItemsResponse => {
                    const existingItem = cartItemsResponse.data.data.find(item => item.product.id === cartItems.value[index].product.id);
                    CartItemService.edit(existingItem.id, new CartItemEditDto({
                        quantity: cartItems.value[index].quantity,
                        product: existingItem.product.id,
                        cart: cartResponse.data.data.id,
                    }))
                })
            })
    }
    updateCart();
}


const removeFromQuantity = (index) => {
    if (cartItems.value[index].quantity > 1) {
        cartItems.value[index].quantity--;
    }

    if (user.value) {
        CartService
            .list(user.value.id)
            .then((cartResponse) => {
                CartItemService.list(cartResponse.data.data.id).then(cartItemsResponse => {
                    const existingItem = cartItemsResponse.data.data.find(item => item.product.id === cartItems.value[index].product.id);
                    CartItemService.edit(existingItem.id, new CartItemEditDto({
                        quantity: cartItems.value[index].quantity,
                        product: existingItem.product.id,
                        cart: cartResponse.data.data.id,
                    }))
                })
            })
    }
    updateCart();
}

const removeItem = (index) => {
    if (user.value) {
        CartService
            .list(user.value.id)
            .then((cartResponse) => {
                CartItemService.list(cartResponse.data.data.id).then(cartItemsResponse => {
                    const existingItem = cartItemsResponse.data.data.find(item => item.product.id === cartItems.value[index].product.id);
                    CartItemService.delete(existingItem).then(() => {
                        cartItems.value.splice(index, 1);
                        updateCart();
                    })
                })
            })
    } else {
        cartItems.value.splice(index, 1);
        updateCart();
    }
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
    <div class="min-h-screen bg-slate-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-xl p-6 sm:p-8 lg:p-12 space-y-6">

            <h1 class="text-3xl font-bold text-slate-900 mb-6">Summary</h1>

            <div v-if="cartItems?.length" class="space-y-4">
                <div v-for="(item, id) in cartItems" :key="id"
                     class="flex flex-col sm:flex-row items-center gap-4 p-4 bg-slate-50 rounded-xl">

                    <div class="w-24 h-24 bg-white rounded-xl shadow flex items-center justify-center overflow-hidden">
                        <img :src="item.image" alt="" class="object-cover w-full h-full">
                    </div>

                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-slate-900">{{ item.product.name }}</h2>
                        <p class="text-sm text-slate-500">Provider: {{ item.product.provider }}</p>
                        <p class="text-sm text-slate-500">Price: ${{ item.product.price }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="removeFromQuantity(id)"
                                class="w-8 h-8 rounded-lg border border-slate-300 hover:bg-slate-200">−
                        </button>
                        <span class="w-8 text-center font-semibold">{{ item.quantity }}</span>
                        <button @click="addToQuantity(id)"
                                class="w-8 h-8 rounded-lg border border-slate-300 hover:bg-slate-200">+
                        </button>
                    </div>

                    <button @click="removeItem(id)" class="text-red-600 font-semibold hover:underline">
                        Remove
                    </button>

                    <div class="text-lg font-bold text-slate-900">
                        ${{ (item.product.price * item.quantity).toFixed(2) }}
                    </div>

                </div>

                <div class="flex justify-between items-center pt-6 border-t border-slate-200">
                    <span class="text-xl font-semibold text-slate-700">Total</span>
                    <span class="text-2xl font-bold text-slate-900">${{ cartStore.totalPrice.toFixed(2) }}</span>
                </div>
                <div class="text-center">
                    <a :href="FosJsRouting.generate('shop_order_show')"
                       class="w-full bg-slate-900 text-white p-4 rounded-xl font-semibold hover:bg-slate-800 transition-all shadow-lg">
                        Proceed to Checkout
                    </a>
                </div>

            </div>

            <div v-else class="text-center text-slate-500">
                Your cart is empty.
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
