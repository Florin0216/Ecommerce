import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class CategoryService{
    categoriesList(args = {}) {
        const requestUrl = FosJsRouting.generate('shop_category_categories_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }

    newAdmin(category, args = {}) {
        const requestUrl = FosJsRouting.generate('admin_shop_category_new', args);

        return axios
            .post(requestUrl, {
                data: category
            });
    }

    editAdmin(categoryId, category, args = {}) {
        args.id = categoryId;

        const requestUrl = FosJsRouting.generate('admin_shop_category_edit', args);

        return axios
            .put(requestUrl, {
                data: category
            });
    }

    deleteAdmin(category, args = {}) {
        args.id = category.id;

        const requestUrl = FosJsRouting.generate('admin_shop_category_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new CategoryService();
