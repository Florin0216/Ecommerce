<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Billing;
use ShopBundle\Entity\Shipping;
use ShopBundle\Form\Factory\BillingFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BillingController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected BillingFormFactory     $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }


    public function listAction($id, Request $request): Response
    {
        $billings = $this->entityManager->getRepository(Billing::class)->findBy(['user' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($billings, null, [
                AbstractNormalizer::GROUPS => Billing::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $billing = new Billing();

        $form = $this->formFactory->getCreateForm($billing);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($billing);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($billing, null, [
                AbstractNormalizer::GROUPS => Billing::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $billing = $this->entityService->findOrReject(Billing::class, $id);

        $form = $this->formFactory->getEditForm($billing);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($billing, null, [
                AbstractNormalizer::GROUPS => Billing::NORMALIZER_GROUPS,
            ])
        ]);

    }

}
