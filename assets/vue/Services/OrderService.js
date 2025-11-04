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
}

export default new OrderService();
