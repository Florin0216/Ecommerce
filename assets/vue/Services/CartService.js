import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class CartService {
    list(userId, args = {}) {
        args.id = userId;

        const requestUrl = FosJsRouting.generate('shop_cart_list', args);

        return axios
            .get(requestUrl);
    }

    new(cart, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_cart_new', args);

        return axios
            .post(requestUrl, {
                data: cart
            });
    }

    edit(cartId, cart, args = {}) {
        args.id = cartId;

        const requestUrl = FosJsRouting.generate('shop_cart_edit', args);

        return axios
            .put(requestUrl, {
                data: cart
            });
    }
}

export default new CartService();
