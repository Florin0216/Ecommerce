class OrderItemCreateDto{
    quantity = null;
    product = null;
    order = null;

    constructor(orderItem) {
        this.quantity = orderItem.quantity;
        this.product = orderItem.product;
        this.order = orderItem.order;
    }
}

export default OrderItemCreateDto
