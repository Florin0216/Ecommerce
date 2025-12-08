<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\OrderItem;
use ShopBundle\Entity\Payment;
use ShopBundle\Form\Factory\PaymentFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class PaymentController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected PaymentFormFactory     $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function newAction(Request $request): Response
    {
        $payment = new Payment();

        $form = $this->formFactory->getCreateForm($payment);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $payment->setStatus('pending');
            $this->entityService->save($payment);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($payment, null, [
                AbstractNormalizer::GROUPS => Payment::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $payment = $this->entityService->findOrReject(Payment::class, $id);

        $form = $this->formFactory->getEditForm($payment);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($payment, null, [
                AbstractNormalizer::GROUPS => Payment::NORMALIZER_GROUPS,
            ])
        ]);

    }

    public function deleteAction($id, Request $request): Response
    {
        $payment = $this->entityService->findOrReject(Payment::class, $id);

        $this->entityService->delete($payment);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
