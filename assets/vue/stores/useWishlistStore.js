import {defineStore} from "pinia";
import {computed, ref} from "vue";

export const useWishlistStore = defineStore('wishlist', () => {
    const wishlist = ref(JSON.parse(localStorage.getItem('wishlist')) || [])

    return {wishlist};
});
