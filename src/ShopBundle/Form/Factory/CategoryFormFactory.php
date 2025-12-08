<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Category;
use ShopBundle\Form\Type\Category\CategoryCreateType;
use ShopBundle\Form\Type\Category\CategoryEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class CategoryFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory,)
    {
    }

    public function getCreateForm(Category $category, array $options = []): FormInterface
    {
        return $this->formFactory->create(CategoryCreateType::class, $category, $options);
    }

    public function getEditForm(Category $category, array $options = []): FormInterface
    {
        return $this->formFactory->create(CategoryEditType::class, $category, $options);
    }

}
