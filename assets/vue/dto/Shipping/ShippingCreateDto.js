class ShippingCreateDto{
    firstName = null;
    lastName = null;
    address = null;
    city = null;
    country = null;
    postalCode = null;
    phoneNumber = null;
    user = null;

    constructor(shipping) {
        this.firstName = shipping.firstName;
        this.lastName = shipping.lastName;
        this.address = shipping.address;
        this.city = shipping.city;
        this.country = shipping.country;
        this.postalCode = shipping.postalCode;
        this.phoneNumber = shipping.phoneNumber;
        this.user = shipping.user;
    }
}

export default ShippingCreateDto
