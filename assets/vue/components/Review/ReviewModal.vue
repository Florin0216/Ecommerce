<script setup>
import {computed, ref} from "vue";
import ToastService from "../../Services/ToastService";
import ReviewService from "../../Services/ReviewService";
import ReviewCreateDto from "../../dto/Review/ReviewCreateDto";
import ReviewEditDto from "../../dto/Review/ReviewEditDto";

const props = defineProps({
    instance: {type: Object, required: true},
    review: {type: Object, required: true},
    product: {type: Object, required: true},
    user: {type: Object, required: true},
    isEditing: {type: Boolean, default: false},
});

const review = ref(JSON.parse(JSON.stringify(props.review)));
const isNewReview = computed(() => !review.value.id);

const onConfirm = () => {
    const promise = isNewReview.value
        ? ReviewService.new(new ReviewCreateDto({
            ...review.value,
            product: props.product.id,
            user: props.user.id
        }))
        : ReviewService.edit(review.value.id, new ReviewEditDto({
            ...review.value,
            product: props.product.id,
            user: props.user.id
        }));

    promise
        .then((response) => {
            review.value = response.data.data;
            props.isEditing = false;

            ToastService.show(
                isNewReview.value
                    ? "Review created successfully!"
                    : "Review updated successfully!",
                "success"
            );

            props.instance.value.close(true);
        })
        .catch((err) => {
            console.error(err);
        });
};

const setRating = (rating) => {
    review.value.rating = rating;
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
                        <template v-if="isNewReview">Add a review</template>
                        <template v-else>Review details</template>
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
                        <div class="space-y-3">
                            <label class="block text-sm font-medium text-gray-700">
                                Your Rating
                            </label>
                            <div class="flex items-center space-x-1">
                                <button
                                    v-for="index in 5"
                                    :key="index"
                                    :value="index"
                                    @click="setRating(index)"
                                    type="button"
                                    class="focus:outline-none transition-transform hover:scale-110"
                                    :class="{
                                        'text-yellow-400': index <= review.rating,
                                        'text-gray-300': index > review.rating
                                    }"
                                >
                                    <svg
                                        class="w-8 h-8"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.955a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.364 1.118l1.287 3.955c.3.921-.755 1.688-1.54 1.118L10 15.347l-3.448 2.674c-.785.57-1.84-.197-1.54-1.118l1.287-3.955a1 1 0 00-.364-1.118L2.562 9.382c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69L9.049 2.927z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <textarea
                                id="name"
                                v-model="review.comment"
                                class="w-full px-4 py-3 text-gray-900 placeholder-gray-500 bg-white border border-gray-300 rounded-lg shadow-sm
                                focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 resize-y min-h-40"
                                placeholder="Enter your message here..."
                                required
                            ></textarea>
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
                        <template v-if="isNewReview">Add</template>
                        <template v-else>Edit</template>
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
