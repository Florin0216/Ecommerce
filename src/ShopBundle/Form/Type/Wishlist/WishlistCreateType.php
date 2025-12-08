<?php

namespace ShopBundle\Form\Type\Wishlist;

use ShopBundle\Entity\Wishlist;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishlistCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
       $resolver->setDefaults([
           'data_class' => Wishlist::class,
           'csrf_protection' => false,
       ]);
    }

}
