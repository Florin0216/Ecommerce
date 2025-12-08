import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class PaymentService{
    new(payment, args = {}) {
        const requestUrl = FosJsRouting.generate('shop_payment_new', args);

        return axios
            .post(requestUrl, {
                data: payment
            });
    }

    edit(paymentId, payment, args = {}) {
        args.id = paymentId;

        const requestUrl = FosJsRouting.generate('shop_payment_edit', args);

        return axios
            .put(requestUrl, {
                data: payment
            });
    }

    delete(payment, args = {}) {
        args.id = payment.id;

        const requestUrl = FosJsRouting.generate('shop_payment_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new PaymentService()
