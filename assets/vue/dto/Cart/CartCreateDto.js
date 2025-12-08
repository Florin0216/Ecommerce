class CartCreateDto{
    total = null;
    user = null;

    constructor(cart) {
        this.total = cart.total;
        this.user = cart.user;
    }
}

export default CartCreateDto
