<script setup>

import {ref} from "vue";
import FosJsRouting from "../../js/fosJsRouting";

const isOpen = ref(false);

</script>

<template>
    <nav class="bg-gray-950 text-white sticky top-0 z-50 shadow-lg w-full">
        <div class="flex justify-between items-center px-4 lg:px-18 py-4">
            <a :href="FosJsRouting.generate('public_app_homepage')" class="flex items-center gap-1 lg:w-64 z-50">
                <div class="font-bold text-2xl tracking-wide">Ecommerce</div>
            </a>
            <div
                class="lg:flex justify-between flex-col lg:flex-row md:items-center font-medium text-lg absolute lg:static top-0 left-0 w-screen h-screen lg:h-auto bg-gray-950 lg:bg-transparent pt-24 lg:pt-0 z-40 lg:transition-all lg:duration-300"
                :class="isOpen ? 'flex' : 'hidden'"
            >
                <ul class="flex flex-col lg:flex-row gap-6 lg:gap-6 items-center">
                    <li><a href="" class="hover:text-yellow-300 lg:duration-300">Despre</a></li>
                    <li><a :href="FosJsRouting.generate('shop_product_list')" class="hover:text-yellow-300 lg:duration-300">Produse</a></li>
                </ul>
                <ul class="flex flex-col md:flex-row justify-end gap-4 items-center p-4 lg:p-1 lg:mt-0 w-full lg:w-auto">
                    <li class="w-full text-center">
                        <a :href="FosJsRouting.generate('user_security_login')"
                           class="block hover:border-white border py-2 px-4 rounded-full border-gray-400 lg:duration-300">
                            Autentificare
                        </a>
                    </li>
<!--                    <li v-if="isAdmin(user)" class="w-full text-center">
                        <a href=""
                           class="block hover:border-white border py-2 px-4 rounded-full border-gray-400 lg:duration-300">
                            Administrare
                        </a>
                    </li>-->
                    <li class="w-full md:w-1/2 text-center">
                        <a :href="FosJsRouting.generate('user_registration_register')"
                           class="block hover:bg-green-600 py-2 px-4 rounded-full bg-green-700 lg:duration-300">
                            Inregistare
                        </a>
                    </li>
                </ul>
            </div>
            <button @click="isOpen = !isOpen" class="lg:hidden flex flex-col justify-center gap-1.5 items-center z-50">
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
        </div>
    </nav>
</template>
