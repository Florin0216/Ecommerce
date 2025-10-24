<?php

namespace UserBundle\Form\Factory;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use UserBundle\Entity\User;
use UserBundle\Form\Type\Register\RegistrationCreateType;

class RegistrationFormFactory
{
    public function __construct(
        protected FormFactoryInterface $formFactory,
    )
    {
    }

    public function getCreateForm(User $user, array $options = []): FormInterface
    {
        return $this->formFactory->create(RegistrationCreateType::class, $user, $options);
    }

}
