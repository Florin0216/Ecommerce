import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class OrderItemService{

    list(order,args = {}){
        args.id = order.id;

        const requestUrl = FosJsRouting.generate('shop_order_item_list', args);

        return axios
            .get(requestUrl);
    }
    new(orderItem, args = {}){
        const requestUrl = FosJsRouting.generate('shop_order_item_new', args);

        return axios
            .post(requestUrl, {
                data: orderItem
            });
    }

    delete(orderItem, args = {}) {
        args.id = orderItem.id;

        const requestUrl = FosJsRouting.generate('shop_order_item_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new OrderItemService()
