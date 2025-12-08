<script setup>

import {ref} from "vue";
import RegistrationService from "../../Services/RegistrationService";
import RegisterDto from "../../dto/User/RegisterDto";
import FosJsRouting from "../../../js/fosJsRouting";
import CartService from "../../Services/CartService";
import CartCreateDto from "../../dto/Cart/CartCreateDto";
import ToastService from "../../Services/ToastService";
import WishlistService from "../../Services/WishlistService";
import WishlistCreateDto from "../../dto/Wishlist/WishlistCreateDto";

const userData = ref({});

const handleSubmit = () => {
    RegistrationService
        .new(new RegisterDto(userData.value))
        .then((response) => {
            return Promise.all([
                CartService.new(new CartCreateDto({
                    total: 0,
                    user: response.data.data.id
                })),
                WishlistService.new(new WishlistCreateDto({
                    user: response.data.data.id,
                }))
            ]);
        })
        .then(() => {
            ToastService.show("Account created successfully!", "success");
            userData.value = {};
        })
}

</script>

<template>
    <div class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                    <p class="text-gray-600">Join us today and get started</p>
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-5" novalidate>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input
                            type="email"
                            id="email"
                            v-model="userData.email"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="you@example.com"
                        />
                    </div>

                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            v-model="userData.username"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                            placeholder="johndoe"
                        />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">
                                First Name
                            </label>
                            <input
                                type="text"
                                id="firstName"
                                v-model="userData.firstName"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                                placeholder="John"
                            />
                        </div>
                        <div>
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">
                                Last Name
                            </label>
                            <input
                                type="text"
                                id="lastName"
                                v-model="userData.lastName"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                                placeholder="Doe"
                            />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                id="password"
                                v-model="userData.password"
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200 outline-none"
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 transition duration-200 transform hover:scale-105"
                    >
                        Create Account
                    </button>
                </form>

                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Already have an account?</span>
                    </div>
                </div>

                <div class="text-center">
                    <a :href="FosJsRouting.generate('user_security_login')"
                       class="text-indigo-600 hover:text-indigo-700 font-medium transition">
                        Sign in instead
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
