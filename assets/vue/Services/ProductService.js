import FosJsRouting from "../../js/fosJsRouting";
import axios from "axios";

class ProductService {
    productsList(args = {}) {
        const requestUrl = FosJsRouting.generate('shop_product_products_list', args);

        return axios
            .get(requestUrl)
            .catch(err => console.error(err));
    }

    newAdmin(product, args = {}) {
        const requestUrl = FosJsRouting.generate('admin_shop_product_new', args);

        return axios
            .post(requestUrl, {
                data: product
            });
    }

    editAdmin(productId, product, args = {}) {
        args.id = productId;

        const requestUrl = FosJsRouting.generate('admin_shop_product_edit', args);

        return axios
            .put(requestUrl, {
                data: product
            });
    }

    deleteAdmin(product, args = {}) {
        args.id = product.id;

        const requestUrl = FosJsRouting.generate('admin_shop_product_delete', args);

        return axios
            .delete(requestUrl);
    }
}

export default new ProductService();
