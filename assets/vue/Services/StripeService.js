import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class StripeService{
    new(payload, args = {}){
        const requestUrl = FosJsRouting.generate('shop_stripe_new', args);

        return axios
            .post(requestUrl, {
                data: payload
            });
    }
}

export default new StripeService();
