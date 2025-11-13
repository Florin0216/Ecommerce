<?php

namespace ShopBundle\Form\Factory;

use ShopBundle\Entity\Review;
use ShopBundle\Form\Type\Review\ReviewCreateType;
use ShopBundle\Form\Type\Review\ReviewEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class ReviewFormFactory
{
    public function __construct(protected FormFactoryInterface $formFactory)
    {
    }

    public function getCreateForm(Review $review, array $options = []): FormInterface
    {
        return $this->formFactory->create(ReviewCreateType::class, $review, $options);
    }

    public function getEditForm(Review $review, array $options = []): FormInterface
    {
        return $this->formFactory->create(ReviewEditType::class, $review, $options);
    }

}
