import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class RegistrationService {
    register(registration, args = {}) {
        args._format = 'json';

        const requestUrl = FosJsRouting.generate('user_registration_register', args);

        return axios
            .post(requestUrl, {
                data: registration
            })
    }
}

export default new RegistrationService()
