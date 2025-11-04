<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\CartItem;
use ShopBundle\Form\Factory\CartItemFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CartItemController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected CartItemFormFactory     $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function listAction($id):Response
    {
        $cartItems = $this->entityManager->getRepository(CartItem::class)->findBy(['cart' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($cartItems, null, [
                AbstractNormalizer::GROUPS => CartItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $cartItem = new CartItem();

        $form = $this->formFactory->getCreateForm($cartItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($cartItem);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($cartItem, null, [
                AbstractNormalizer::GROUPS => CartItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $cartItem = $this->entityService->findOrReject(CartItem::class, $id);

        $form = $this->formFactory->getEditForm($cartItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($cartItem, null, [
                AbstractNormalizer::GROUPS => CartItem::NORMALIZER_GROUPS,
            ])
        ]);

    }

    public function deleteAction($id, Request $request): Response
    {
        $cartItem = $this->entityService->findOrReject(CartItem::class, $id);

        $this->entityService->delete($cartItem);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
