import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class OrderItemService{
    new(orderItem, args = {}){
        const requestUrl = FosJsRouting.generate('shop_order_item_new', args);

        return axios
            .post(requestUrl, {
                data: orderItem
            });
    }
}

export default new OrderItemService()
