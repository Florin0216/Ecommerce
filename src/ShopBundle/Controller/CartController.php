<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Cart;
use ShopBundle\Form\Factory\CartFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CartController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected CartFormFactory        $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function showAction(): Response
    {
        return $this->render('@Shop/Cart/public/show.html.twig');
    }

    public function userCartShowAction($id): Response
    {
        $cart = $this->entityManager->getRepository(Cart::class)->findOneBy(['user' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($cart, null, [
                AbstractNormalizer::GROUPS => Cart::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $cart = new Cart();

        $form = $this->formFactory->getCreateForm($cart);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($cart);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($cart, null, [
                AbstractNormalizer::GROUPS => Cart::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $cart = $this->entityService->findOrReject(Cart::class, $id);

        $form = $this->formFactory->getEditForm($cart);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($cart, null, [
                AbstractNormalizer::GROUPS => Cart::NORMALIZER_GROUPS,
            ])
        ]);

    }

    public function deleteAction($id, Request $request): Response
    {
        $cart = $this->entityService->findOrReject(Cart::class, $id);

        $this->entityService->delete($cart);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
