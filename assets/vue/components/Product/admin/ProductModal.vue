<script setup>
import {computed, ref} from "vue";
import ProductService from "../../../Services/ProductService";
import ProductCreateDto from "../../../dto/Product/ProductCreateDto";
import ProductEditDto from "../../../dto/Product/ProductEditDto";
import ToastService from "../../../Services/ToastService";
import CategorySelect from "../../Category/admin/CategorySelect.vue";

const props = defineProps({
    instance: {type: Object, required: true},
    product: {type: Object, required: true},
    isEditing: {type: Boolean, default: false},
});

const product = ref(JSON.parse(JSON.stringify(props.product)));

const isNewProduct = computed(() => !product.value.id);

const onConfirm = () => {
    const promise = isNewProduct.value
        ? ProductService.newAdmin(new ProductCreateDto(product.value))
        : ProductService.editAdmin(product.value.id, new ProductEditDto(product.value));

    promise
        .then((response) => {
            product.value = response.data.data;
            props.isEditing = false;

            ToastService.show(
                isNewProduct.value
                    ? "Product created successfully!"
                    : "Product updated successfully!",
                "success"
            );

            props.instance.value.close(true);
        })
        .catch((err) => {
            console.error(err);
        });
};

const dismissModal = () => {
    props.instance.value.close(undefined);
};
</script>

<template>
    <div
        id="modalEl"
        tabindex="-1"
        aria-hidden="true"
        class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50
           justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] min-h-screen
           bg-black/60 transition-transform duration-600 ease-in-out"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm">
                <div class="flex items-center justify-between p-4 md:p-5 border-gray-400">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <template v-if="isNewProduct">Add product</template>
                        <template v-else>Product details</template>
                    </h3>
                    <button
                        @click="dismissModal"
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                   rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-hide="default-modal"
                    >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                    </button>
                </div>

                <div class="p-4 md:p-5 space-y-4">
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                Product Name: <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                v-model="product.name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Enter product name"
                                required
                            />
                        </div>

                        <div class="relative">
                            <label class="block mb-2 text-sm font-medium text-gray-900">
                                Categories: <span class="text-red-500">*</span>
                            </label>
                            <category-select v-model:selectedCategories="product.categories"></category-select>
                        </div>

                        <div>
                            <label for="summary" class="block mb-2 text-sm font-medium text-gray-900">
                                Summary: <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="summary"
                                v-model="product.summary"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Brief product summary"
                                required
                            />
                        </div>

                        <div>
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                                Description: <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="description"
                                v-model="product.description"
                                rows="4"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 resize-none"
                                placeholder="Detailed product description..."
                                required
                            ></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price" class="block mb-2 text-sm font-medium text-gray-900">
                                    Price: <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                    <input
                                        type="number"
                                        id="price"
                                        v-model="product.price"
                                        step="0.01"
                                        min="0"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full pl-7 p-2.5"
                                        placeholder="0.00"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label for="stock" class="block mb-2 text-sm font-medium text-gray-900">
                                    Stock Quantity: <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="stock"
                                    v-model="product.stock"
                                    min="0"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                         focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="0"
                                    required
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="provider" class="block mb-2 text-sm font-medium text-gray-900">
                                    Provider: <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="provider"
                                    v-model="product.provider"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                         focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors"
                                    placeholder="Provider name"
                                    required
                                />
                            </div>

                            <div>
                                <label for="delivery" class="block mb-2 text-sm font-medium text-gray-900">
                                    Delivery: <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="delivery"
                                    v-model="product.delivery"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                         focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 transition-colors"
                                    placeholder="e.g., 2-3 business days"
                                    required
                                />
                            </div>
                        </div>
                    </form>
                </div>

                <div class="flex justify-center items-center p-4 md:p-5 border-gray-200 rounded-b">
                    <button
                        @click="onConfirm"
                        type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none
                   focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center
                   dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        <template v-if="isNewProduct">Add</template>
                        <template v-else>Edit</template>
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
</style>
