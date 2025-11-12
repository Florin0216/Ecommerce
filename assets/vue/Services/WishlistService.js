import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class WishlistService {

    list(userId, args = {}) {
        args.id = userId;

        const requestUrl = FosJsRouting.generate('shop_wishlist_list', args);

        return axios
            .get(requestUrl);
    }

    new(wishlist, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_wishlist_new', args);

        return axios
            .post(requestUrl, {
                data: wishlist
            });
    }

    edit(wishlistId, wishlist, args = {}) {
        args.id = wishlistId;

        const requestUrl = FosJsRouting.generate('shop_wishlist_edit', args);

        return axios
            .put(requestUrl, {
                data: wishlist
            });
    }
}

export default new WishlistService();
