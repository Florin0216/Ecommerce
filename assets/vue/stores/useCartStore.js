import {defineStore} from "pinia";
import {computed, ref} from "vue";

export const useCartStore = defineStore('cart', () => {
    const cart = ref(JSON.parse(localStorage.getItem('cart')) || [])
    const isInitialized = ref(JSON.parse(localStorage.getItem("isInitialized") || "false"))
    const cartCount = computed(() => cart.value.reduce((total, item) => total + item.quantity, 0))
    const totalPrice = computed(() => cart.value.reduce((sum, item) => sum + item.product.price * item.quantity, 0))

    return {cart, isInitialized, cartCount, totalPrice};
});
