<script setup>
import ReviewService from "../../Services/ReviewService";
import {computed, onMounted, ref} from "vue";

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

const reviews = ref([]);

const getReviews = () => {
    ReviewService.list(props.product.id).then((response) => {
        reviews.value = response.data.data;
    })
}

const averageRating = computed(() => {
    if (reviews.value.length === 0) return 0;
    const sum = reviews.value.reduce((acc, review) => acc + review.rating, 0);
    return (sum / reviews.value.length).toFixed(2);
});

onMounted(() => {
    getReviews();
})
</script>

<template>
    <div class="flex items-center gap-2">
        <div class="flex">
            <div v-for="i in 5" :key="i" class="relative">
                <svg v-if="reviews.length"
                    class="w-4 h-4 text-gray-300"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                </svg>
                <div
                    v-if="averageRating >= i - 1 && averageRating < i"
                    class="absolute inset-0 overflow-hidden"
                    :style="{ width: `${(averageRating - (i - 1)) * 100}%` }"
                >
                    <svg
                        class="w-4 h-4 text-yellow-400"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                    </svg>
                </div>
                <svg
                    v-if="averageRating >= i"
                    class="w-4 h-4 text-yellow-400 absolute inset-0"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                </svg>
            </div>
        </div>

        <div v-if="averageRating" class="text-sm font-medium text-gray-800 flex mt-1">
            <span>{{ averageRating}}</span>
            <span class="text-gray-500 ms-1">({{ reviews.length }})</span>
        </div>
        <div v-else class="w-6 h-6"></div>
    </div>
</template>

<style scoped>

</style>
