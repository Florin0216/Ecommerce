<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Order;
use ShopBundle\Form\Type\Order\OrderCreateType;
use ShopBundle\Form\Type\Order\OrderEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class OrderFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory,)
    {
    }

    public function getCreateForm(Order $order, array $options = []): FormInterface
    {
        return $this->formFactory->create(OrderCreateType::class, $order, $options);
    }

    public function getEditForm(Order $order, array $options = []): FormInterface
    {
        return $this->formFactory->create(OrderEditType::class, $order, $options);
    }

}
