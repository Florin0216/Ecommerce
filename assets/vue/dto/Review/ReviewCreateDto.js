class ReviewCreateDto{
    rating = null;
    comment = null;
    user = null;
    product = null;

    constructor(review) {
        this.rating = review.rating;
        this.comment = review.comment;
        this.user = review.user;
        this.product = review.product;
    }

}

export default ReviewCreateDto
