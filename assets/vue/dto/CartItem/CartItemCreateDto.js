class CartItemCreateDto{
    quantity =  null;
    product = null;
    cart = null;

    constructor(cartItem) {
        this.quantity = cartItem.quantity;
        this.product = cartItem.product;
        this.cart = cartItem.cart;
    }
}

export default CartItemCreateDto
