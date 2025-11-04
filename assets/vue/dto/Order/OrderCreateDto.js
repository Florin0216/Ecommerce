class OrderCreateDto{
    total = null;
    firstName = null;
    lastName  = null;
    email = null;
    address = null;
    city = null;
    country = null;
    postalCode = null;
    phoneNumber = null;
    user = null;

    constructor(order) {
        this.total = order.total;
        this.firstName = order.firstName;
        this.lastName = order.lastName;
        this.email = order.email;
        this.address = order.address;
        this.city = order.city;
        this.country = order.country;
        this.postalCode = order.postalCode;
        this.phoneNumber = order.phoneNumber;
        this.user = order.user;
    }
}

export default OrderCreateDto;
