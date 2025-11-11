import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class OrderService{
    new(order, args = {}){
        const requestUrl = FosJsRouting.generate('shop_order_new', args);

        return axios
            .post(requestUrl, {
                data: order
            });
    }

    delete(order, args = {}) {
        args.id = order.id;

        const requestUrl = FosJsRouting.generate('shop_order_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new OrderService();
