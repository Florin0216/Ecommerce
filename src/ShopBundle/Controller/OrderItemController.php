<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\OrderItem;
use ShopBundle\Form\Factory\OrderItemFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class OrderItemController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected OrderItemFormFactory       $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    #[IsGranted('ROLE_USER')]
    public function newAction(Request $request): Response
    {
        $orderItem = new OrderItem();

        $form = $this->formFactory->getCreateForm($orderItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantity = $form->get('quantity')->getData();
            $product = $form->get('product')->getData();

            $product->setStock($product->getStock() - $quantity);
            $this->entityService->save($orderItem);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($orderItem, null, [
                AbstractNormalizer::GROUPS => OrderItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

    #[IsGranted('ROLE_USER')]
    public function editAction($id, Request $request): Response
    {
        $orderItem = $this->entityService->findOrReject(OrderItem::class, $id);

        $form = $this->formFactory->getEditForm($orderItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($orderItem, null, [
                AbstractNormalizer::GROUPS => OrderItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

}
