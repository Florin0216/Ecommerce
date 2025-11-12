<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\WishlistItem;
use ShopBundle\Form\Type\WishlistItem\WishlistItemCreateType;
use ShopBundle\Form\Type\WishlistItem\WishlistItemEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class WishlistItemFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(WishlistItem $wishlistItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(WishlistItemCreateType::class, $wishlistItem, $options);
    }

    public function getEditForm(WishlistItem $wishlistItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(WishlistItemEditType::class, $wishlistItem, $options);
    }

}
