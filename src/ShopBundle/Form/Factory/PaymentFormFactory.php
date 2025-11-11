<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Payment;
use ShopBundle\Form\Type\Payment\PaymentCreateType;
use ShopBundle\Form\Type\Payment\PaymentEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class PaymentFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Payment $payment, array $options = []): FormInterface
    {
        return $this->formFactory->create(PaymentCreateType::class, $payment, $options);
    }

    public function getEditForm(Payment $payment, array $options = []): FormInterface
    {
        return $this->formFactory->create(PaymentEditType::class, $payment, $options);
    }

}
