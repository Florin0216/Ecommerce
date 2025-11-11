<?php

namespace ShopBundle\Form\Type\Shipping;

use ShopBundle\Entity\Shipping;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('address')
            ->add('city')
            ->add('country')
            ->add('postalCode')
            ->add('phoneNumber')
            ->add('user');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Shipping::class,
            'csrf_protection' => false,
        ]);
    }

}
