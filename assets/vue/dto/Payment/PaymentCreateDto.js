class PaymentCreateDto{
    method = null;

    constructor(payment) {
        this.method = payment.method;
    }
}

export default PaymentCreateDto;
