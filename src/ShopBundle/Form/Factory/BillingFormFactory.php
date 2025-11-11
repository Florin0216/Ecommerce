<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Billing;
use ShopBundle\Form\Type\Billing\BillingCreateType;
use ShopBundle\Form\Type\Billing\BillingEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class BillingFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Billing $billing, array $options = []): FormInterface
    {
        return $this->formFactory->create(BillingCreateType::class, $billing, $options);
    }

    public function getEditForm(Billing $billing, array $options = []): FormInterface
    {
        return $this->formFactory->create(BillingEditType::class, $billing, $options);
    }

}
