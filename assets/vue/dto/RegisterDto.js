class RegisterDto{
    email = null;
    username = null;
    firstName = null;
    lastName = null;
    password = null;

    constructor(registration) {
        this.email = registration.email;
        this.username = registration.username;
        this.firstName = registration.firstName;
        this.lastName = registration.lastName;
        this.password = registration.password;
    }
}

export default RegisterDto;
