class OrderCreateDto{
    total = null;
    status = null;
    billing = null;
    delivery = null;
    shipping = null;
    user = null;
    payment = null;

    constructor(order) {
        this.total = order.total;
        this.status = order.status;
        this.billing = order.billing;
        this.delivery = order.delivery;
        this.shipping = order.shipping;
        this.user = order.user;
        this.payment = order.payment;
    }
}

export default OrderCreateDto;
