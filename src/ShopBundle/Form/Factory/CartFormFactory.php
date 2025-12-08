<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Cart;
use ShopBundle\Form\Type\Cart\CartCreateType;
use ShopBundle\Form\Type\Cart\CartEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class CartFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Cart $cart, array $options = []): FormInterface
    {
        return $this->formFactory->create(CartCreateType::class, $cart, $options);
    }

    public function getEditForm(Cart $cart, array $options = []): FormInterface
    {
        return $this->formFactory->create(CartEditType::class, $cart, $options);
    }

}
