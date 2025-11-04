<script setup>
import {onMounted, ref} from "vue";
import FosJsRouting from "../../../js/fosJsRouting";
import UserService from "../../Services/UserService";
import CategoryDropdown from "../Category/CategoryDropdown.vue";
import {useCartStore} from "../../stores/useCartStore";
import CartService from "../../Services/CartService";
import CartItemService from "../../Services/CartItemService";
import CartItemEditDto from "../../dto/CartItem/CartItemEditDto";
import CartItemCreateDto from "../../dto/CartItem/CartItemCreateDto";

const isOpen = ref(false);
const user = ref(null);
const cartStore = useCartStore();

const handleLogout = () => {
    localStorage.removeItem("cart");
    localStorage.removeItem("isInitialized");
    window.location.href = FosJsRouting.generate('user_security_logout');
}

onMounted(() => {
    UserService.list().then((response) => {
        user.value = response.data.data;

        if (user.value && !cartStore.isInitialized) {
            CartService.list(user.value.id).then((cartResponse) => {

                CartItemService.list(cartResponse.data.data.id).then((cartItemsResponse) => {
                    const serverItems = cartItemsResponse.data.data.map((item) => ({
                        id: item.id,
                        product: item.product,
                        quantity: item.quantity,
                    }));

                    const allItems = [...serverItems];

                    const promises = cartStore.cart.map((localItem) => {
                        const existing = allItems.find((i) => i.product.id === localItem.product.id);

                        if (existing) {
                            localItem.quantity += existing.quantity;
                            return CartItemService.edit(existing.id, new CartItemEditDto({
                                quantity: localItem.quantity,
                                product: localItem.product.id,
                                cart: cartResponse.data.data.id,
                            }))
                        } else {
                            cartStore.cart.push(localItem);
                            allItems.push(localItem);
                            return CartItemService.new(
                                new CartItemCreateDto({
                                    quantity: localItem.quantity,
                                    product: localItem.product.id,
                                    cart: cartResponse.data.data.id,
                                })
                            )
                        }
                    });

                    Promise.all(promises).then(() => {
                        localStorage.setItem('cart', JSON.stringify(cartStore.cart));
                        localStorage.setItem("isInitialized", "true");
                    });
                });
            });
        }
    });
});
</script>


<template>
    <nav class="bg-gray-800 text-white sticky top-0 z-50 shadow-lg w-full">
        <div class="flex items-center lg:items-baseline px-4 lg:px-18 py-4">
            <button @click="isOpen = !isOpen" class="lg:hidden flex flex-col gap-1.5 z-50">
               <span
                   class="h-0.5 w-6 rounded-full bg-white transition"
                   :class="isOpen ? 'rotate-45 translate-y-[8px]' : ''"
               ></span>
                <span
                    class="h-0.5 w-6 rounded-full bg-white transition"
                    :class="isOpen ? 'opacity-0' : ''"
                ></span>
                <span
                    class="h-0.5 w-6 rounded-full bg-white transition"
                    :class="isOpen ? '-rotate-45 -translate-y-[8px]' : ''"
                ></span>
            </button>
            <a :href="FosJsRouting.generate('public_app_homepage')"
               class="flex items-center gap-1 lg:w-64 z-50 p-4 me-10">
                <div class="font-bold text-2xl tracking-wide">Ecommerce</div>
            </a>
            <div
                class="lg:flex lg:flex-row md:items-center font-medium text-lg fixed lg:static top-24 left-0 w-xs lg:w-auto h-screen lg:h-auto bg-gray-800 lg:bg-transparent pt-5 lg:pt-0 z-40 transition-transform duration-300 ease-in-out"
                :class="isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <ul class="flex flex-col lg:flex-row lg:gap-6  items-start">
                    <li><a href="" class="hover:text-yellow-300 lg:duration-300 px-4 py-2 block">About</a></li>
                    <li>
                        <category-dropdown :isOpen="isOpen"></category-dropdown>
                    </li>
                </ul>
            </div>
            <ul class="flex justify-end gap-4 items-center p-4 lg:p-1 lg:mt-0 w-full">
                <li class="relative">
                    <a :href="FosJsRouting.generate('shop_cart_show')"
                       class="flex items-center gap-2 hover:text-yellow-300 transition-colors duration-300 group">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            <span v-if="cartStore.cartCount > 0"
                                  class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                {{ cartStore.cartCount }}
                            </span>
                        </div>
                        <span class="hidden md:block">My cart</span>
                    </a>
                </li>
                <li class="relative">
                    <a href=""
                       class="flex items-center gap-2 hover:text-yellow-300 transition-colors duration-300 group">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                            </svg>
                            <span
                                class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">
                                99+
                            </span>
                        </div>
                        <span class="hidden md:block">Wishlist</span>
                    </a>
                </li>
                <li>
                    <a :href="FosJsRouting.generate('user_security_login')"
                       class="flex items-center gap-2 hover:text-yellow-300 transition-colors duration-300 group">
                        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span v-if="!user" class="hidden md:block">Account</span>
                        <span v-else class="hidden md:block">Hello, {{ user.firstName }} {{ user.lastName }}</span>
                    </a>
                </li>
                <li v-if="user">
                    <button @click="handleLogout"
                            class="flex items-center gap-2 hover:text-yellow-300 transition-colors duration-300">
                        Logout
                    </button>
                </li>
            </ul>
        </div>
    </nav>
</template>
