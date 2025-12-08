import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class ReviewService{
    list(productId, args = {}) {
        args.id = productId;

        const requestUrl = FosJsRouting.generate('shop_review_product_reviews_list', args);

        return axios
            .get(requestUrl);
    }

    new(review, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_review_new', args);

        return axios
            .post(requestUrl, {
                data: review
            });
    }

    edit(reviewId, review, args = {}) {
        args.id = reviewId;

        const requestUrl = FosJsRouting.generate('shop_review_edit', args);

        return axios
            .put(requestUrl, {
                data: review
            });
    }

    delete(reviewId, args = {}) {
        args.id = reviewId;

        const requestUrl = FosJsRouting.generate('shop_review_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new ReviewService();
