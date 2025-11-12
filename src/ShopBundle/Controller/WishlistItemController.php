<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\WishlistItem;
use ShopBundle\Form\Factory\WishlistItemFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class WishlistItemController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected WishlistItemFormFactory    $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function listAction($id):Response
    {
        $wishlistItems = $this->entityManager->getRepository(WishlistItem::class)->findBy(['wishlist' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlistItems, null, [
                AbstractNormalizer::GROUPS => WishlistItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $wishlistItem = new WishlistItem();

        $form = $this->formFactory->getCreateForm($wishlistItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($wishlistItem);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlistItem, null, [
                AbstractNormalizer::GROUPS => WishlistItem::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $wishlistItem = $this->entityService->findOrReject(WishlistItem::class, $id);

        $form = $this->formFactory->getEditForm($wishlistItem);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlistItem, null, [
                AbstractNormalizer::GROUPS => WishlistItem::NORMALIZER_GROUPS,
            ])
        ]);

    }

    public function deleteAction($id): Response
    {
        $wishlistItem = $this->entityService->findOrReject(WishlistItem::class, $id);

        $this->entityService->delete($wishlistItem);

        return new JsonResponse([
            'data' => []
        ]);
    }



}
