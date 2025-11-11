import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class ShippingService{
    listShipping(shippingId, args = {}) {
        args.id = shippingId;

        const requestUrl = FosJsRouting.generate('shop_shipping_shipping_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }
    list(user, args = {}) {
        args.id = user.id;

        const requestUrl = FosJsRouting.generate('shop_shipping_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }

    new(shipping, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_shipping_new', args);

        return axios
            .post(requestUrl, {
                data: shipping
            });
    }

    edit(shippingId, shipping, args = {}) {
        args.id = shippingId;

        const requestUrl = FosJsRouting.generate('shop_shipping_edit', args);

        return axios
            .put(requestUrl, {
                data: shipping
            });
    }
}

export default new ShippingService();
