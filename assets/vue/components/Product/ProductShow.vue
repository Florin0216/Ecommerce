<script setup>
import {onMounted, ref} from "vue";
import {useCartStore} from "../../stores/useCartStore";
import UserService from "../../Services/UserService";
import CartService from "../../Services/CartService";
import CartItemService from "../../Services/CartItemService";
import CartItemCreateDto from "../../dto/CartItem/CartItemCreateDto";
import CartItemEditDto from "../../dto/CartItem/CartItemEditDto";
import {useWishlistStore} from "../../stores/useWishlistStore";
import WishlistService from "../../Services/WishlistService";
import WishlistItemService from "../../Services/WishlistItemService";
import WishlistItemCreateDto from "../../dto/WishlistItem/WishlistItemCreateDto";
import ReviewsList from "../Review/ReviewsList.vue";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    }
})

const quantity = ref(0);
const cartStore = useCartStore();
const wishlistStore = useWishlistStore();
const user = ref(null);


const addToQuantity = () => {
    if (quantity.value <= props.product?.stock) {
        quantity.value++;
    }
}

const removeFromQuantity = () => {
    if (quantity.value > 0) {
        quantity.value--;
    }
}

const addToCart = (product) => {
    const existingProduct = cartStore.cart.find(i => i.product.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += quantity.value;
    } else {
        cartStore.cart.push({
            product: product,
            quantity: quantity.value,
        });
    }
    localStorage.setItem('cart', JSON.stringify(cartStore.cart));

    if (user.value) {
        CartService
            .list(user.value.id)
            .then((cartResponse) => {
                CartItemService.list(cartResponse.data.data.id)
                    .then(cartItemsResponse => {
                        const existingItem = cartItemsResponse.data.data.find(item => item.product.id === product.id);

                        if (existingItem) {
                            CartItemService.edit(existingItem.id, new CartItemEditDto({
                                quantity: existingItem.quantity + quantity.value,
                                product: product.id,
                                cart: cartResponse.data.data.id,
                            }))
                        } else {
                            CartItemService.new(
                                new CartItemCreateDto({
                                    quantity: quantity.value,
                                    product: product.id,
                                    cart: cartResponse.data.data.id,
                                })
                            )
                        }
                        quantity.value = 0;
                    });
            })
    } else {
        quantity.value = 0;
    }
}

const addToWishlist = (product) => {
    const existingProduct = wishlistStore.wishlist.find(i => i.product.id === product.id);
    if (!existingProduct) {
        wishlistStore.wishlist.push({
            product: product,
        });
    }
    localStorage.setItem('wishlist', JSON.stringify(wishlistStore.wishlist));

    if (user.value) {
        WishlistService
            .list(user.value.id)
            .then((wishlistResponse) => {
                WishlistItemService.list(wishlistResponse.data.data.id)
                    .then(wishlistItemsResponse => {
                        const existingItem = wishlistItemsResponse.data.data.find(item => item.product.id === product.id);

                        if (!existingItem) {
                            WishlistService.new(
                                new WishlistItemCreateDto({
                                    product: product.id,
                                    wishlist: wishlistResponse.data.data.id,
                                })
                            )
                        }
                    });
            })
    }
}

onMounted(() => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;
        })
})
</script>

<template>
    <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-8 p-6 sm:p-8 lg:p-12">
                    <div class="space-y-6">
                        <div
                            class="relative aspect-square rounded-2xl overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center group">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10"></div>
                            <div class="relative z-10 text-center p-8">
                                <div
                                    class="w-32 h-32 mx-auto mb-6 bg-white rounded-full shadow-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <p class="text-slate-500 text-sm">{{ product.name }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-slate-50 rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 uppercase">Provider</span>
                                </div>
                                <p class="text-sm font-bold text-slate-900">{{ product.provider }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 uppercase">Delivery</span>
                                </div>
                                <p class="text-sm font-bold text-slate-900">{{ product.delivery }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col space-y-6">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span :class="['px-3 py-1 rounded-full text-xs font-medium']">
                                </span>
                            </div>

                            <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
                                {{ product.name }}
                            </h1>
                            <div v-if="product.categories && product.categories.length"
                                 class="flex flex-wrap gap-2 mb-4">
                                <button
                                    v-for="(category, idx) in product.categories"
                                    :key="category.id"
                                >
                                    {{ category.name }}
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-900 mb-3">
                                Quantity
                            </label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-3">
                                    <button @click="removeFromQuantity"
                                            class="w-11 h-11 rounded-lg border-2 border-slate-200 hover:border-slate-400 transition-colors font-semibold disabled:opacity-40 disabled:cursor-not-allowed"
                                    >
                                        −
                                    </button>
                                    <span class="w-12 text-center font-semibold text-lg"> {{ quantity }} </span>
                                    <button @click="addToQuantity"
                                            class="w-11 h-11 rounded-lg border-2 border-slate-200 hover:border-slate-400 transition-colors font-semibold disabled:opacity-40 disabled:cursor-not-allowed"
                                    >
                                        +
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button @click="addToCart(props.product)"
                                    class="flex-1 bg-slate-900 text-white py-4 rounded-xl font-semibold hover:bg-slate-800 transition-all flex items-center justify-center gap-2 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add to Cart
                            </button>
                            <button @click="addToWishlist(props.product)"
                                    class="px-8 py-4 border-2 border-slate-900 rounded-xl font-semibold hover:border-red-500 hover:text-red-500 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                                </svg>
                            </button>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-6">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-600 font-medium">Total Price</span>
                                <span class="text-2xl font-bold text-slate-900">
                                    ${{ product.price }}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-200">
                            <div class="text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-slate-700" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-900">Secure Payment</p>
                                <p class="text-xs text-slate-500">100% Protected</p>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-slate-700" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-900">Quality Verified</p>
                                <p class="text-xs text-slate-500">By {{ product.provider }}</p>
                            </div>
                            <div class="text-center">
                                <svg class="w-6 h-6 mx-auto mb-2 text-slate-700" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <p class="text-xs font-medium text-slate-900">Easy Returns</p>
                                <p class="text-xs text-slate-500">30-Day Policy</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-12">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-8 py-6 border-b border-slate-200">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Product Description
                    </h2>
                </div>
                <div class="px-8 py-8">
                    <p class="text-slate-600 leading-relaxed text-base">
                        {{ product.description }}
                    </p>
                </div>
            </div>
        </div>
        <reviews-list :product="props.product"></reviews-list>
    </div>
</template>

<style scoped>

</style>
