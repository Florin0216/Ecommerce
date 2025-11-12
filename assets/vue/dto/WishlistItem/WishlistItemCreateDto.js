class WishlistItemCreateDto {
    product = null;
    wishlist = null;

    constructor(wishlistItem) {
        this.product = wishlistItem.product;
        this.wishlist = wishlistItem.wishlist
    }
}
export default WishlistItemCreateDto;
