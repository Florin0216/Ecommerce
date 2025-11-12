<script setup>
import {onMounted, ref} from "vue";
import {useWishlistStore} from "../../stores/useWishlistStore";
import UserService from "../../Services/UserService";
import WishlistService from "../../Services/WishlistService";
import WishlistItemService from "../../Services/WishlistItemService";
import {useCartStore} from "../../stores/useCartStore";
import CartService from "../../Services/CartService";
import CartItemService from "../../Services/CartItemService";
import CartItemEditDto from "../../dto/CartItem/CartItemEditDto";
import CartItemCreateDto from "../../dto/CartItem/CartItemCreateDto";

const wishlistItems = ref([]);
const wishlistStore = useWishlistStore();
const cartStore = useCartStore();
const user = ref(null);

const getWishlistItems = () => {
    wishlistItems.value = wishlistStore.wishlist;
}

const addToCart = (product) => {
    const existingProduct = cartStore.cart.find(i => i.product.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cartStore.cart.push({
            product: product,
            quantity: 1,
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
                                quantity: existingItem.quantity + 1,
                                product: product.id,
                                cart: cartResponse.data.data.id,
                            }))
                        } else {
                            CartItemService.new(
                                new CartItemCreateDto({
                                    quantity: 1,
                                    product: product.id,
                                    cart: cartResponse.data.data.id,
                                })
                            )
                        }
                    });
            })
    }
}

const removeFromWishlist = (product) => {
    if (user.value) {
        WishlistService
            .list(user.value.id)
            .then((wishlistResponse) => {
                WishlistItemService.list(wishlistResponse.data.data.id)
                    .then(wishlistItemsResponse => {
                        const existingItem = wishlistItemsResponse.data.data.find(item => item.product.id === product.id);
                        if (existingItem) {
                            WishlistItemService.delete(existingItem);
                        }
                    });
            })
    }

    const index = wishlistStore.wishlist.findIndex((item) => item.product.id === product.id);

    if (index !== -1) {
        wishlistStore.wishlist.splice(index, 1);
    }

    localStorage.setItem('wishlist', JSON.stringify(wishlistStore.wishlist));
}

onMounted(() => {
    getWishlistItems();
    UserService
        .list()
        .then((response) => {
            user.value = response.data.data;
        })
})
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-2">My Wishlist</h1>
                <p class="text-gray-600">{{ wishlistItems.length }} {{ wishlistItems.length === 1 ? 'item' : 'items' }}
                    in your wishlist</p>
            </div>

            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div>
                    <div v-for="(item, index) in wishlistItems" :key="item.id"
                         class="border-b border-gray-200 p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start space-x-4">
                            <div class="h-20 w-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                <img v-if="item.image" :src="item.image" :alt="item.name"
                                     class="h-full w-full object-cover">
                                <div v-else class="h-full w-full flex items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-gray-900 mb-1">{{ item.product.name }}</h3>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-lg font-bold text-gray-900">${{ item.product.price }}</span>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full"
                                          :class="item.product.stock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'">
                                        {{ item.product.stock ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-end">
                                    <div class="flex space-x-3">
                                        <button @click="addToCart(item.product)"
                                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </button>
                                        <button @click="removeFromWishlist(item.product)"
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="wishlistItems.length === 0" class="py-16 px-4 text-center">
                        <svg class="w-20 h-20 text-gray-300 mb-4 mx-auto" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Your wishlist is empty</h3>
                        <p class="text-gray-500 mb-6">Start adding items you love</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
