<script setup>
import {ref} from "vue";
import FosJsRouting from "../../../js/fosJsRouting";

const isOpen = ref(false);

const toggleSidebar = () => {
    isOpen.value = !isOpen.value;
};

const closeSidebar = () => {
    if (window.innerWidth < 1024) {
        isOpen.value = false;
    }
};
</script>

<template>
    <div>
        <button
            @click="toggleSidebar"
            class="lg:hidden fixed top-4 left-4 z-50 p-3 bg-gray-950 rounded-lg shadow-lg hover:bg-gray-800 transition-colors"
        >
            <div class="flex flex-col justify-center gap-1.5 items-center">
                <span
                    class="h-0.5 w-6 rounded-full bg-white transition-transform duration-300"
                    :class="isOpen ? 'rotate-45 translate-y-[8px]' : ''"
                ></span>
                <span
                    class="h-0.5 w-6 rounded-full bg-white transition-opacity duration-300"
                    :class="isOpen ? 'opacity-0' : ''"
                ></span>
                <span
                    class="h-0.5 w-6 rounded-full bg-white transition-transform duration-300"
                    :class="isOpen ? '-rotate-45 -translate-y-[8px]' : ''"
                ></span>
            </div>
        </button>

        <aside
            class="fixed lg:static inset-y-0 left-0 z-40 w-72 min-h-screen bg-gray-950 text-white shadow-xl transform transition-transform duration-300 ease-in-out flex flex-col"
            :class="isOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="p-6 border-b border-gray-800">
                <a
                    :href="FosJsRouting.generate('public_app_homepage')"
                    @click="closeSidebar"
                    class="flex items-center space-x-3"
                >
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center">
                        <span class="text-gray-950 font-bold text-xl">E</span>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold tracking-wide">Ecommerce</h1>
                        <p class="text-xs text-gray-400">Your Online Store</p>
                    </div>
                </a>
            </div>

            <nav class="flex-1 overflow-y-auto p-4">
                <div class="space-y-1">
                    <a
                        :href="FosJsRouting.generate('public_app_homepage')"
                        @click="closeSidebar"
                        class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span class="font-medium">Home</span>
                    </a>

                    <a
                        :href="FosJsRouting.generate('admin_shop_product_list')"
                        @click="closeSidebar"
                        class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="font-medium">Products</span>
                    </a>

                    <a
                        :href="FosJsRouting.generate('admin_shop_category_list')"
                        @click="closeSidebar"
                        class="flex items-center space-x-3 px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-yellow-300 rounded-lg transition-colors group"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                        <span class="font-medium">Categories</span>
                    </a>
                </div>

            </nav>

            <div class="p-4 border-t border-gray-800 space-y-2">

            </div>
        </aside>
    </div>
</template>

<style scoped>

</style>
