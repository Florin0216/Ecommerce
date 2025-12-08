<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Wishlist;
use ShopBundle\Form\Factory\WishlistFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class WishlistController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected WishlistFormFactory    $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function showAction(): Response
    {
        return $this->render('@Shop/Wishlist/public/show.html.twig');
    }

    public function userWishlistShowAction($id): Response
    {
        $wishlist = $this->entityManager->getRepository(Wishlist::class)->findOneBy(['user' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlist, null, [
                AbstractNormalizer::GROUPS => Wishlist::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $wishlist = new Wishlist();

        $form = $this->formFactory->getCreateForm($wishlist);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($wishlist);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlist, null, [
                AbstractNormalizer::GROUPS => Wishlist::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $wishlist = $this->entityService->findOrReject(Wishlist::class, $id);

        $form = $this->formFactory->getEditForm($wishlist);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($wishlist, null, [
                AbstractNormalizer::GROUPS => Wishlist::NORMALIZER_GROUPS,
            ])
        ]);

    }

}
