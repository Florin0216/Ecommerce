<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Shipping;
use ShopBundle\Form\Factory\ShippingFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ShippingController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected ShippingFormFactory        $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function listShippingAction($id, Request $request): Response
    {
        $shipments = $this->entityManager->getRepository(Shipping::class)->findOneBy(['id' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($shipments, null, [
                AbstractNormalizer::GROUPS => Shipping::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function listAction($id, Request $request): Response
    {
        $shipments = $this->entityManager->getRepository(Shipping::class)->findBy(['user' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($shipments, null, [
                AbstractNormalizer::GROUPS => Shipping::NORMALIZER_GROUPS,
            ])
        ]);
    }
    public function newAction(Request $request): Response
    {
        $shipping = new Shipping();

        $form = $this->formFactory->getCreateForm($shipping);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($shipping);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($shipping, null, [
                AbstractNormalizer::GROUPS => Shipping::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $shipping = $this->entityService->findOrReject(Shipping::class, $id);

        $form = $this->formFactory->getEditForm($shipping);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($shipping, null, [
                AbstractNormalizer::GROUPS => Shipping::NORMALIZER_GROUPS,
            ])
        ]);

    }

}
