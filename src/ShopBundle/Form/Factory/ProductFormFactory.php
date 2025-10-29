<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Product;
use ShopBundle\Form\Type\Product\ProductCreateType;
use ShopBundle\Form\Type\Product\ProductEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class ProductFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory,)
    {
    }

    public function getCreateForm(Product $product, array $options = []): FormInterface
    {
        return $this->formFactory->create(ProductCreateType::class, $product, $options);
    }

    public function getEditForm(Product $product, array $options = []): FormInterface
    {
        return $this->formFactory->create(ProductEditType::class, $product, $options);
    }

}
