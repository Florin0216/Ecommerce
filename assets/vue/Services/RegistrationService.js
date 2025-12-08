import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class RegistrationService {
    new(registration, args = {}) {
        const requestUrl = FosJsRouting.generate('user_registration_new', args);

        return axios
            .post(requestUrl, {
                data: registration
            })
    }
}

export default new RegistrationService()
