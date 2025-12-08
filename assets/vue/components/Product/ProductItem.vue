<script setup>
import FosJsRouting from "../../../js/fosJsRouting";
import ReviewRating from "../Review/ReviewRating.vue";
import CartService from "../../Services/CartService";
import CartItemService from "../../Services/CartItemService";
import CartItemEditDto from "../../dto/CartItem/CartItemEditDto";
import CartItemCreateDto from "../../dto/CartItem/CartItemCreateDto";
import {useCartStore} from "../../stores/useCartStore";

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
})

const cartStore = useCartStore();

const addToCart = (product) => {
    console.log(product)
    const existingProduct = cartStore.cart.find(i => i.id === product.id);
    if (existingProduct) {
        existingProduct.quantity += 1;
    } else {
        cartStore.cart.push({
            product: product,
            quantity: 1,
        });
    }
    localStorage.setItem('cart', JSON.stringify(cartStore.cart));

    if (props.user) {
        CartService
            .list(props.user.id)
            .then((cartResponse) => {
                CartItemService.list(cartResponse.data.data.id)
                    .then(cartItemsResponse => {
                        const existingItem = cartItemsResponse.data.data.find(item => item.id === product.id);

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
</script>

<template>
    <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group">
        <a :href="FosJsRouting.generate('shop_product_product_show',{id: props.product.id})">
            <div class="relative overflow-hidden bg-gray-200 aspect-square">
                <img v-if="product.image"
                     :src="product.image"
                     :alt="product.name"
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"/>
                <div v-else
                     class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </a>
            <div class="p-5">
                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[3.5rem]">
                    {{ product.name }}
                </h3>

                <div v-if="product.stock" class="text-xs text-green-700 flex items-center">
                    <svg class="inline-block mr-1" width="10px" height="10px" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-current"
                              d="m10 0 .1.1s1.2 3.6 3.7 6c2.5 2.6 6 3.8 6 3.8l.2.1-.1.1s-3.6 1.2-6.1 3.7c-2.5 2.5-3.7 6-3.7 6l-.1.2-.1-.1s-1.2-3.6-3.7-6C3.7 11.2.2 10 .2 10H0l.1-.1s3.6-1.2 6.1-3.7c2.5-2.5 3.7-6 3.7-6L10 0"></path>
                    </svg>
                    in stock
                </div>

                <review-rating :product="product"></review-rating>

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-bold text-gray-900">
                                    ${{ product.price }}
                                </span>
                    </div>
                </div>

                <button @click="addToCart(props.product)"
                        class="w-full bg-gray-900 hover:bg-gray-800 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center whitespace-nowrap gap-2">
                    <span>Add to Cart</span>
                </button>
            </div>
    </div>
</template>

<style scoped>

</style>
