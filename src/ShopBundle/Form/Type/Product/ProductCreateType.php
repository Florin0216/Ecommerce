<?php

namespace ShopBundle\Form\Type\Product;

use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('summary')
            ->add('price')
            ->add('stock')
            ->add('provider')
            ->add('delivery')
            ->add('categories', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Category::class,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'csrf_protection' => false,
        ]);
    }

}
