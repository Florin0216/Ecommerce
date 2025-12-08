<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\OrderItem;
use ShopBundle\Form\Type\OrderItem\OrderItemCreateType;
use ShopBundle\Form\Type\OrderItem\OrderItemEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class OrderItemFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory,)
    {
    }

    public function getCreateForm(OrderItem $orderItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(OrderItemCreateType::class, $orderItem, $options);
    }

    public function getEditForm(OrderItem $orderItem, array $options = []): FormInterface
    {
        return $this->formFactory->create(OrderItemEditType::class, $orderItem, $options);
    }

}
