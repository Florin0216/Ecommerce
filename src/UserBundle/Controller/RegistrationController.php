<?php

namespace UserBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use UserBundle\Entity\User;
use UserBundle\Form\Factory\RegistrationFormFactory;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface  $em,
        protected EntityService           $es,
        protected RegistrationFormFactory $formFactory
    )
    {
    }

    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->formFactory->getCreateForm($user);

        $isHtmlRequest = $request->getRequestFormat() === 'html';

        if ($isHtmlRequest) {
            return $this->render('@User/Registration/register.html.twig');
        }

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();

            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $this->es->save($user);
        }

        return new JsonResponse([
            'data' => []
        ]);
    }

}
