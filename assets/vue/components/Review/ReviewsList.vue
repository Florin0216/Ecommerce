<script setup>
import {computed, onMounted, ref} from "vue";
import ReviewService from "../../Services/ReviewService";
import ModalService from "../../Services/ModalService";
import ReviewModal from "./ReviewModal.vue";
import ReviewModel from "../../models/ReviewModel";
import ToastService from "../../Services/ToastService";
import OrderService from "../../Services/OrderService";
import OrderItemService from "../../Services/OrderItemService";
import UserService from "../../Services/UserService";

const props = defineProps({
    product: {
        type: Object,
        required: true
    }
})

const user = ref(null);
const reviews = ref([]);
const userOrderProducts = ref([]);

const getReviews = () => {
    ReviewService.list(props.product.id).then((response) => {
        reviews.value = response.data.data;
    })
}

const getUserOrderItems = () => {
    if(user.value){
        OrderService.list(user.value).then((orderResponse) => {
            const filteredOrders = orderResponse.data.data.filter(o => o.status === 'completed');

            const itemPromises = filteredOrders.map(order => OrderItemService.list(order));

            return Promise.all(itemPromises);
        }).then((responses) => {
            userOrderProducts.value = responses.flatMap(r => r.data.data);
        })
    }
}

const openReviewModal = (review = null, isEditing = false) => {
    ModalService.open({
        component: ReviewModal,
        props: {
            review: review ?? new ReviewModel(),
            product: props.product,
            user: user.value,
            isEditing: isEditing,
        },
    }).then(() => {
        getReviews();
    });
};

const averageRating = computed(() => {
    if (reviews.value.length === 0) return 0;
    const sum = reviews.value.reduce((acc, review) => acc + review.rating, 0);
    return (sum / reviews.value.length).toFixed(2);
});

const ratingDistribution = computed(() => {
    const distribution = {5: 0, 4: 0, 3: 0, 2: 0, 1: 0};

    if (reviews.value.length === 0) return distribution;

    for (const review of reviews.value) {
        if (review.rating >= 1 && review.rating <= 5) {
            distribution[review.rating]++;
        }
    }
    return distribution;
})

const ratingPercentages = computed(() => {
    const total = reviews.value.length;
    if (total === 0) return {5: 0, 4: 0, 3: 0, 2: 0, 1: 0};

    const percentages = {};
    for (let i = 1; i <= 5; i++) {
        percentages[i] = ((ratingDistribution.value[i] / total) * 100).toFixed(1);
    }
    return percentages;
});

const userHasReview = computed(() => {
    return reviews.value.some(r => r.user.id === user.value.id);
});

const onDelete = (review) => {
    ReviewService.delete(review.id).then(() => {
        const index = reviews.value.findIndex((c) => c.id === review.id);
        if (index !== -1) {
            reviews.value.splice(index, 1);
        }
        ToastService.show("Review deleted successfully!", "success");
    });
};

onMounted(() => {
    UserService
        .show()
        .then((response) => {
            user.value = response.data.data;
            getUserOrderItems();
        })
    getReviews();
})
</script>

<template>
    <div class="max-w-7xl mx-auto mt-12 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-slate-100 px-8 py-6 border-b border-slate-200">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                        Customer Reviews
                    </h2>
                    <div v-if="user && userOrderProducts.find(o => o.product.id === props.product.id)">
                        <button
                            v-if="!userHasReview"
                            @click="openReviewModal()"
                            class="px-6 py-2.5 bg-slate-900 text-white rounded-lg font-semibold hover:bg-slate-800 transition-colors text-sm shadow-md hover:shadow-lg">
                            Write a Review
                        </button>

                        <div v-else class="flex justify-between gap-2">
                            <button
                                @click="openReviewModal(reviews.find(r => r.user.id === user.id),true)"
                                class="px-6 py-2.5 bg-amber-600 text-white rounded-lg font-semibold hover:bg-amber-500 transition-colors text-sm shadow-md hover:shadow-lg">
                                Edit Your Review
                            </button>
                            <button
                                @click="onDelete(reviews.find(r => r.user.id === user.id))"
                                class="px-6 py-2.5 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-500 transition-colors text-sm shadow-md hover:shadow-lg">
                                Delete Your Review
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 border-b border-slate-200 bg-slate-50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col items-center justify-center text-center">
                        <div class="text-5xl font-bold text-slate-900 mb-2">{{ averageRating }}</div>
                        <div class=" flex flex-row mb-2">
                            <div v-for="i in 5" :key="i" class="relative">
                                <svg v-if="reviews.length"
                                     class="w-6 h-6 text-gray-300"
                                     viewBox="0 0 20 20"
                                     fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg"
                                     aria-hidden="true"
                                >
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                </svg>
                                <div
                                    v-if="averageRating >= i - 1 && averageRating < i"
                                    class="absolute inset-0 overflow-hidden"
                                    :style="{ width: `${(averageRating - (i - 1)) * 100}%` }"
                                >
                                    <svg
                                        class="w-6 h-6 text-yellow-400"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                    </svg>
                                </div>
                                <svg
                                    v-if="averageRating >= i"
                                    class="w-6 h-6 text-yellow-400 absolute inset-0"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-slate-600 text-sm">Based on {{ reviews.length }} review(s)</p>
                    </div>
                    <div class="space-y-2">
                        <div v-for="rating in [5, 4, 3, 2, 1]" :key="rating" class="flex items-center gap-3">
                            <span class="text-sm font-medium text-slate-700 w-8">{{ rating }}★</span>
                            <div class="flex-1 h-3 bg-slate-200 rounded-full overflow-hidden">
                                <div
                                    class="h-full bg-yellow-400 rounded-full transition-all"
                                    :style="{ width: ratingPercentages[rating] + '%' }"
                                ></div>
                            </div>
                            <span class="text-sm text-slate-600 w-12 text-right">
                                    {{ ratingDistribution[rating] }}
                                </span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="divide-y divide-slate-200">
                <div v-for="review in reviews" :key="review.id"
                     class="px-8 py-6 hover:bg-slate-50 transition-colors">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-purple-500 flex items-center justify-center text-white font-semibold text-lg flex-shrink-0">
                                JD
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-900">{{ review.user.firstName }}
                                    {{ review.user.lastName }}</h3>
                                <div class="flex items-center mt-1">
                                    <div v-for="i in 5" :key="i" class="relative flex flex-row">
                                        <svg v-if="reviews.length"
                                             class="w- h-4 text-gray-300"
                                             viewBox="0 0 20 20"
                                             fill="currentColor"
                                             xmlns="http://www.w3.org/2000/svg"
                                             aria-hidden="true"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                        </svg>
                                        <div
                                            v-if="review.rating >= i - 1 && review.rating < i"
                                            class="absolute inset-0 overflow-hidden"
                                            :style="{ width: `${(review.rating - (i - 1)) * 100}%` }"
                                        >
                                            <svg
                                                class="w-4 h-4 text-yellow-400"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                xmlns="http://www.w3.org/2000/svg"
                                                aria-hidden="true"
                                            >
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                            </svg>
                                        </div>
                                        <svg
                                            v-if="review.rating >= i"
                                            class="w-4 h-4 text-yellow-400 absolute inset-0"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            xmlns="http://www.w3.org/2000/svg"
                                            aria-hidden="true"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-slate-600 leading-relaxed mb-4">
                        {{ review.comment }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
