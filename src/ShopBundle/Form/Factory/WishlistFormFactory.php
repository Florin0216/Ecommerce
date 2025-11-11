<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Wishlist;
use ShopBundle\Form\Type\Wishlist\WishlistCreateType;
use ShopBundle\Form\Type\Wishlist\WishlistEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class WishlistFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Wishlist $wishlist, array $options = []): FormInterface
    {
        return $this->formFactory->create(WishlistCreateType::class, $wishlist, $options);
    }

    public function getEditForm(Wishlist $wishlist, array $options = []): FormInterface
    {
        return $this->formFactory->create(WishlistEditType::class, $wishlist, $options);
    }

}
