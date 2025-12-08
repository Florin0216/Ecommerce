class ProductCreateDto{
    name = null;
    description = null;
    summary = null;
    price = null;
    stock = null;
    provider = null;
    delivery = null;
    categories = null;

    constructor(product) {
        this.name = product.name;
        this.description = product.description;
        this.summary = product.summary;
        this.price = product.price;
        this.stock = product.stock;
        this.provider = product.provider;
        this.delivery = product.delivery;
        this.categories = product.categories;
    }
}

export default ProductCreateDto
