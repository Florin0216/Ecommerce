<?php

namespace UserBundle\Controller;

use AppBundle\Services\EntityService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use UserBundle\Entity\User;

class UserController extends AbstractController
{
    public function __construct(
        protected EntityService $es,
        protected SerializerInterface $serializer,
    )
    {
    }

    public function showAction(Request $request): Response
    {
        return new JsonResponse([
            'data' => $this->serializer->normalize($this->getUser(), null, [
                'groups' => User::NORMALIZER_GROUPS,
            ])
        ]);
    }

}
