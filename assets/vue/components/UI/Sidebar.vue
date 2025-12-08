<script setup>
import {ref} from "vue";
import FosJsRouting from "../../../js/fosJsRouting";
import CategoryDropdown from "../Category/CategoryDropdown.vue";
import UserDropdown from "../User/UserDropdown.vue";

const isOpen = ref(false);

const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};
</script>

<template>
    <nav class="bg-gray-800 text-white min-h-screen top-0 z-50 shadow-lg fixed w-auto">
        <div class="flex flex-col items-start lg:items-baseline p-3 py-4 md:w-auto" :class="isOpen ? 'w-64' : 'w-14'">
            <div class="flex justify-center items-center mb-2">
                <button @click="toggleSidebar" class="lg:hidden flex flex-col gap-1.5 ">
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
                   class="flex items-center gap-1 sm:p-4">
                    <div class="font-bold text-2xl sm:text-4xl ms-2 tracking-wide"
                         :class="isOpen ? 'block' : 'hidden md:block'">Ecommerce
                    </div>
                </a>
            </div>
            <ul class="gap-4">
                <li><a
                    :href="FosJsRouting.generate('public_app_homepage')"
                    class="flex items-center space-x-3  md:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium" :class="isOpen ? 'block' : 'hidden md:block'">Home</span>
                </a></li>
                <li>
                    <a
                        :href="FosJsRouting.generate('admin_shop_product_list')"
                        class="flex items-center space-x-3 md:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="font-medium" :class="isOpen ? 'block' : 'hidden md:block'">Products</span>
                    </a>
                </li>
                <li>
                    <a
                        :href="FosJsRouting.generate('admin_shop_category_list')"
                        class="flex items-center space-x-3 md:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>

                        <span class="font-medium" :class="isOpen ? 'block' : 'hidden md:block'">Categories</span>
                    </a>
                </li>
                <li>
                    <a
                        :href="FosJsRouting.generate('admin_shop_order_list')"
                        class="flex items-center space-x-3 md:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 32 32" id="svg5" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <defs id="defs2"></defs>
                                <g id="layer1" transform="translate(-348,-484)">
                                    <path
                                        d="m 355,508.01367 a 1,1 0 0 0 -1,1 1,1 0 0 0 1,1 h 6 a 1,1 0 0 0 1,-1 1,1 0 0 0 -1,-1 z"
                                        id="path453757"
                                        style="fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;"></path>
                                    <path
                                        d="m 354,486.01367 a 1.0001,1.0001 0 0 0 -0.89453,0.55469 l -3,6.03516 a 1.0001,1.0001 0 0 0 -0.0996,0.42187 1.0001,1.0001 0 0 0 -0.006,0.0234 v 19.96484 a 1.0001,1.0001 0 0 0 1,1 h 26 a 1.0001,1.0001 0 0 0 1,-1 v -19.96484 a 1.0001,1.0001 0 0 0 0,-0.002 1.0001,1.0001 0 0 0 -0.10547,-0.44336 l -3,-6.03516 A 1.0001,1.0001 0 0 0 374,486.01367 Z m 0.61719,2 h 6.20898 l -0.65429,4.03516 h -7.5586 z m 8.23242,0 h 4.30273 l 0.67383,4.03516 h -5.6289 z m 6.33008,0 h 4.20117 l 2.00586,4.03516 h -5.5332 z M 352,494.04883 h 8 v 9.96484 a 1.0001,1.0001 0 0 0 1.70703,0.70703 L 365,501.42773 l 3.29297,3.29297 A 1.0001,1.0001 0 0 0 370,504.01367 v -9.96484 h 6 v 17.96484 h -24 z m 10,0 h 6 v 7.55078 l -2.29297,-2.29297 a 1.0001,1.0001 0 0 0 -1.41406,0 L 362,501.59961 Z"
                                        id="path453703"
                                        style="fill-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4.1;"></path>
                                </g>
                            </g>
                        </svg>
                        <span class="font-medium" :class="isOpen ? 'block' : 'hidden md:block'">Orders</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="min-h-screen w-14"></div>
</template>

<style scoped>

</style>
