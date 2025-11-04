<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\CartItem;
use ShopBundle\Form\Type\CartItem\CartItemCreateType;
use ShopBundle\Form\Type\CartItem\CartItemEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class CartItemFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(CartItem $cartItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(CartItemCreateType::class, $cartItem, $options);
    }

    public function getEditForm(CartItem $cartItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(CartItemEditType::class, $cartItem, $options);
    }

}
