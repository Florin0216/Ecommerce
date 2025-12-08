import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class DeliveryService{
    list(args = {}){
        const requestUrl = FosJsRouting.generate('shop_delivery_deliveries_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }
}

export default new DeliveryService();
