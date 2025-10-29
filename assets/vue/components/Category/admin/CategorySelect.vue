<script setup>
import CategoryService from "../../../Services/CategoryService";
import {onMounted, ref, watch} from "vue";

const selectedCategories = defineModel('selectedCategories', {
    type: Array,
    required: true,
});

const categories = ref([]);
const selectedCategoryIds = ref(selectedCategories.value?.map(s => s.id) || []);
const isDropdownOpen = ref(false);

const getCategories = () => {
    CategoryService.categoriesList().then((response) => {
        categories.value = response.data.data;
    });
};

const toggleCategory = (categoryId) => {
    const index = selectedCategoryIds.value.indexOf(categoryId);
    if (index > -1) {
        selectedCategoryIds.value.splice(index, 1);
    } else {
        selectedCategoryIds.value.push(categoryId);
    }
};

const removeCategory = (categoryId) => {
    const index = selectedCategoryIds.value.indexOf(categoryId);
    if (index > -1) {
        selectedCategoryIds.value.splice(index, 1);
    }
};

const isSelected = (categoryId) => {
    return selectedCategoryIds.value.includes(categoryId);
};

watch(selectedCategoryIds, () => {
    const newSelectedCategories = [];

    for (let id of selectedCategoryIds.value) {
        const category = categories.value.find(obj => obj.id === id);
        if (category) {
            newSelectedCategories.push(category.id);
        }
    }

    selectedCategories.value = newSelectedCategories;
},{ deep: true });

onMounted(() => {
    getCategories();
});
</script>

<template>
    <div v-if="selectedCategoryIds.length > 0" class="flex flex-wrap gap-2 mb-3">
        <div
            v-for="categoryId in selectedCategoryIds"
            :key="categoryId"
            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-full shadow-sm hover:shadow-md transition-all duration-200"
        >
            <span>{{ categories.find(c => c.id === categoryId)?.name }}</span>
            <button
                @click="removeCategory(categoryId)"
                type="button"
                class="hover:bg-white/20 rounded-full p-0.5 transition-colors"
            >
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <button
        @click="isDropdownOpen = !isDropdownOpen"
        type="button"
        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-2.5 flex items-center justify-between hover:bg-gray-100 transition-colors"
    >
            <span class="text-gray-500">
                {{ selectedCategoryIds.length > 0 ? `${selectedCategoryIds.length} selected` : 'Select categories' }}
            </span>
        <svg
            class="w-4 h-4 text-gray-500 transition-transform duration-200"
            :class="{ 'rotate-180': isDropdownOpen }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div
        v-show="isDropdownOpen"
        class="absolute z-50 w-full mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-80 overflow-hidden"
    >
        <div class="max-h-60 overflow-y-auto">
            <div
                v-for="category in categories"
                :key="category.id"
                @click="toggleCategory(category.id)"
                class="flex items-center px-4 py-3 hover:bg-blue-50 cursor-pointer transition-colors group"
            >
                <div class="flex items-center flex-1">
                    <div class="relative flex items-center justify-center w-5 h-5 mr-3">
                        <input
                            type="checkbox"
                            :checked="isSelected(category.id)"
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500 cursor-pointer"
                            @click.stop="toggleCategory(category.id)"
                        />
                    </div>

                    <div class="flex items-center flex-1">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">
                                {{ category.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
