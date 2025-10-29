import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class UserService{
    list(args = {}) {
        let requestUrl = FosJsRouting.generate('public_user_user_show', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }
}

export default new UserService()
