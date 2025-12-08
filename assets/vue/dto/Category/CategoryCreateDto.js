class CategoryCreateDto{
    name = null;
    description = null;


    constructor(category) {
        this.name = category.name;
        this.description = category.description;
    }
}

export default CategoryCreateDto;
