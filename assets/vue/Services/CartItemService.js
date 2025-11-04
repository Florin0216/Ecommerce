import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class CartItemService{

    list(cartId,args = {}){
        args.id = cartId;

        const requestUrl = FosJsRouting.generate('shop_cart_item_list', args);

        return axios
            .get(requestUrl);
    }
    new(cartItem,args = {}){
        const requestUrl = FosJsRouting.generate('shop_cart_item_new', args);

        return axios
            .post(requestUrl, {
                data: cartItem
            });
    }

    edit(cartItemId,cartItem,args = {}){
        args.id = cartItemId;

        const requestUrl = FosJsRouting.generate('shop_cart_item_edit', args);

        return axios
            .put(requestUrl, {
                data: cartItem
            });
    }

    delete(cartItem, args = {}) {
        args.id = cartItem.id;

        const requestUrl = FosJsRouting.generate('shop_cart_item_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new CartItemService();
