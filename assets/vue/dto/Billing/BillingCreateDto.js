class BillingCreateDto{
    firstName = null;
    lastName = null;
    address = null;
    city = null;
    country = null;
    postalCode = null;
    phoneNumber = null;
    user = null;

    constructor(billing) {
        this.firstName = billing.firstName;
        this.lastName = billing.lastName;
        this.address = billing.address;
        this.city = billing.city;
        this.country = billing.country;
        this.postalCode = billing.postalCode;
        this.phoneNumber = billing.phoneNumber;
        this.user = billing.user;
    }
}

export default BillingCreateDto
