<?php

namespace ShopBundle\Controller;

use AppBundle\Services\EntityService;
use Doctrine\ORM\EntityManagerInterface;
use ShopBundle\Entity\Review;
use ShopBundle\Form\Factory\ReviewFormFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ReviewController extends AbstractController
{
    public function __construct(
        protected EntityService          $entityService,
        protected EntityManagerInterface $entityManager,
        protected ReviewFormFactory      $formFactory,
        protected SerializerInterface    $serializer,
    )
    {
    }

    public function listReviewsAction($id): Response
    {
        $reviews = $this->entityManager->getRepository(Review::class)->findBy(['product' => $id]);

        return new JsonResponse([
            'data' => $this->serializer->normalize($reviews, null, [
                AbstractNormalizer::GROUPS => Review::NORMALIZER_GROUPS
            ])
        ]);
    }

    public function newAction(Request $request): Response
    {
        $review = new Review();

        $form = $this->formFactory->getCreateForm($review);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityService->save($review);
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($review, null, [
                AbstractNormalizer::GROUPS => Review::NORMALIZER_GROUPS,
            ])
        ]);
    }

    public function editAction($id, Request $request): Response
    {
        $review = $this->entityService->findOrReject(Review::class, $id);

        $form = $this->formFactory->getEditForm($review);

        $payload = json_decode($request->getContent(), true);
        $form->submit($payload['data'] ?? []);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'data' => $this->serializer->normalize($review, null, [
                AbstractNormalizer::GROUPS => Review::NORMALIZER_GROUPS,
            ])
        ]);

    }

    public function deleteAction($id): Response
    {
        $review = $this->entityService->findOrReject(Review::class, $id);

        $this->entityService->delete($review);

        return new JsonResponse([
            'data' => []
        ]);
    }

}
