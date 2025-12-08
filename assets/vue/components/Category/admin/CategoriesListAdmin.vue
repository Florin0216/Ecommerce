<script setup>
import {onMounted, ref} from "vue";
import ModalService from "../../../Services/ModalService";
import ToastService from "../../../Services/ToastService";
import CategoryService from "../../../Services/CategoryService";
import CategoryModal from "./CategoryModal.vue";
import CategoryModel from "../../../models/CategoryModel";

const categories = ref([]);

const getCategories = () => {
    CategoryService.categoriesList().then((response) => {
        categories.value = response.data.data;
    });
};

const openCategoryModal = (category = null, isEditing = false) => {
    ModalService.open({
        component: CategoryModal,
        props: {
            category: category ?? new CategoryModel(),
            isEditing: isEditing,
        },
    }).then(() => {
        getCategories();
    });
};

const onDelete = (category) => {
    CategoryService.deleteAdmin(category).then(() => {
        const index = categories.value.findIndex((c) => c.id === category.id);
        if (index !== -1) {
            categories.value.splice(index, 1);
        }
        ToastService.show("Category deleted successfully!", "success");
    });
};

onMounted(() => {
    getCategories();
});
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 p-4 md:p-8">
        <div class="max-w-full ml-0 md:ml-14 lg:ml-56 transition-all duration-300">
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-slate-800 mb-2">
                            Categories
                        </h1>
                        <p class="text-slate-600">
                            Manage your product categories
                        </p>
                    </div>
                    <button
                        @click="openCategoryModal()"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                    >
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Category
                    </button>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">
                <div v-if="categories.length > 0" class="overflow-x-auto">
                    <table class="w-full min-w-max">
                        <thead>
                        <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                ID
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap hidden sm:table-cell">
                                Description
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-slate-700 uppercase tracking-wider whitespace-nowrap">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        <tr
                            v-for="category in categories"
                            :key="category.id"
                            class="hover:bg-slate-50 transition-colors duration-150"
                        >
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-slate-900">
                                        #{{ category.id }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-semibold text-slate-900">
                                    {{ category.name }}
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell">
                                <div class="text-sm text-slate-600 max-w-xs truncate">
                                    {{ category.description }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        @click="openCategoryModal(category, true)"
                                        class="inline-flex items-center px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors duration-200"
                                        title="Edit"
                                    >
                                        <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="hidden md:inline">Edit</span>
                                    </button>
                                    <button
                                        @click="onDelete(category)"
                                        class="inline-flex items-center px-3 py-2 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium rounded-lg transition-colors duration-200"
                                        title="Delete"
                                    >
                                        <svg class="w-4 h-4 md:mr-1" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        <span class="hidden md:inline">Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div v-else class="p-8 md:p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg md:text-xl font-semibold text-slate-800 mb-2">
                            No categories yet
                        </h3>
                        <p class="text-slate-600 mb-6 text-sm md:text-base">
                            Get started by creating your first category to organize your products.
                        </p>
                        <button
                            @click="openCategoryModal()"
                            class="inline-flex items-center justify-center px-5 py-2.5 md:px-6 md:py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl text-sm md:text-base"
                        >
                            <svg class="w-4 h-4 md:w-5 md:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            Create First Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
