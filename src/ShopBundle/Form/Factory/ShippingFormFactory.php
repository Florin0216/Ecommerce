<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Shipping;
use ShopBundle\Form\Type\Shipping\ShippingCreateType;
use ShopBundle\Form\Type\Shipping\ShippingEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class ShippingFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Shipping $shipping, array $options = []): FormInterface
    {
        return $this->formFactory->create(ShippingCreateType::class, $shipping, $options);
    }

    public function getEditForm(Shipping $shipping, array $options = []): FormInterface
    {
        return $this->formFactory->create(ShippingEditType::class, $shipping, $options);
    }

}
