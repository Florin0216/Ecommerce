import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class WishlistItemService {

    list(wishlistId,args = {}){
        args.id = wishlistId;

        const requestUrl = FosJsRouting.generate('shop_wishlist_item_wishlist_wishlist_items_list', args);

        return axios
            .get(requestUrl);
    }

    new(wishlistItem, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_wishlist_item_new', args);

        return axios
            .post(requestUrl, {
                data: wishlistItem
            });
    }

    edit(wishlistItemId, wishlistItem, args = {}) {
        args.id = wishlistItemId;

        const requestUrl = FosJsRouting.generate('shop_wishlist_item_edit', args);

        return axios
            .put(requestUrl, {
                data: wishlistItem
            });
    }

    delete(wishlistItem, args = {}) {
        args.id = wishlistItem.id;

        const requestUrl = FosJsRouting.generate('shop_wishlist_item_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new WishlistItemService();
