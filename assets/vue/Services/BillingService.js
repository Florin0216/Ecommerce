import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class BillingService{
    list(user, args = {}) {
        args.id = user.id;

        const requestUrl = FosJsRouting.generate('shop_billing_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }

    new(billing, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_billing_new', args);

        return axios
            .post(requestUrl, {
                data: billing
            });
    }

    edit(billingId, billing, args = {}) {
        args.id = billingId;

        const requestUrl = FosJsRouting.generate('shop_billing_edit', args);

        return axios
            .put(requestUrl, {
                data: billing
            });
    }
}

export default new BillingService();
