<script setup>

import FosJsRouting from "../../../js/fosJsRouting";

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['toggleDropdown'])


const handleLogout = () => {
    localStorage.removeItem("cart");
    localStorage.removeItem("wishlist")
    localStorage.removeItem("isInitialized");
    window.location.href = FosJsRouting.generate('user_security_logout');
}
</script>

<template>
    <button @click="emit('toggleDropdown')" id="dropdownDefaultButton" data-dropdown-toggle="userDropdown"
            class="flex items-center hover:text-yellow-300 lg:duration-300 py-2 rounded-lg hover:bg-gray-800 transition-all"
            type="button">
        <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none"
             stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
        <span class="hidden ms-1 md:block">Account</span>
        <svg class="w-2.5 h-2.5 md:ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m1 1 4 4 4-4"/>
        </svg>
    </button>

    <div id="userDropdown" class="z-40 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-screen lg:w-44">
        <div v-if="user" class="px-4 py-3 text-sm text-gray-900 ">
            <div class="font-medium ">Hi, {{props.user.firstName }} {{ props.user.lastName }}</div>
            <div class="truncate">{{ props.user.email }}</div>
        </div>
        <ul v-if="user" class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
            <li v-if="props.user.roles[0] === 'ROLE_ADMIN'">
                <a :href="FosJsRouting.generate('admin_app_homepage')" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
            </li>
            <li v-if="props.user.roles[0] !== 'ROLE_ADMIN'">
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Details</a>
            </li>
            <li v-if="props.user.roles[0] !== 'ROLE_ADMIN'">
                <a :href="FosJsRouting.generate('shop_order_history_list')" class="block px-4 py-2 hover:bg-gray-100">Orders</a>
            </li>
            <li>
                <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
            </li>
        </ul>
        <ul v-else class="py-2 text-sm text-gray-700" aria-labelledby="dropdownInformdropdownAvatarNameButtonationButton">
            <li>
                <a :href="FosJsRouting.generate('user_registration_show')" class="block px-4 py-2 hover:bg-gray-100">Register</a>
            </li>
            <li>
                <a :href="FosJsRouting.generate('user_security_login')" class="block px-4 py-2 hover:bg-gray-100">Login</a>
            </li>
        </ul>
        <div v-if="user" class="py-2">
            <button @click="handleLogout" class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-start w-full">Sign out</button>
        </div>
    </div>
</template>

<style scoped>

</style>
