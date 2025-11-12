class WishlistCreateDto{
    user = null;

    constructor(wishlist) {
        this.user = wishlist.user;
    }
}
export default WishlistCreateDto;
