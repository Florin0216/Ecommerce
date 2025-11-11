<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Delivery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class DeliveryController extends AbstractController
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EntityService          $entityService,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function listAction(): Response
    {
        $deliveryOptions = $this->entityManager->getRepository(Delivery::class)->findAll();

        return new JsonResponse([
            'data' => $this->serializer->normalize($deliveryOptions, null, [
                AbstractNormalizer::GROUPS => Delivery::NORMALIZER_GROUPS,
            ])
        ]);
    }

}
